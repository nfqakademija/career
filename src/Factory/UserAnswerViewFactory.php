<?php


namespace App\Factory;

use App\Entity\UserAnswer;
use App\View\UserAnswerView;

class UserAnswerViewFactory
{

    /**
     * Create view from UserAnswer object
     * @param UserAnswer $userAnswer
     * @return UserAnswerView
     */
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
