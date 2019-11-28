<?php


namespace App\Factory;

use App\Entity\Competence;
use App\View\CompetenceView;
use App\Factory\CriteriaListViewFactory;

class CompetenceViewFactory
{
    /**
     * @var \App\Factory\CriteriaListViewFactory
     */
    private $criteriaListViewFactory;

    public function __construct()
    {
        $this->criteriaListViewFactory = new CriteriaListViewFactory();
    }

    public function create(Competence $competence): CompetenceView
    {
        /** @var CompetenceView $competenceView */
        $competenceView = new CompetenceView();
        $competenceView->id = $competence->getId();
        $competenceView->title = $competence->getTitle();
        $competenceView->criteriaList = $this->criteriaListViewFactory->create($competence->getCriterias());

        return $competenceView;
    }
}
