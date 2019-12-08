<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Factory\ManagerAnswerViewFactory;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

class ManagerAnswerController extends AbstractFOSRestController
{
    /** @var UserAnswerRepository  */
    private $userAnswerRepository;

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    /** @var FormListViewFactory  */
    private $formListViewFactory;

    /** @var ManagerAnswerViewFactory  */
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


    public function postFeedbackAction()
    {
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
