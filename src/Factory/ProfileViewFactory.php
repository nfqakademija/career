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
        $list = array();
        $i = 0;
        $j = 0;
        $k = 0;

        foreach ($profile->getFkCriteria() as $criteria) {
            $nextCompetenceTitle = $criteria->getFkCompetence()->getTitle();
            if ($nextCompetenceTitle !== $prevCompetenceTitle) {
                $k = 0;
                $competenceTitle = $nextCompetenceTitle;
                $list[$i] = array(
                    'competence' => $competenceTitle,
                    'criteria' => array($k => $this->criteriaViewFactory->create($criteria)));
                $prevCompetenceTitle = $competenceTitle;
                $j = $i;
                $i++;
                continue;
            } else {
                $k++;
                $list[$j]['criteria'][$k] = $this->criteriaViewFactory->create($criteria);
            }
        }
        $profileView->criteriaList = $list;

        return $profileView;
    }
}
