<?php


namespace App\Factory;

use App\View\ProfileListView;

class ProfileListViewFactory
{

    /** @var ProfileViewFactory */
    private $profileViewFactory;

    public function __construct(ProfileViewFactory $profileViewFactory)
    {
        $this->profileViewFactory = $profileViewFactory;
    }

    public function create(Array $profiles): ProfileListView
    {
        /** @var CompetenceListView $competenceListView */
        $profileListView = new ProfileListView();
        foreach ($profiles as $profile) {
            $profileView = $this->profileViewFactory->create($profile);
            $profileListView->profiles[] = $profileView;
        }

        return $profileListView;
    }
}
