<?php


namespace App\Factory;

use App\View\ManagerAnswerListView;

class ManagerAnswerListViewFactory
{

    /**
     * @var ManagerAnswerViewFactory
     */
    private $managerAnswerViewFactory;

    public function __construct(
        ManagerAnswerViewFactory $managerAnswerViewFactory
    ) {
        $this->managerAnswerViewFactory = $managerAnswerViewFactory;
    }

    public function create(Array $managerAnswers): ManagerAnswerListView
    {
        /** @var ManagerAnswerListView $ManagerAnswerListView */
        $managerAnswerListView = new ManagerAnswerListView();
        foreach ($managerAnswers as $managerAnswer) {
            $managerAnswerListView->list[] = $this->managerAnswerViewFactory->create($managerAnswer);
        }

        return $managerAnswerListView;
    }
}
