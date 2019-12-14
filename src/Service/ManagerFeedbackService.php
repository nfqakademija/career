<?php


namespace App\Service;

use App\Entity\ManagerAnswer;
use App\Repository\CareerFormRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ManagerAnswerRepository;
use App\Request\ManagerFeedbackRequest;

class ManagerFeedbackService
{

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    /** @var CriteriaRepository  */
    private $criteriaRepository;

    public function __construct(
        ManagerAnswerRepository $managerAnswerRepository,
        CareerFormRepository $careerFormRepository,
        CriteriaRepository $criteriaRepository
    ) {
        $this->careerFormRepository = $careerFormRepository;
        $this->managerAnswerRepository = $managerAnswerRepository;
        $this->criteriaRepository = $criteriaRepository;
    }

    public function handleSave(ManagerFeedbackRequest $req)
    {
        $form = $this->careerFormRepository->findOneBy(['id' => $req->getFormId()]);

        if (!$form) {
            return false;
        }

        foreach ($req->getMapEvaluationAndComments() as $evaluation) {
            $evaluated = $this->managerAnswerRepository->findOneBy([
                'fkCareerForm' => $form,
                'fkCriteria' => $evaluation['criteriaId']]);

            $feedback = ($evaluated) ?? new ManagerAnswer();

            if (!$feedback->getId()) {
                $criteria = $this->criteriaRepository->findOneBy(['id'=> $evaluation['criteriaId']]);
                $feedback->setFkCriteria($criteria);
                $feedback->setCreatedAt(new \DateTime("now"));
            }
        }
    }
}
