<?php


namespace App\Service;

use App\Entity\ManagerAnswer;
use App\Repository\CareerFormRepository;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use App\Request\ManagerFeedbackRequest;
use phpDocumentor\Reflection\Types\Null_;

class ManagerFeedbackService
{

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    /** @var UserAnswerRepository  */
    private $userAnswerRepository;

    public function __construct(
        ManagerAnswerRepository $managerAnswerRepository,
        CareerFormRepository $careerFormRepository,
        UserAnswerRepository $userAnswerRepository
    ) {
        $this->careerFormRepository = $careerFormRepository;
        $this->managerAnswerRepository = $managerAnswerRepository;
        $this->userAnswerRepository = $userAnswerRepository;
    }

    public function handleSave(ManagerFeedbackRequest $req)
    {
        $form = $this->careerFormRepository->findOneBy(['id' => $req->getFormId()]);

        if (!$form) {
            return false;
        }

        foreach ($req->getMapEvaluationAndComments() as $evaluation) {
            $evaluated = $this->managerAnswerRepository->findOneBy([
                'fkUserAnswer' => $evaluation['answerId']]);

            $feedback = ($evaluated) ?? new ManagerAnswer();

            if (!$feedback->getId()) {
                $userAnswer = $this->userAnswerRepository->findOneBy(['id'=> $evaluation['answerId']]);
                $feedback->setFkUserAnswer($userAnswer);
                $feedback->setCreatedAt(new \DateTime("now"));
            }

            $feedback->setIsValidAnswer($evaluation['choiceId']);

            if ($evaluation['comment']) {
                $feedback->setComment($evaluation['comment']);
            }

            $this->managerAnswerRepository->save($feedback);
        }
        return true;
    }
}
