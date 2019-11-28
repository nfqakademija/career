<?php


namespace App\Factory;

use App\View\CriteriaListView;

class CriteriaListViewFactory
{

    /** @var CriteriaViewFactory */
    private $criteriaViewFactory;

    public function __construct(CriteriaViewFactory $criteriaViewFactory)
    {
        $this->criteriaViewFactory = $criteriaViewFactory;
    }

    public function create(Array $criterias): CriteriaListView
    {
        /** @var CriteriaListView $criteriaListView */
        $criteriaListView = new CriteriaListView();
        foreach ($criterias as $criteria) {
            $criteriaView = $this->criteriaViewFactory->create($criteria);
            $criteriaListView->list[] = $criteriaView;
        }

        return $criteriaListView;
    }
}
