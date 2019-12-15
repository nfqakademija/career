<?php

namespace App\Controller;

use App\Factory\CompetenceViewFactory;
use App\Factory\ListViewFactory;
use App\Repository\CompetenceRepository;
use App\Request\CriteriaListRequest;
use App\Service\CriteriaListService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
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
    /** @var CompetenceRepository */
    private $competenceRepository;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var CompetenceViewFactory */
    private $competenceViewFactory;

    /** @var ListViewFactory */
    private $listViewFactory;

    /** @var CriteriaListService */
    private $criteriaListService;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        CompetenceRepository $competenceRepository,
        CompetenceViewFactory $competenceViewFactory,
        ListViewFactory $listViewFactory,
        CriteriaListService $criteriaListService
    ) {
        $this->viewHandler = $viewHandler;
        $this->competenceViewFactory = $competenceViewFactory;
        $this->competenceRepository = $competenceRepository;
        $this->listViewFactory = $listViewFactory;
        $this->criteriaListService = $criteriaListService;
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
        $requestObject = new CriteriaListRequest($request);
        if (!$this->criteriaListService->handleCriteriaChoiceCreation($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode(['message' => 'Created']), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaEditAction(Request $request)
    {
        $requestObject = new CriteriaListRequest($request);
        if (!$this->criteriaListService->handleCriteriaUpdate($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode(['message' => 'Updated']), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaRemoveAction(Request $request)
    {
        $requestObject = new CriteriaListRequest($request);
        if (!$this->criteriaListService->handleCriteriaDelete($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode(['message' => 'Removed']), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceEditAction(Request $request)
    {
        $requestObject = new CriteriaListRequest($request);
        if (!$this->criteriaListService->handleCriteriaChoiceUpdate($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode(['message' => 'Updated']), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postCriteriaChoiceRemoveAction(Request $request)
    {
        $requestObject = new CriteriaListRequest($request);
        if (!$this->criteriaListService->handleCriteriaChoiceDelete($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return new Response(json_encode(['message' => 'Deleted']), Response::HTTP_OK);
    }
}
