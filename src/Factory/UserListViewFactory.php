<?php


namespace App\Factory;

use App\Entity\User;
use App\View\UserListView;
use App\View\UserView;

class UserListViewFactory
{
    /** @var UserViewFactory */
    private $userViewFactory;

    /**
     * UserListViewFactory constructor.
     * @param UserViewFactory $userViewFactory
     */
    public function __construct(UserViewFactory $userViewFactory)
    {
        $this->userViewFactory = $userViewFactory;
    }

    /**
     * Create view of list of UserView objects
     * @param array $users
     * @return UserListView
     */
    public function create(Array $users)
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
