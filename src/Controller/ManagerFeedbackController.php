<?php

namespace App\Controller;

use App\Factory\FormViewFactory;
use App\Factory\ManagerAnswerListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use App\Request\ManagerFeedbackRequest;
use App\Service\ManagerFeedbackService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerFeedbackController extends AbstractFOSRestController
{
    /** @var UserAnswerRepository  */
    private $userAnswerRepository;

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    /** @var ManagerAnswerListViewFactory  */
    private $managerAnswerListViewFactory;

    /** @var ManagerFeedbackService  */
    private $managerFeedbackService;

    /** @var FormViewFactory  */
    private $formViewFactory;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    /**
     * ManagerFeedbackController constructor.
     * @param ViewHandlerInterface $viewHandler
     * @param UserAnswerRepository $userAnswerRepository
     * @param ManagerAnswerListViewFactory $managerAnswerListViewFactory
     * @param ManagerAnswerRepository $managerAnswerRepository
     * @param ManagerFeedbackService $managerFeedbackService
     * @param FormViewFactory $formViewFactory
     * @param CareerFormRepository $careerFormRepository
     */
    public function __construct(
        ViewHandlerInterface $viewHandler,
        UserAnswerRepository $userAnswerRepository,
        ManagerAnswerListViewFactory $managerAnswerListViewFactory,
        ManagerAnswerRepository $managerAnswerRepository,
        ManagerFeedbackService $managerFeedbackService,
        FormViewFactory $formViewFactory,
        CareerFormRepository $careerFormRepository
    ) {
        $this->viewHandler = $viewHandler;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->managerAnswerListViewFactory = $managerAnswerListViewFactory;
        $this->managerAnswerRepository = $managerAnswerRepository;
        $this->managerFeedbackService = $managerFeedbackService;
        $this->formViewFactory = $formViewFactory;
        $this->careerFormRepository = $careerFormRepository;
    }

    /**
     * Post new manager answer/feedback
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function postFeedbackAction(Request $request)
    {
        $requestObject = new ManagerFeedbackRequest($request);

        if (!$this->managerFeedbackService->handleSave($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $form = $this->careerFormRepository->findOneBy(['id' => $requestObject->getFormId()]);

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }

    /**
     * Get manager answers/feedback by career form id (type of string passed by request)
     * @param string $slug
     * @return Response
     */
    public function getFeedbackAction(string $slug)
    {
        $userAnswers = $this->userAnswerRepository->findBy(['fkCareerForm' => (int) $slug]);
        $feedback = $this->managerAnswerRepository->findBy(['fkUserAnswer' => $userAnswers]);

        if (!$feedback) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->managerAnswerListViewFactory->create($feedback)));
    }
}
