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
        foreach ($userAnswers as $key => $userAnswer) {
            $userAnswerView = $this->userAnswerViewFactory->create($userAnswer);
            $userAnswerListView->list[$key]['criteriaId'] = $userAnswerView->criteria;
            $userAnswerListView->list[$key]['choiceId'] = ($userAnswerView->choice)? $userAnswerView->choice: 'NULL';
            $userAnswerListView->list[$key]['comment'] = ($userAnswerView->comment)? $userAnswerView->comment: 'NULL';
        }

        return $userAnswerListView;
    }
}
