<?php

namespace App\Controller;

use App\Factory\ProfessionListViewFactory;
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
    /** @var ProfessionRepository */
    private $professionRepository;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ProfessionListViewFactory*/
    private $professionListViewFactory;

    public function __construct(
        ProfessionRepository $professionRepository,
        ViewHandlerInterface $viewHandler,
        ProfessionListViewFactory $professionListViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->professionRepository = $professionRepository;
        $this->professionListViewFactory = $professionListViewFactory;
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
