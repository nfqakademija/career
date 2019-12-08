<?php

namespace App\Controller;

use App\Factory\TeamViewFactory;
use App\Repository\TeamRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Class TeamController
 *
 * endpoints:
 * /api/teams/list - get all teams list;
 * @package App\Controller
 */
class TeamController extends AbstractFOSRestController
{
    /** @var TeamRepository */
    private $teamRepository;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var TeamViewFactory */
    private $teamViewFactory;

    public function __construct(
        TeamRepository $teamRepository,
        ViewHandlerInterface $viewHandler,
        TeamViewFactory $teamViewFactory
    ) {
        $this->teamRepository = $teamRepository;
        $this->viewHandler = $viewHandler;
        $this->teamViewFactory = $teamViewFactory;
    }


    public function getTeamsListAction()
    {
        $teams = $this->teamRepository->findAll();

        if (!$teams) {
            // teams not found
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->teamViewFactory->create($teams)));
    }
}
