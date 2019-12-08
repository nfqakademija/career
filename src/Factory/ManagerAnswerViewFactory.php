<?php


namespace App\Factory;

use App\Entity\CareerForm;
use App\Entity\ManagerAnswer;
use App\View\FormView;
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
        $managerAnswerView->employAnswerId = $managerAnswer->getFkUserAnswer()->getFkChoice()->getId();
        $managerAnswerView->evaluation = $managerAnswer->getIsValidAnswer();
        $managerAnswerView->comment = $managerAnswer->getComment();

        return $managerAnswerView;
    }
}
