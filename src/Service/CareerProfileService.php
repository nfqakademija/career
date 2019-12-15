<?php


namespace App\Service;

use App\Entity\CareerProfile;
use App\Entity\Profession;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
use App\Request\CareerProfileRequest;

class CareerProfileService
{
    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var ProfessionRepository */
    private $professionRepository;

    public function __construct(
        CareerProfileRepository $careerProfileRepository,
        CriteriaRepository $criteriaRepository,
        ProfessionRepository $professionRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->professionRepository = $professionRepository;
        $this->careerProfileRepository = $careerProfileRepository;
    }

    /**
     * @param CareerProfileRequest $request
     * @return bool
     * @throws \Exception
     */
    public function handleCareerProfileSave(CareerProfileRequest $request)
    {
        $profession = $this->professionRepository->findOneBy(['id' => $request->getProfessionId()]);

        if (!$profession) {
            return false;
        }

        $criteriaList = $this->criteriaRepository->findBy(array('id' => $request->getCriteriaIds()));
        if (!$criteriaList) {
            return false;
        }

        $this->saveCareerProfile($criteriaList, $profession);

        return true;
    }


    /**
     * @param array $criteriaList
     * @param Profession $profession
     * @return bool
     * @throws \Exception
     */
    public function saveCareerProfile(Array $criteriaList, Profession $profession)
    {
        $careerProfile = ($this->careerProfileRepository->findOneBy(['profession' => $profession])) ??
            new CareerProfile();

        if (!$careerProfile->getId()) {
            $careerProfile->onPrePersist();
        } else {
            $careerProfile->onPreUpdate();
        }

        if ($criteriaList == null) {
            return false;
        }

        foreach ($criteriaList as $criteria) {
            $careerProfile->addFkCriterion($criteria);
        }

        $careerProfile->setProfession($profession);
        $careerProfile->setIsArchived(0);

        $this->careerProfileRepository->save($careerProfile);
        return true;
    }
}
