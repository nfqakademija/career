<?php


namespace App\Factory;

use App\View\UserAnswerListView;

class UserAnswerListViewFactory
{

    /**
     * @var UserAnswerViewFactory
     */
    private $userAnswerViewFactory;

    public function __construct(
        UserAnswerViewFactory $userAnswerViewFactory
    ) {
        $this->userAnswerViewFactory = $userAnswerViewFactory;
    }

    public function create(Array $userAnswers): UserAnswerListView
    {
        /** @var UserAnswerListView $userAnswerListView */
        $userAnswerListView = new UserAnswerListView();
        foreach ($userAnswers as $userAnswer) {
            $userAnswerView = $this->userAnswerViewFactory->create($userAnswer);
            $userAnswerListView->list[] = $userAnswerView->choice;
        }

        return $userAnswerListView;
    }
}
