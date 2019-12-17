<?php

namespace App\Controller;

use App\Factory\FormViewFactory;
use App\Factory\UserAnswerListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\UserAnswerRepository;
use App\Repository\UserRepository;
use App\Request\UserAnswerRequest;
use App\Service\UserAnswerService;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAnswerController extends AbstractFOSRestController
{
    /** @var UserAnswerService */
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

    /** @var UserRepository */
    private $userRepository;

    /**
     * UserAnswerController constructor.
     * @param UserAnswerService $answerService
     * @param CareerFormRepository $careerFormRepository
     * @param UserAnswerRepository $userAnswerRepository
     * @param ViewHandlerInterface $viewHandler
     * @param FormViewFactory $formViewFactory
     * @param UserAnswerListViewFactory $userAnswerListViewFactory
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserAnswerService $answerService,
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        UserAnswerListViewFactory $userAnswerListViewFactory,
        UserRepository $userRepository
    ) {
        $this->userAnswerService = $answerService;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->userAnswerListViewFactory = $userAnswerListViewFactory;
        $this->userRepository = $userRepository;
    }


    /**
     * Post new UserAnswer (self evaluation)
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function postAnswerAction(Request $request)
    {
        $requestObject = new UserAnswerRequest($request);

        $careerForm = $this->careerFormRepository->findOneBy(['id' => $requestObject->getFormId()]);

        if ($careerForm) {
            $user = $this->userRepository->findOneBy(['id' => $careerForm->getFkUser()]);
            $this->denyAccessUnlessGranted('user', $user);
        }

        if (!$this->userAnswerService->handleSave($requestObject)) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $form = $this->careerFormRepository->findOneBy(['id' => $requestObject->getFormId()]);

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }

    /**
     * Get list of user answers by career form id (type of string passed by request)
     * @param string $slug
     * @return Response
     * @throws Exception
     */
    public function getAnswerAction(string $slug)
    {
        $careerForm = $this->careerFormRepository->findOneBy(['id' => $slug]);

        if ($careerForm) {
            $user = $this->userRepository->findOneBy(['id' => $careerForm->getFkUser()]);
            $this->denyAccessUnlessGranted('user', $user);
        }

        $answers = $this->userAnswerRepository->findBy(['fkCareerForm' => (int) $slug]);

        if (!$answers) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userAnswerListViewFactory->create($answers)));
    }
}
