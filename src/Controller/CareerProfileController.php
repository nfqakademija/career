<?php

namespace App\Controller;

use App\Entity\CareerProfile;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CareerProfileController
 *
 * routes:
 * /api/profiles/{slug} - get career profile by its id; TODO: get career profile by title id
 * /api/profile/list - get all career profiles;
 * /api/profiles - post new career profile
 *
 * @package App\Controller
 */
class CareerProfileController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $careerProfileRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(
        CriteriaRepository $criteriaRepository,
        CareerProfileRepository $careerProfileRepository
    ) {
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
    public function postProfileAction(Request $request)
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

    /**
     *
     * @return Response
     */
    public function getProfileListAction()
    {
        $profileList = $this->careerProfileRepository->findAll();

        $jsonObject = null;
        if (empty($profileList)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($profileList, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     *
     * @param string $slug
     * @return Response
     */
    public function getProfileAction($slug)
    {
        $careerProfile = $this->careerProfileRepository->findBy(['id' => $slug]);

        $jsonObject = null;
        if (empty($careerProfile)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($careerProfile, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
