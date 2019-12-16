<?php


namespace App\Service;

use App\Entity\CareerProfile;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
use App\Request\CareerProfileRequest;
use Exception;

class CareerProfileService
{
    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var ProfessionRepository */
    private $professionRepository;

    /**
     * CareerProfileService constructor.
     * @param CareerProfileRepository $careerProfileRepository
     * @param CriteriaRepository $criteriaRepository
     * @param ProfessionRepository $professionRepository
     */
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
     * Save CareerProfile to database. Terminate with false if any of the required values is missing
     * @param CareerProfileRequest $request
     * @return bool
     * @throws Exception
     */
    public function handleSave(CareerProfileRequest $request)
    {
        $profession = $this->professionRepository->findOneBy(['id' => $request->getProfessionId()]);

        if (!$profession) {
            return false;
        }

        $criteriaList = $this->criteriaRepository->findBy(array('id' => $request->getCriteriaIds()));
        if (!$criteriaList) {
            return false;
        }

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
        $careerProfile->setIsArchived(false);

        $this->careerProfileRepository->save($careerProfile);
        return true;
    }
}
