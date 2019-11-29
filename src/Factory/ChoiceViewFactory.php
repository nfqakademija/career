<?php


namespace App\Factory;

use App\Entity\CriteriaChoice;
use App\View\ChoiceView;

class ChoiceViewFactory
{

    public function create(CriteriaChoice $criteriaChoice): ChoiceView
    {
        /** @var ChoiceView $choiceView */
        $choiceView = new ChoiceView();
        $choiceView->id = $criteriaChoice->getId();
        $choiceView->title = $criteriaChoice->getTitle();

        return $choiceView;
    }

}