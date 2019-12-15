<?php


namespace App\Factory;

use App\Entity\Criteria;
use App\View\CriteriaView;

class CriteriaViewFactory
{

    /** @var ChoiceViewFactory */
    private $choiceViewFactory;

    /**
     * CriteriaViewFactory constructor.
     * @param ChoiceViewFactory $choiceViewFactory
     */
    public function __construct(ChoiceViewFactory $choiceViewFactory)
    {
        $this->choiceViewFactory = $choiceViewFactory;
    }

    /**
     * Create view from Criteria object
     * @param Criteria $criteria
     * @return CriteriaView
     */
    public function create(Criteria $criteria)
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
