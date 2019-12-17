<?php


namespace App\Factory;

use App\Entity\Team;
use App\View\TeamView;

class TeamViewFactory
{
    /**
     * Create view from Team object
     * @param Team $team
     * @return TeamView
     */
    public function create(Team $team)
    {
        $teamView = new TeamView();
        $teamView->id = $team->getId();
        $teamView->title = $team->getTitle();
        return $teamView;
    }
}
