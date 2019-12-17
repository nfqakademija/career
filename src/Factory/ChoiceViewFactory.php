<?php


namespace App\Factory;

use App\Entity\CriteriaChoice;
use App\View\ChoiceView;

class ChoiceViewFactory
{
    /**
     * Create view from CriteriaChoice object
     * @param CriteriaChoice $criteriaChoice
     * @return ChoiceView
     */
    public function create(CriteriaChoice $criteriaChoice)
    {
        /** @var ChoiceView $choiceView */
        $choiceView = new ChoiceView();
        $choiceView->id = $criteriaChoice->getId();
        $choiceView->title = $criteriaChoice->getTitle();

        return $choiceView;
    }
}
