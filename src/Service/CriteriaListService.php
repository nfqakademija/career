<?php


namespace App\Service;

use App\Entity\Criteria;
use App\Entity\CriteriaChoice;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Request\CriteriaListRequest;

class CriteriaListService
{
    /** @var CriteriaRepository */
    private $criteriaRepository;

    /** @var CriteriaChoiceRepository */
    private $criteriaChoiceRepository;

    public function __construct(
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository
    ) {
        $this->criteriaRepository = $criteriaRepository;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     */
    public function handleCriteriaChoiceCreation(CriteriaListRequest $request)
    {
        $choices = $request->getChoices();

        if (count($choices) < 2) {
            return false;
        }

        $criteria = new Criteria();
        $criteriaChoice = new CriteriaChoice();

        $criteria->setFkCompetence($request->getCompetenceId());
        $criteria->setTitle($request->getCriteriaTitle());
        $criteria->setIsApplicable(1);
        $this->criteriaRepository->create($criteria);

        foreach ($choices as $key => $choice) {
            $criteriaChoice->setFkCriteria($criteria);
            $criteriaChoice->setTitle($choice);
            $criteriaChoice->setIsApplicable(1);
            $this->criteriaChoiceRepository->create($criteriaChoice);
        }

        $this->criteriaChoiceRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
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
     */
    public function handleCriteriaDelete(CriteriaListRequest $request)
    {
        $criteria = $this->criteriaRepository->findOneBy(['id' => $request->getCriteriaId()]);
        $criteria->setIsApplicable(0);
        $this->criteriaRepository->save();
        return true;
    }

    /**
     * @param CriteriaListRequest $request
     * @return bool
     */
    public function handleCriteriaChoiceDelete(CriteriaListRequest $request)
    {
        $criteriaChoice = $this->criteriaChoiceRepository->findOneBy(['id' => $request->getChoiceId()]);
        $criteriaChoice->setIsApplicable(0);
        $this->criteriaChoiceRepository->save();
        return true;
    }
}
