<?php


namespace App\Factory;


use App\Entity\User;
use App\View\UserView;

class UserViewFactory
{

    public function create(User $user): UserView
    {
        $userView = new UserView();
        $userView->id = $user->getId();
        $userView->firstName = $user->getFirstName();
        $userView->lastName = $user->getLastName();
        $userView->professionTitle = $user->getProfession()->getTitle();
        $userView->roles = $user->getRoles();

        return  $userView;
    }
}
