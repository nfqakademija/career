<?php

namespace App\Controller;

use App\Entity\UserAnswer;
use App\Factory\FormViewFactory;
use App\Factory\UserAnswerListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Repository\UserAnswerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAnswerController extends AbstractFOSRestController
{

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
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        UserAnswerListViewFactory $userAnswerListViewFactory
    ) {
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
        $requestBody = $this->dispatchJson($request);

        $formId = $requestBody['formId'];
        $answers = $requestBody['choiceAnswers'];
        $comments = $requestBody['commentAnswers'];

        $choiceIds = array();
        foreach ($answers as $answerId => $answerBody) {
            foreach ($answerBody as $key => $value) {
                if ($key === 'choiceId') {
                    $choiceIds[] = (int)$value;
                }
            }
        }

        $choices = $this->criteriaChoiceRepository->findBy(['id' => $choiceIds]);
        $form = $this->careerFormRepository->findOneBy(['id' => $formId]);

        foreach ($choices as $choice) {
            $answered = $this->userAnswerRepository->findOneBy([
                'fkCareerForm' => $form,
                'fkCriteria' => $choice->getFkCriteria()]);

            if ($answered) {
                $answered->setFkChoice($choice);
                $answered->setUpdatedAt(new \DateTime("now"));
            }
            $userAnswer = ($answered) ? $answered : new UserAnswer();

            if (!$userAnswer->getId()) {
                $userAnswer->setCreatedAt(new \DateTime("now"));
            }
            $userAnswer->setFkChoice($choice);
            $userAnswer->setFkCriteria($choice->getFkCriteria());

            $this->userAnswerRepository->save($userAnswer);
            $userAnswer->setFkCareerForm($form);
            $form->addUserAnswer($userAnswer);
        };

        if ($comments) {
            foreach ($comments as $key => $comment) {
                $criteriaId = (array_key_exists('criteriaId', $comment)) ? (int)$comment['criteriaId'] : null;
                $criteria = $this->criteriaRepository->findOneBy(['id' => $criteriaId]);
                $text = (array_key_exists('comment', $comment)) ? (string)$comment['comment'] : null;
                $answered = $this->userAnswerRepository->findOneBy([
                    'fkCriteria' => $criteriaId,
                    'fkCareerForm' => $form]);
                if ($answered) {
                    $answered->setComment($text);
                    $answered->setUpdatedAt(new \DateTime("now"));
                }
                $userAnswer = ($answered) ? $answered : new UserAnswer();

                if (!$userAnswer->getId()) {
                    $userAnswer->setCreatedAt(new \DateTime("now"));
                }
                $userAnswer->setComment($text);
                $userAnswer->setFkCriteria($criteria);
                $this->userAnswerRepository->save($userAnswer);
                $form->addUserAnswer($userAnswer);
            }
        }

        $this->careerFormRepository->save($form);

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }


    private function dispatchJson(Request $request)
    {
        $values = array();
        // Fetch data from JSON
        $json = (array)json_decode(((string)$request->getContent()), true);
        if (!$json) {
            return false;
        }
        $data = $json['data'] ?? $json;

        $values['formId'] = $data['formId'] ?? null;

        if (!$values['formId']) {
            return false;
        }

        $values['choiceAnswers'] = (array) $data['choiceAnswers'] ?? null;
        $values['commentAnswers'] = (array) $data['commentAnswers'] ?? null;

        return $values;
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
