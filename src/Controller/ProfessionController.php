<?php

namespace App\Controller;

use App\Repository\ProfessionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProfessionController
 *
 * endpoints:
 * /api/profession/list - get all profession registered
 *
 * @package App\Controller
 *
 */
class ProfessionController extends AbstractFOSRestController
{
    /** @var ProfessionRepository  */
    private $professionRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    public function __construct(
        ProfessionRepository $professionRepository,
        ViewHandlerInterface $viewHandler
    ) {
        $this->viewHandler = $viewHandler;
        $this->professionRepository = $professionRepository;
    }

    /**
     *
     * @return Response
     */
    public function getProfessionListAction()
    {
        $professionList = $this->professionRepository->findAll();

        return $this->viewHandler->handle(View::create($this->professionListViewFactory->create($professionList)));
    }
}
