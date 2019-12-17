<?php


namespace App\Factory;

use App\View\UserAnswerListView;

class UserAnswerListViewFactory
{

    /** @var UserAnswerViewFactory */
    private $userAnswerViewFactory;

    /**
     * UserAnswerListViewFactory constructor.
     * @param UserAnswerViewFactory $userAnswerViewFactory
     */
    public function __construct(
        UserAnswerViewFactory $userAnswerViewFactory
    ) {
        $this->userAnswerViewFactory = $userAnswerViewFactory;
    }

    /**
     * Create view of list of UserAnswerView objects
     * @param array $userAnswers
     * @return UserAnswerListView
     */
    public function create(Array $userAnswers)
    {
        /** @var UserAnswerListView $userAnswerListView */
        $userAnswerListView = new UserAnswerListView();
        foreach ($userAnswers as $key => $userAnswer) {
            $userAnswerView = $this->userAnswerViewFactory->create($userAnswer);
            $userAnswerListView->list[$key]['answerId'] = $userAnswerView->id;
            $userAnswerListView->list[$key]['criteriaId'] = $userAnswerView->criteria;
            $userAnswerListView->list[$key]['choiceId'] = ($userAnswerView->choice)?? null;
            $userAnswerListView->list[$key]['comment'] = ($userAnswerView->comment)?? null;
        }

        return $userAnswerListView;
    }
}
