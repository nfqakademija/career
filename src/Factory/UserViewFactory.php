<?php


namespace App\Factory;

use App\Entity\User;
use App\View\UserView;

class UserViewFactory
{
    /**
     * @var TeamViewFactory
     */
    private $teamViewFactory;

    public function __construct(TeamViewFactory $teamViewFactory)
    {
        $this->teamViewFactory = $teamViewFactory;
    }

    public function create(User $user): UserView
    {
        $userView = new UserView();
        $userView->id = $user->getId();
        $userView->firstName = $user->getFirstName();
        $userView->lastName = $user->getLastName();
        $userView->professionTitle = $user->getProfession()->getTitle();
        $userView->professionId = $user->getProfession()->getId();
        $userView->roles = $user->getRoles();

        foreach ($user->getTeam() as $team) {
            $userView->teams[] = $this->teamViewFactory->create($team);
        }

        return $userView;
    }
}
