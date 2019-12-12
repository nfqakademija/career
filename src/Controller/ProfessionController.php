<?php

namespace App\Controller;

use App\Factory\ListViewFactory;
use App\Factory\ProfessionViewFactory;
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

    /** @var ListViewFactory  */
    private $listViewFactory;

    public function __construct(
        ProfessionRepository $professionRepository,
        ViewHandlerInterface $viewHandler,
        ListViewFactory $listViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->professionRepository = $professionRepository;
        $this->listViewFactory = $listViewFactory;
    }

    /**
     *
     * @return Response
     */
    public function getProfessionListAction()
    {
        $professionList = $this->professionRepository->findAll();
        $this->listViewFactory->setViewFactory(ProfessionViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($professionList)));
    }
}
