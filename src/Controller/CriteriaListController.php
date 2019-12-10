<?php

namespace App\Controller;

use App\Entity\Criteria;
use App\Entity\CriteriaChoice;
use App\Factory\CompetenceViewFactory;
use App\Factory\ListViewFactory;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use App\Repository\CriteriaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CriteriaListController
 *
 * endpoints:
 * /api/criteria/list - All criteria list with competence name
 * /api/criterias/choices/creates - Creates new criteria with choices
 * /api/criterias/edits - Edits criteria title (need to post criteria id and criteria title)
 * /api/criterias/removes - Sets criteria non applicable (need to post criteria id)
 * /api/criterias/choices/edits - Edits choice title (need to post choice id and choice title)
 * /api/criterias/choices/removes - Sets choice non applicable (need to post choice id)
 * @package App\Controller
 */
class CriteriaListController extends AbstractFOSRestController
{
    /** @var CriteriaRepository  */
    private $criteriaRepository;

    /** @var CompetenceRepository  */
    private $competenceRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    /** @var CompetenceViewFactory  */
    private $competenceViewFactory;

    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var CriteriaChoiceRepository  */
    private $criteriaChoiceRepository;

    /** @var ListViewFactory */
    private $listViewFactory;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        CriteriaRepository $criteriaRepository,
        CompetenceRepository $competenceRepository,
        CompetenceViewFactory $competenceViewFactory,
        EntityManagerInterface $entityManager,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        ListViewFactory $listViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->competenceViewFactory = $competenceViewFactory;
        $this->criteriaRepository = $criteriaRepository;
        $this->competenceRepository = $competenceRepository;
        $this->entityManager = $entityManager;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
        $this->listViewFactory = $listViewFactory;
    }


    public function getCriteriaListAction()
    {
        $competenceList = $this->competenceRepository->findBy([
            'isApplicable' => 1
        ]);
        $this->listViewFactory->setViewFactory(CompetenceViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($competenceList)));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceCreateAction(Request $request)
    {
        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);

        $choices = (array_key_exists('choice', $data)) ? (array)$data : null;

        if (count($choices) < 2) {
            return new Response(Response::HTTP_NO_CONTENT);
        }

        $criteria = new Criteria();
        $criteriaChoice = new CriteriaChoice();
        $criteria->setFkCompetence($data['id']);
        $criteria->setTitle($data['title']);
        $criteria->setIsApplicable(1);
        $this->entityManager->persist($criteria);


        foreach ($choices as $key => $choice) {
            foreach ($choice as $item => $value) {
                $criteriaChoice->setFkCriteria($criteria);
                $criteriaChoice->setTitle($value['title']);
                $criteriaChoice->setIsApplicable(1);
                $this->entityManager->persist($criteriaChoice);
            }
        }
        $this->entityManager->flush();
        return new Response(Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaEditAction(Request $request)
    {
        if (!$this->renameRow($request, $this->criteriaRepository)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaRemoveAction(Request $request)
    {
        if (!$this->setRowNotApplicable($request, $this->criteriaRepository)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceEditAction(Request $request)
    {
        if (!$this->renameRow($request, $this->criteriaChoiceRepository)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceRemoveAction(Request $request)
    {

        if (!$this->setRowNotApplicable($request, $this->criteriaChoiceRepository)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(Response::HTTP_OK);
    }

    private function renameRow($request, $repository)
    {
        $data = json_decode($request->getContent(), true);
        $entity = $repository->findOneBy(['id' => $data['id']]);

        if (!$entity) {
            return false;
        }
        $entity->setTitle($data['title']);
        $this->entityManager->flush();
        return true;
    }

    private function setRowNotApplicable($request, $repository)
    {
        $data = json_decode($request->getContent(), true);
        $row = $repository->findOneBy(['id' => $data['id']]);

        if (!$row) {
            return false;
        }

        $row->setIsApplicable(0);
        $this->entityManager->flush();
        return true;
    }
}
