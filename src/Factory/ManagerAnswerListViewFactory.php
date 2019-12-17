<?php


namespace App\Factory;

use App\View\ManagerAnswerListView;

class ManagerAnswerListViewFactory
{

    /** @var ManagerAnswerViewFactory */
    private $managerAnswerViewFactory;

    /**
     * ManagerAnswerListViewFactory constructor.
     * @param ManagerAnswerViewFactory $managerAnswerViewFactory
     */
    public function __construct(
        ManagerAnswerViewFactory $managerAnswerViewFactory
    ) {
        $this->managerAnswerViewFactory = $managerAnswerViewFactory;
    }

    /**
     * Create view of list of ManagerAnswerView objects
     * @param array $managerAnswers
     * @return ManagerAnswerListView
     */
    public function create(Array $managerAnswers)
    {
        /** @var ManagerAnswerListView $ManagerAnswerListView */
        $managerAnswerListView = new ManagerAnswerListView();
        foreach ($managerAnswers as $managerAnswer) {
            $managerAnswerListView->list[] = $this->managerAnswerViewFactory->create($managerAnswer);
        }

        return $managerAnswerListView;
    }
}
