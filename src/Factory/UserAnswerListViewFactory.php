<?php


namespace App\Factory;

use App\View\UserAnswerListView;

class UserAnswerListViewFactory
{

    public function create(Array $userAnswers): UserAnswerListView
    {
        /** @var UserAnswerListView $userAnswerListView */
        $userAnswerListView = new UserAnswerListView();
        foreach ($userAnswers as $userAnswer) {
            $userAnswerListView->list[] = $userAnswer->getId();
        }

        return $userAnswerListView;
    }
}
