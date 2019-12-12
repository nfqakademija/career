<?php


namespace App\Factory;

use App\Entity\UserAnswer;
use App\View\UserAnswerView;

class UserAnswerViewFactory
{

    public function create(UserAnswer $userAnswer): UserAnswerView
    {
        $userAnswerView = new UserAnswerView();
        $userAnswerView->id = $userAnswer->getId();
        $userAnswerView->comment = $userAnswer->getComment();
        $userAnswerView->criteria = $userAnswer->getFkCriteria()->getId();
        $userAnswerView->choice = ($userAnswer->getFkChoice())? $userAnswer->getFkChoice()->getId() : null;

        return $userAnswerView;
    }
}
