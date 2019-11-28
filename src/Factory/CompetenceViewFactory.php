<?php


namespace App\Factory;


use App\Entity\Competence;
use App\View\CompetenceView;

class CompetenceViewFactory
{

    /** @var string */
    private $competenceViewClass;

    public function __construct(
        string $competenceViewClass)
    {
        $this->competenceViewClass = $competenceViewClass;
    }

    public function create(Competence $competence): CompetenceView
    {
        /** @var CompetenceView $competenceView */
        $competenceView = new $this->competenceViewClass();
        $competenceView->id = $competence->getId();
        $competenceView->title = $competence->getTitle();

        return $competenceView;
    }

}