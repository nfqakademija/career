<?php


namespace App\Factory;

use App\Entity\Competence;
use App\View\CompetenceView;
use App\Factory\CriteriaListViewFactory;

class CompetenceViewFactory
{
    /**
     * @var CriteriaViewFactory
     */
    private $criteriaViewFactory;

    public function __construct(CriteriaViewFactory $criteriaViewFactory)
    {
        $this->criteriaViewFactory = $criteriaViewFactory;
    }

    public function create(Competence $competence): CompetenceView
    {
        /** @var CompetenceView $competenceView */
        $competenceView = new CompetenceView();
        $competenceView->id = $competence->getId();
        $competenceView->title = $competence->getTitle();
        foreach ($competence->getCriterias() as $criteria) {
            $competenceView->criteriaList[] = $this->criteriaViewFactory->create($criteria);
        }

        return $competenceView;
    }
}
