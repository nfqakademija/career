<?php


namespace App\Service;

use App\Entity\Criteria;
use App\Entity\CriteriaChoice;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Request\CriteriaListRequest;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CriteriaListService
{
    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var CriteriaChoiceRepository */
    private $criteriaChoiceRepository;

    /** @var CompetenceRepository  */
    private $competenceRepository;

    /**
     * CriteriaListService constructor.
     * @param CriteriaRepository $criteriaRepository
     * @param CriteriaChoiceRepository $criteriaChoiceRepository
     * @param CompetenceRepository $competenceRepository
     */
    public function __construct(
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        CompetenceRepository $competenceRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
        $this->competenceRepository = $competenceRepository;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleCriteriaChoiceCreation(CriteriaListRequest $request)
    {
        $choices = $request->getChoices();

        if (count($choices) < 2) {
            return false;
        }

        $criteria = new Criteria();
        $criteriaChoice = new CriteriaChoice();

        $competence = $this->competenceRepository->findOneBy(['id' => $request->getCompetenceId()]);

        if (!$competence) {
            return false;
        }
        $criteria->setFkCompetence($competence);
        $criteria->setTitle($request->getCriteriaTitle());
        $criteria->setIsApplicable(true);
        $this->criteriaRepository->create($criteria);

        foreach ($choices as $key => $choice) {
            $criteriaChoice->setFkCriteria($criteria);
            $criteriaChoice->setTitle($choice);
            $criteriaChoice->setIsApplicable(true);
            $this->criteriaChoiceRepository->create($criteriaChoice);
        }

        $this->criteriaChoiceRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleCriteriaUpdate(CriteriaListRequest $request)
    {
        $criteria = $this->criteriaRepository->findOneBy(['id' => $request->getCriteriaId()]);
        $criteria->setTitle($request->getCriteriaTitle());
        $this->criteriaRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleCriteriaChoiceUpdate(CriteriaListRequest $request)
    {
        $criteriaChoice = $this->criteriaChoiceRepository->findOneBy(['id' => $request->getChoiceId()]);
        $criteriaChoice->setTitle($request->getChoiceTitle());
        $this->criteriaChoiceRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleCriteriaDelete(CriteriaListRequest $request)
    {
        $criteria = $this->criteriaRepository->findOneBy(['id' => $request->getCriteriaId()]);
        $criteria->setIsApplicable(false);
        $this->criteriaRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function handleCriteriaChoiceDelete(CriteriaListRequest $request)
    {
        $criteriaChoice = $this->criteriaChoiceRepository->findOneBy(['id' => $request->getChoiceId()]);
        $criteriaChoice->setIsApplicable(false);
        $this->criteriaChoiceRepository->save();
        return true;
    }
}
