<?php


namespace App\Factory;

use App\Entity\Team;
use App\View\TeamView;

class TeamViewFactory
{
    public function create(Team $team): TeamView
    {
        $teamView = new TeamView();
        $teamView->id = $team->getId();
        $teamView->title = $team->getTitle();
        return $teamView;
    }
}
