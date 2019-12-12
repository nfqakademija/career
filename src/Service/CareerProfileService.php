<?php


namespace App\Service;

use App\Entity\CareerForm;
use App\Entity\CareerProfile;
use App\Entity\Profession;
use App\Entity\User;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
use App\Request\CareerProfileRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            $careerProfile->setCreatedAt(new \DateTime("now"));
        } else {
            $careerProfile->setUpdatedAt(new \DateTime("now"));
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
