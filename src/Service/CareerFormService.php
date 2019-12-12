<?php


namespace App\Service;

use App\Entity\CareerForm;
use App\Entity\User;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use Symfony\Component\HttpFoundation\Response;

class CareerFormService
{

    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    /** @var CareerFormRepository  */
    private $careerFormRepository;

    public function __construct(
        CareerProfileRepository $careerProfileRepository,
        CareerFormRepository $careerFormRepository
    ) {
        $this->careerProfileRepository = $careerProfileRepository;
        $this->careerFormRepository = $careerFormRepository;
    }

    public function getCareerForm(User $user)
    {
        $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $user->getProfession()->getId()]);

        if (!$careerProfile) {
            return false;
        }
        $careerForm = new CareerForm();
        $careerForm->setFkUser($user);
        $careerForm->setFkCareerProfile($careerProfile);
        $careerForm->setIsArchived(0);
        $careerForm->setCreatedAt(new \DateTime("now"));
        $careerForm->setUnderEvaluation(false);
        $this->careerFormRepository->save($careerForm);

        return $careerForm;
    }
}
