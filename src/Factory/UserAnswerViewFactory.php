<?php


namespace App\Factory;


use App\Entity\UserAnswer;
use App\View\UserAnswerView;

class UserAnswerViewFactory
{

    /**
     * @var CriteriaViewFactory
     */
    private $criteriaViewFactory;


    /**
     * @var ChoiceViewFactory
     */
    private $choiceViewFactory;

    public function __construct(
        CriteriaViewFactory $criteriaViewFactory,
        ChoiceViewFactory $choiceViewFactory)
    {
        $this->criteriaViewFactory = $criteriaViewFactory;
        $this->choiceViewFactory = $choiceViewFactory;
    }


    public function create(UserAnswer $userAnswer): UserAnswerView
    {
        $userAnswerView = new UserAnswerView();
        $userAnswerView->id = $userAnswer->getId();
        $userAnswerView->criteriaView = $this->criteriaViewFactory->create($userAnswer->getFkCriteria());
        $userAnswerView->choiceView = $this->choiceViewFactory->create($userAnswer->getFkChoice());
    }


}