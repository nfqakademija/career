<?php


namespace App\Service;

use App\Entity\CareerForm;
use App\Entity\User;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;

class CareerFormService
{

    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    /**
     * CareerFormService constructor.
     * @param CareerProfileRepository $careerProfileRepository
     * @param CareerFormRepository $careerFormRepository
     */
    public function __construct(
        CareerProfileRepository $careerProfileRepository,
        CareerFormRepository $careerFormRepository
    ) {
        $this->careerProfileRepository = $careerProfileRepository;
        $this->careerFormRepository = $careerFormRepository;
    }

    /**
     * Create CareerForm for user by assigning a CareerProfile according to user occupation
     * @param User $user
     * @return CareerForm|bool|null
     */
    public function getUserCareerForm(User $user)
    {
        $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $user->getProfession()->getId()]);

        if (!$careerProfile) {
            return false;
        }

        $careerForm = $this->careerFormRepository->findOneBy(['fkUser' => $user]) ?? new CareerForm();
        $careerForm->setFkUser($user);
        $careerForm->setFkCareerProfile($careerProfile);
        $careerForm->setIsArchived(0);
        if (!$careerForm->getId()) {
            $careerForm->onPrePersist();
        }
        $careerForm->onPreUpdate();
        $careerForm->setUnderEvaluation(false);
        $this->careerFormRepository->save($careerForm);

        return $careerForm;
    }
}
