<?php


namespace App\Factory;

use App\Entity\Criteria;
use App\View\CriteriaView;

class CriteriaViewFactory
{

    public function create(Criteria $criteria): CriteriaView
    {
        /** @var CriteriaView $criteriaView */
        $criteriaView = new CriteriaView();
        $criteriaView->id = $criteria->getId();
        $criteriaView->title = $criteria->getTitle();

        return $criteriaView;
    }
}
