<?php


namespace App\Factory;

use App\View\CompetenceListView;

class CompetenceListViewFactory
{

    /** @var CompetenceViewFactory */
    private $competenceViewFactory;

    public function __construct()
    {
        $this->competenceViewFactory = new CompetenceViewFactory();
    }

    public function create(Array $competences): CompetenceListView
    {
        /** @var CompetenceListView $competenceListView */
        $competenceListView = new CompetenceListView();
        foreach ($competences as $competence) {
            $competenceView = $this->competenceViewFactory->create($competence);
            $competenceListView->list[] = $competenceView;
        }

        return $competenceListView;
    }

}