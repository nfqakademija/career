<?php


namespace App\Service;

use App\Entity\ManagerAnswer;
use App\Repository\CareerFormRepository;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use App\Request\ManagerFeedbackRequest;
use App\Utils\ArrayFieldDispatcher;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ManagerFeedbackService
{

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    /** @var UserAnswerRepository  */
    private $userAnswerRepository;

    /**
     * ManagerFeedbackService constructor.
     * @param ManagerAnswerRepository $managerAnswerRepository
     * @param CareerFormRepository $careerFormRepository
     * @param UserAnswerRepository $userAnswerRepository
     */
    public function __construct(
        ManagerAnswerRepository $managerAnswerRepository,
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository
    ) {
        $this->careerFormRepository = $careerFormRepository;
        $this->managerAnswerRepository = $managerAnswerRepository;
        $this->userAnswerRepository = $userAnswerRepository;
    }

    /**
     * @param ManagerFeedbackRequest $req
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleSave(ManagerFeedbackRequest $req)
    {
        $form = $this->careerFormRepository->findOneBy(['id' => $req->getFormId()]);

        if (!$form) {
            return false;
        }

        $mappedEvaluations = ArrayFieldDispatcher::mapArraysByCommonIdx(
            $req->getEvaluation(),
            $req->getComment(),
            'answerId',
            'choiceId',
            'comment'
        );

        foreach ($mappedEvaluations as $evaluation) {
            if ($evaluation['answerId'] === 0) {
                continue;
            }
            $evaluated = $this->managerAnswerRepository->findOneBy([
                'fkUserAnswer' => $evaluation['answerId']]);

            $feedback = ($evaluated) ?? new ManagerAnswer();

            if (!$feedback->getId()) {
                $userAnswer = $this->userAnswerRepository->findOneBy(['id'=> $evaluation['answerId']]);
                $feedback->setFkUserAnswer($userAnswer);
                $feedback->onPrePersist();
            } else {
                $feedback->onPreUpdate();
            }

            if ($evaluation['choiceId'] !== null) {
                $feedback->setIsValidAnswer($evaluation['choiceId']);
            }

            if ($evaluation['comment']) {
                $feedback->setComment($evaluation['comment']);
            }

            $this->managerAnswerRepository->save($feedback);
        }
        return true;
    }
}
