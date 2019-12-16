<?php

namespace App\Controller;

use App\Factory\FormViewFactory;
use App\Factory\UserAnswerListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\UserAnswerRepository;
use App\Request\UserAnswerRequest;
use App\Service\UserAnswerService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAnswerController extends AbstractFOSRestController
{
    /** @var UserAnswerService  */
    private $userAnswerService;

    /** @var CareerFormRepository */
    private $careerFormRepository;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var FormViewFactory */
    private $formViewFactory;

    /** @var UserAnswerRepository */
    private $userAnswerRepository;

    /** @var UserAnswerListViewFactory */
    private $userAnswerListViewFactory;

    /**
     * UserAnswerController constructor.
     * @param UserAnswerService $answerService
     * @param CareerFormRepository $careerFormRepository
     * @param UserAnswerRepository $userAnswerRepository
     * @param ViewHandlerInterface $viewHandler
     * @param FormViewFactory $formViewFactory
     * @param UserAnswerListViewFactory $userAnswerListViewFactory
     */
    public function __construct(
        UserAnswerService $answerService,
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        UserAnswerListViewFactory $userAnswerListViewFactory
    ) {
        $this->userAnswerService = $answerService;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->userAnswerListViewFactory = $userAnswerListViewFactory;
    }


    /**
     * Post new UserAnswer (self evaluation)
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function postAnswerAction(Request $request)
    {
        $requestObject = new UserAnswerRequest($request);

        if (!$this->userAnswerService->handleSave($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $form = $this->careerFormRepository->findOneBy(['id' => $requestObject->getFormId()]);

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }

    /**
     * Get list of user answers by career form id
     * @param $slug
     * @return Response
     * @throws \Exception
     */
    public function getAnswerAction($slug)
    {
        $answers = $this->userAnswerRepository->findBy(['fkCareerForm' => $slug]);

        if (!$answers) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userAnswerListViewFactory->create($answers)));
    }
}
