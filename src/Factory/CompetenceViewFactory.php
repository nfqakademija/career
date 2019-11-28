<?php


namespace App\Factory;

use App\Entity\Competence;
use App\View\CompetenceView;

class CompetenceViewFactory
{

    public function create(Competence $competence): CompetenceView
    {
        /** @var CompetenceView $competenceView */
        $competenceView = new CompetenceView();
        $competenceView->id = $competence->getId();
        $competenceView->title = $competence->getTitle();

        return $competenceView;
    }

}