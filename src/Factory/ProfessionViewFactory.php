<?php


namespace App\Factory;

use App\Entity\Profession;
use App\View\ProfessionView;

class ProfessionViewFactory
{

    public function create(Profession $profession) : ProfessionView
    {
        /** @var ProfessionView $professionView */
        $professionView = new ProfessionView();
        $professionView->id = $profession->getId();
        $professionView->title = $profession->getTitle();

        return $professionView;
    }
}
