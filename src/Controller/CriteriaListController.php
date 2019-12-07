<?php

namespace App\Controller;

use App\Entity\Criteria;
use App\Entity\CriteriaChoice;
use App\Factory\CompetenceListViewFactory;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use App\Repository\CriteriaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CriteriaListController
 *
 * endpoints:
 * /api/criterias - All criteria list with competence name
 * /api/competences - competence list with their criteria list and criteria choice list
 * /api/criterias/{slug} - Criteria list fetched by competence title
 * /api/choices/{slug} - Criteria Choice list fetched by criteria id
 * /api/criterias/creates - Creates new criteria for competence (need to post competence id and criteria title)
 * /api/criterias/edits - Edits criteria title (need to post criteria id and criteria title)
 * /api/criterias/removes - Sets criteria non applicable (need to post criteria id)
 * /api/criterias/choices/creates - Creates new choice for criteria (need to post criteria id and choice title)
 * /api/criterias/choices/edits - Edits choice title (need to post choice id and choice title)
 * /api/criterias/choices/removes - Sets choice non applicable (need to post choice id)
 * @package App\Controller
 */
class CriteriaListController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $competenceRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $viewHandler;
    private $competenceListViewFactory;
    private $entityManager;
    private $criteriaChoiceRepository;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        CriteriaRepository $criteriaRepository,
        CompetenceRepository $competenceRepository,
        CompetenceListViewFactory $competenceListViewFactory,
        EntityManagerInterface $entityManager,
        CriteriaChoiceRepository $criteriaChoiceRepository
    ) {
        $this->viewHandler = $viewHandler;
        $this->competenceListViewFactory = $competenceListViewFactory;
        $this->criteriaRepository = $criteriaRepository;
        $this->competenceRepository = $competenceRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
        $this->entityManager = $entityManager;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
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


    public function getCompviewAction()
    {
        $competenceList = $this->competenceRepository->findBy([
            'isApplicable' => 1
        ]);

        return $this->viewHandler->handle(View::create($this->competenceListViewFactory->create($competenceList)));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaCreateAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteriaEntity = new Criteria();
        $criteriaEntity->setFkCompetence($data['id']);
        $criteriaEntity->setTitle($data['title']);
        $criteriaEntity->setIsApplicable(1);
        $this->entityManager->persist($criteriaEntity);
        $this->entityManager->flush();
        return new Response(Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaEditAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteria = $this->criteriaRepository->findOneBy(['id' => $data['id']]);

        if (!$criteria) {
            // fail to find criteria
            return new Response(Response::HTTP_NOT_FOUND);
        }
        $criteria->setTitle($data['title']);
        $this->entityManager->flush();
        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaRemoveAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteria = $this->criteriaRepository->findOneBy(['id' => $data['id']]);

        if (!$criteria) {
            // fail to find criteria
            return new Response(Response::HTTP_NOT_FOUND);
        }
        $criteria->setIsApplicable(0);
        $this->entityManager->flush();
        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceCreateAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteriaChoiceEntity = new CriteriaChoice();
        $criteriaChoiceEntity->setFkCompetence($data['id']);
        $criteriaChoiceEntity->setTitle($data['title']);
        $criteriaChoiceEntity->setIsApplicable(1);
        $this->entityManager->persist($criteriaChoiceEntity);
        $this->entityManager->flush();
        return new Response(Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceEditAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteriaChoice = $this->criteriaRepository->findOneBy(['id' => $data['id']]);

        if (!$criteriaChoice) {
            // fail to find criteriaChoice
            return new Response(Response::HTTP_NOT_FOUND);
        }
        $criteriaChoice->setTitle($data['title']);
        $this->entityManager->flush();
        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceRemoveAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);
        $criteriaChoice = $this->criteriaRepository->findOneBy(['id' => $data['id']]);

        if (!$criteriaChoice) {
            // fail to find criteriaChoice
            return new Response(Response::HTTP_NOT_FOUND);
        }
        $criteriaChoice->setIsApplicable(0);
        $this->entityManager->flush();
        return new Response(Response::HTTP_OK);
    }
}
