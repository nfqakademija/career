<?php


namespace App\Factory;


use App\Entity\ManagerAnswer;
use App\View\ManagerAnswerView;

class ManagerAnswerViewFactory
{

    /** @var UserAnswerViewFactory */
    private $userAnswerViewFactory;

    public function __construct(
        UserAnswerViewFactory $userAnswerViewFactory
    ) {
        $this->userAnswerViewFactory = $userAnswerViewFactory;
    }

    public function create(ManagerAnswer $managerAnswer): ManagerAnswerView
    {
        /** @var ManagerAnswerView $managerAnswerView */
        $managerAnswerView = new ManagerAnswerView();
        $managerAnswerView->userAnswerId = $managerAnswer->getFkUserAnswer()->getFkCriteria()->getId();
        $managerAnswerView->evaluation = $managerAnswer->getIsValidAnswer() ?? null;
        $managerAnswerView->comment = $managerAnswer->getComment();

        return $managerAnswerView;
    }
}
