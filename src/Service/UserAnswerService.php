<?php


namespace App\Service;

use App\Entity\UserAnswer;
use App\Repository\CareerFormRepository;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Repository\UserAnswerRepository;
use App\Request\UserAnswerRequest;
use Exception;

class UserAnswerService
{

    /** @var UserAnswerRepository */
    private $userAnswerRepository;

    /** @var CareerFormRepository */
    private $careerFormRepository;

    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var CriteriaChoiceRepository */
    private $criteriaChoiceRepository;

    public function __construct(
        CriteriaRepository $criteriaRepository,
        UserAnswerRepository $userAnswerRepository,
        CareerFormRepository $careerFormRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->careerFormRepository = $careerFormRepository;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
    }

    /**
     * @param UserAnswerRequest $req
     * @return bool
     * @throws Exception
     */
    public function handleSave(UserAnswerRequest $req)
    {
        $form = $this->careerFormRepository->findOneBy(['id' => $req->getFormId()]);

        if (!$form) {
            return false;
        }

        foreach ($req->getMapAnswersAndComments() as $answer) {
            $answered = $this->userAnswerRepository->findOneBy([
                'fkCareerForm' => $form,
                'fkCriteria' => $answer['criteriaId']]);

            $userAnswer = $answered ?? new UserAnswer();

            if (!$userAnswer->getId()) {
                $criteria = $this->criteriaRepository->findOneBy(['id' => $answer['criteriaId']]);
                $userAnswer->setFkCriteria($criteria);
                $userAnswer->onPrePersist();
            } else {
                $userAnswer->onPreUpdate();
            }

            $choice = ($answer['choiceId'])? $this->criteriaChoiceRepository->findOneBy(['id' => $answer['choiceId']])
                : null;

            if ($userAnswer->getFkChoice() !== $choice && $choice !== null) {
                $userAnswer->setFkChoice($choice);
            }

            if ($answer['comment']) {
                $userAnswer->setComment($answer['comment']);
            }

            $userAnswer->setFkCareerForm($form);
            $this->userAnswerRepository->save($userAnswer);
            $form->addUserAnswer($userAnswer);
        }

        if ($req->isUnderEvaluation() !== null) {
            if ($req->isUnderEvaluation()) {
                $form->setUnderEvaluation(true);
            }
        }

        $form->onPreUpdate();
        $this->careerFormRepository->save($form);
        return true;
    }
}
