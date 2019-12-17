<?php


namespace App\Factory;

use App\Entity\ManagerAnswer;
use App\View\ManagerAnswerView;

class ManagerAnswerViewFactory
{

    /** @var UserAnswerViewFactory */
    private $userAnswerViewFactory;

    /**
     * ManagerAnswerViewFactory constructor.
     * @param UserAnswerViewFactory $userAnswerViewFactory
     */
    public function __construct(
        UserAnswerViewFactory $userAnswerViewFactory
    ) {
        $this->userAnswerViewFactory = $userAnswerViewFactory;
    }

    /**
     * Create view from ManagerAnswer object
     * @param ManagerAnswer $managerAnswer
     * @return ManagerAnswerView
     */
    public function create(ManagerAnswer $managerAnswer)
    {
        /** @var ManagerAnswerView $managerAnswerView */
        $managerAnswerView = new ManagerAnswerView();
        $managerAnswerView->criteriaId = $managerAnswer->getFkUserAnswer()->getFkCriteria()->getId();
        $managerAnswerView->evaluation = $managerAnswer->getIsValidAnswer() ?? null;
        $managerAnswerView->comment = $managerAnswer->getComment();

        return $managerAnswerView;
    }
}
