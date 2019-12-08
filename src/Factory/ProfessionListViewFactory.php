<?php


namespace App\Factory;

use App\View\ProfessionListView;

class ProfessionListViewFactory
{
    /** @var ProfessionViewFactory */
    private $professionViewFactory;

    public function __construct(ProfessionViewFactory $professionViewFactory)
    {
        $this->professionViewFactory = $professionViewFactory;
    }

    public function create(Array $professions): ProfessionListView
    {
        /** @var ProfessionListView $professionListView */
        $professionListView = new ProfessionListView();
        foreach ($professions as $profession) {
            $professionView = $this->professionViewFactory->create($profession);
            $professionListView->list[] = $professionView;
        }

        return $professionListView;
    }
}
