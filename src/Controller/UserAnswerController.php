<?php

namespace App\Controller;

use App\Factory\FormViewFactory;
use App\Factory\UserAnswerListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Repository\UserAnswerRepository;
use App\Service\UserAnswerService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var CriteriaChoiceRepository */
    private $criteriaChoiceRepository;

    /** @var UserAnswerListViewFactory */
    private $userAnswerListViewFactory;


    public function __construct(
        UserAnswerService $answerService,
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        UserAnswerListViewFactory $userAnswerListViewFactory
    ) {
        $this->userAnswerService = $answerService;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->criteriaRepository = $criteriaRepository;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
        $this->userAnswerListViewFactory = $userAnswerListViewFactory;
    }


    /**
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function postAnswerAction(Request $request)
    {
        $requestBody = $this->userAnswerService->dispatchJson($request, [
            'formId',
            'choiceAnswers',
            'commentAnswers'
        ]);

        $formId = $requestBody['formId'];

        if (!$formId) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $answers = $requestBody['choiceAnswers'];
        $comments = $requestBody['commentAnswers'];

        $form = $this->careerFormRepository->findOneBy(['id' => $formId]);

        $choices = $this->criteriaChoiceRepository->findBy([
            'id' => $this->userAnswerService->extractIds($answers, 'choiceId')]);

        if ($choices) {
            $this->userAnswerService->saveUserChoices($choices, $form);
        }

        if ($comments) {
            $this->userAnswerService->saveUserComments($comments, $form);
        }

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }

    /**
     *
     * @param $slug
     * @return Response
     * @throws \Exception
     */
    public function getAnswerAction(int $slug)
    {
        $answers = $this->userAnswerRepository->findBy(['fkCareerForm' => $slug]);

        if (!$answers) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userAnswerListViewFactory->create($answers)));
    }
}
