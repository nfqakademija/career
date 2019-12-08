<?php


namespace App\Factory;

use App\View\UserCommentListView;

class UserCommentListViewFactory
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

    public function create(Array $userAnswers): UserCommentListView
    {
        /** @var UserCommentListView $userCommentListView */
        $userCommentListView = new UserCommentListView();
        foreach ($userAnswers as $key => $userAnswer) {
            $userAnswerView = $this->userAnswerViewFactory->create($userAnswer);
            $userCommentListView->list[$key]['criteriaId'] = $userAnswerView->criteria;
            $userCommentListView->list[$key]['comment'] = $userAnswerView->comment;
        }

        return $userCommentListView;
    }
}
