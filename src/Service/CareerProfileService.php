<?php


namespace App\Service;

use App\Entity\CareerProfile;
use App\Entity\Profession;
use App\Repository\CareerProfileRepository;
use Symfony\Component\HttpFoundation\Request;

class CareerProfileService
{
    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    public function __construct(CareerProfileRepository $careerProfileRepository)
    {
        $this->careerProfileRepository = $careerProfileRepository;
    }

    public function saveCareerProfile(Array $criterias, Profession $profession)
    {

        // Check if position has its career profile and create career profile object depending on the decision
        $careerProfile = ($this->careerProfileRepository->findOneBy(['profession' => $profession])) ??
            new CareerProfile();

        // loop through checked criterias and add to Criteria array
        if ($criterias != null) {
            foreach ($criterias as $criteria) {
                $careerProfile->addFkCriterion($criteria);
            }
        }

        $careerProfile->setProfession($profession);
        $careerProfile->setIsArchived(0);

        $this->careerProfileRepository->save($careerProfile);
    }

    public function dispatchJson(Request $request, $fields = array())
    {
        $values = array();
        // Fetch data from JSON
        $json = (array)json_decode(((string)$request->getContent()), true);

        if (!$json) {
            return false;
        }
        $data = $json['data'] ?? $json;
        $values['position'] = $data[0]['position'] ?? null;

        if (!$values['position']) {
            return false;
        }

        $values['competences'] = (array)$data[1]['competences'] ?? null;

        return $values;
    }
}
