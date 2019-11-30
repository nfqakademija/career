<?php


namespace App\Factory;


use App\Entity\CareerProfile;
use App\View\ProfileView;

class ProfileViewFactory
{

    /**
     * @var CriteriaViewFactory
     */
    private $criteriaViewFactory;

    public function __construct(CriteriaViewFactory $criteriaViewFactory)
    {
        $this->criteriaViewFactory = $criteriaViewFactory;
    }

    public function create(CareerProfile $profile): ProfileView
    {
        /** @var ProfileView $profileView */
        $profileView = new ProfileView();
        $profileView->id = $profile->getId();
        $profileView->professionTitle = $profile->getProfession()->getTitle();
        foreach ($profile->getFkCriteria() as $criteria) {
            $profileView->criteriaList[] = $this->criteriaViewFactory->create($criteria);
        }

        return $profileView;
    }

}