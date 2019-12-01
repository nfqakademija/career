<?php

namespace App\Controller;

use App\Entity\Team;
use App\Factory\TeamViewFactory;
use App\Repository\TeamRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;


/**
 * Class TeamController
 *
 * endpoints:
 * /api/teams/list - get all teams list; TODO: get all teams;
 * @package App\Controller
 */
class TeamController extends AbstractFOSRestController
{

    private $teamRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $viewHandler;
    private $teamViewFactory;

    public function __construct(
        TeamRepository $teamRepository,
        ViewHandlerInterface $viewHandler,
        TeamViewFactory $teamViewFactory
    )
    {
        $this->teamRepository = $teamRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
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
