<?php

namespace App\Controller;

use App\Entity\Criteria;
use App\Repository\CompetenceRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\CriteriaRepository;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CriteriaListController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $competenceRepository = null;

    public function __construct(CriteriaRepository $criteriaRepository, CompetenceRepository $competenceRepository)
    {
        $this->criteriaRepository = $criteriaRepository;
        $this->competenceRepository = $competenceRepository;
    }

    /**
     * @return Response
     */
    public function getCriteriaListAction()
    {
        $criteriaList = $this->criteriaRepository->findBy([
            'isApplicable' => 1
        ]);
        // Tip : Inject SerializerInterface $serializer in the controller method
// and avoid these 3 lines of instanciation/configuration
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
// Serialize your object in Json
        $jsonObject = $serializer->serialize($criteriaList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
// For instance, return a Response with encoded Json
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @param string $title
     * @return Criteria[]
     */
    public function getCriteriaAction(string $title)
    {
        return $this->criteriaRepository->fetchByCompetence($title);
    }

    public function getCompetenceListAction()
    {
        $competenceList = $this->competenceRepository->findBy([
            'isApplicable' => 1
        ]);
        // Tip : Inject SerializerInterface $serializer in the controller method
// and avoid these 3 lines of instanciation/configuration
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
// Serialize your object in Json
        $jsonObject = $serializer->serialize($competenceList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
// For instance, return a Response with encoded Json
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
