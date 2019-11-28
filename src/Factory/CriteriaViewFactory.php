<?php


namespace App\Factory;

use App\Entity\Criteria;
use App\View\CriteriaView;

class CriteriaViewFactory
{

    /**
     * @var ChoiceViewFactory
     */
    private $choiceViewFactory;

    public function __construct(ChoiceViewFactory $choiceViewFactory)
    {
        $this->choiceViewFactory = $choiceViewFactory;
    }

    public function create(Criteria $criteria): CriteriaView
    {
        /** @var CriteriaView $criteriaView */
        $criteriaView = new CriteriaView();
        $criteriaView->id = $criteria->getId();
        $criteriaView->title = $criteria->getTitle();
        foreach ($criteria->getCriteriaChoices() as $choice) {
            $criteriaView->choiceList[] = $this->choiceViewFactory->create($choice);
        }

        return $criteriaView;
    }
}
