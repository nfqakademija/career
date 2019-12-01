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
        $prevCompetenceTitle = '';

        foreach ($profile->getFkCriteria() as $criteria) {
            $nextCompetenceTitle = $criteria->getFkCompetence()->getTitle();
            if ($nextCompetenceTitle !== $prevCompetenceTitle) {
                $competenceTitle = $nextCompetenceTitle;
                $profileView->criteriaList['competence'] = $competenceTitle;
            }
            $profileView->criteriaList['criterias'][] = $this->criteriaViewFactory->create($criteria);
            $prevCompetenceTitle = $nextCompetenceTitle;
        }

        return $profileView;
    }
}
