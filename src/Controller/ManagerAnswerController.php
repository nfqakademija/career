<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Factory\ManagerAnswerViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerAnswerController extends AbstractFOSRestController
{
    private $userAnswerRepository;
    private $managerAnswerRepository;
    private $viewHandler;
    private $formListViewFactory;
    private $managerAnswerListViewFactory;


    public function __construct(
        ViewHandlerInterface $viewHandler,
        UserAnswerRepository $userAnswerRepository,
        FormListViewFactory $formListViewFactory,
        ManagerAnswerViewFactory $managerAnswerViewFactory,
        ManagerAnswerRepository $managerAnswerRepository
    ) {
        $this->viewHandler = $viewHandler;
        $this->formListViewFactory = $formListViewFactory;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->managerAnswerListViewFactory = $managerAnswerViewFactory;
        $this->managerAnswerRepository = $managerAnswerRepository;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function postFeedbackAction(Request $request)
    {

        $data = ((array)json_decode(((string)$request->getContent()), true))['data'];
        $formId = (array_key_exists('formId', $data)) ? (int)$data['formId'] : null;
        $feedback = (array_key_exists('formId', $data)) ? $data['feedback'] : null;

        var_dump($feedback);

        //return $this->viewHandler->handle(View::create($this->managerAnswerListViewFactory->create($managerAnswers)));
    }

    /**
     * @param $slug
     * @return Response
     */
    public function getFeedbackAction($slug)
    {
        $userAnswers = $this->userAnswerRepository->findBy(['fkCareerForm' => $slug]);
        $feedback = $this->managerAnswerRepository->findBy(['fkUserAnswer' => $userAnswers]);

        if (!$feedback) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->managerAnswerListViewFactory->create($feedback)));
    }
}
