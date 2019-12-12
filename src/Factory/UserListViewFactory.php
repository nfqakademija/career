<?php


namespace App\Factory;

use App\View\UserListView;

class UserListViewFactory
{
    /** @var UserViewFactory */
    private $userViewFactory;

    public function __construct(UserViewFactory $userViewFactory)
    {
        $this->userViewFactory = $userViewFactory;
    }

    public function create(Array $users): UserListView
    {
        /** @var UserListView $userListView */
        $userListView = new UserListView();
        foreach ($users as $user) {
            $userView = $this->userViewFactory->create($user);
            $userListView->list[] = $userView;
        }

        return $userListView;
    }
}
