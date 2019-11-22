<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Entity\CareerProfile;
use App\Entity\Criteria;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CareerFormController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $careerProfileRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(
        CriteriaRepository $criteriaRepository,
        CareerProfileRepository $careerProfileRepository)
    {
        $this->careerProfileRepository = $careerProfileRepository;
        $this->criteriaRepository = $criteriaRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     *
     * @param Request $request
     */
    public function postCareerAction(Request $request)
    {
        $json = $request->request->all();
        $position = array_shift($json)['position'];
        $competences = array_shift($json)['competence'];

        $careerProfile = new CareerProfile();


        // sort the array by cirteria IDs from JSON/ remove unnecessary
        $idList = array();
        foreach ($competences as $competenceId => $competenceBody) {
            foreach ($competenceBody as $key => $value) {
                if ($key === 'criteria') {
                    foreach ($value as $item => $field) {
                        $idList[] = ((int)$field['id']);
                    }
                }
            }
        }
        // get available Criterias From Database as an array of Criteria objects
        $availableCriterias = $this->criteriaRepository->findBy(array('id' => $idList));

// run foreach to add Criterias to CareerProfile
        foreach ($availableCriterias as $criteria) {
            $careerProfile->addFkCriterion($criteria);
        }

//        foreach ($careerProfile->getFkCriteria() as $crit) {
//            var_dump("CRITERIA TITLE: " . $crit->getTitle());
//        }

        $this->careerProfileRepository->save($careerProfile);

    }
}
