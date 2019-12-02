<?php


namespace App\Factory;

use App\View\CompetenceListView;

class CompetenceListViewFactory
{

    /** @var CompetenceViewFactory */
    private $competenceViewFactory;

    public function __construct(CompetenceViewFactory $competenceViewFactory)
    {
        $this->competenceViewFactory = $competenceViewFactory;
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
