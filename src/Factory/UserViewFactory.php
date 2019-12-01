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
        $userView->professionId = $user->getProfession()->getId();
        $userView->roles = $user->getRoles();
        // patikrinti ar ne null.
        $userView->careerFormId = $user->getCareerForm()->getId();

        return $userView;
    }
}
