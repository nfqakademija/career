<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Repository\CareerFormRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

class ManagerAnswerController extends AbstractFOSRestController
{
    private $careerFormRepository;
    private $viewHandler;
    private $formListViewFactory;


    public function __construct(
        ViewHandlerInterface $viewHandler,
        CareerFormRepository $careerFormRepository,
        FormListViewFactory $formListViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->formListViewFactory = $formListViewFactory;
        $this->careerFormRepository = $careerFormRepository;
    }

    /**
     * @param Request $request
     */
    public function postFeedbackAction(Request $request)
    {
    }

    /**
     * @param $slug
     */
    public function getFeedbackAction($slug)
    {
    }
}
