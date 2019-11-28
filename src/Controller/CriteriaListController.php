<?php

namespace App\Controller;

use App\Repository\CompetenceRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\CriteriaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CriteriaListController
 *
 * routes:
 * /api/criterias - All criteria list with competence name
 * /api/competences - competence list with their criteria list and criteria choice list
 * /api/criterias/{slug} - Criteria list fetched by competence title
 * /api/choices/{slug} - Criteria Choice list fetched by criteria id
 *
 * @package App\Controller
 */
class CriteriaListController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $competenceRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;

    public function __construct(
        CriteriaRepository $criteriaRepository,
        CompetenceRepository $competenceRepository
    )
    {
        $this->criteriaRepository = $criteriaRepository;
        $this->competenceRepository = $competenceRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     * @return Response
     */
    public function getCriteriasAction()
    {
        $criteriaList = $this->competenceRepository->fetchApplicable();
        $jsonObject = $this->serializer->serialize($criteriaList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @param string $slug
     * @return Response
     */
    public function getCriteriaAction(string $slug)
    {
        $criteriaList = $this->competenceRepository->fetchApplicableByCompetence($slug);

        $jsonObject = $this->serializer->serialize($criteriaList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }


    /**
     * @return Response
     */
    public function getCompetencesAction()
    {
        $competenceList = $this->competenceRepository->findBy([
            'isApplicable' => 1
        ]);

        $jsonObject = $this->serializer->serialize($competenceList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @param string $slug
     * @return Response
     */
    public function getChoiceAction(string $slug)
    {
        $choiceList = $this->criteriaRepository->fetchChoicesByCriteria($slug);

        $jsonObject = $this->serializer->serialize($choiceList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

}
