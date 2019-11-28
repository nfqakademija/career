<?php

namespace App\Controller;

use App\Entity\CareerProfile;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
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
 * /api/profiles/{slug} - get career profile title and id by profession id;
 * /api/profile/list - get all career profiles;
 * /api/profiles - post new career profile
 *
 * @package App\Controller
 */
class CareerProfileController extends AbstractFOSRestController
{
    private $criteriaRepository = null;
    private $careerProfileRepository = null;
    private $professionRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(
        CriteriaRepository $criteriaRepository,
        ProfessionRepository $professionRepository,
        CareerProfileRepository $careerProfileRepository
    )
    {
        $this->professionRepository = $professionRepository;
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
        // Fetch data from JSON
        $data = ((array)json_decode(((string)$request->getContent()), true))['data'];

        // Get position ID from data
        $positionId = (int)array_shift($data)['position'];

        // Check if position has its career profile and create career profile object depending on the decision
        $careerProfile = ($this->careerProfileRepository->fetchProfileByProfession($positionId)) ?
            $this->careerProfileRepository->findOneBy(['profession' => $positionId])
            : new CareerProfile();

        // Get competence array from data
        $competences = (array)array_shift($data)['competences'];

        // Gather all checked criteria ids
        $checkedCriteriaIdList = array();
        foreach ($competences as $competenceId => $competenceBody) {
            foreach ($competenceBody as $key => $value) {
                if ($key === 'criterias') {
                    foreach ($value as $item => $field) {
                        $checkedCriteriaIdList[] = ((int)$field['id']);
                    }
                }
            }
        }

        // get available Criterias from Database by criteria ids
        $checkedCriteriaObjects = $this->criteriaRepository->findBy(array('id' => $checkedCriteriaIdList));

        // loop through checked criterias and add to Criteria array
        if ($checkedCriteriaObjects != null) {
            foreach ($checkedCriteriaObjects as $criteria) {
                $careerProfile->addFkCriterion($criteria);
            }
        }

        $profession = $this->professionRepository->findOneBy(['id' => $positionId]);
        $careerProfile->setProfession($profession);
        $careerProfile->setIsArchived(0);

        $this->careerProfileRepository->save($careerProfile);
        return new Response(json_encode(['message' => 'Created']), Response::HTTP_CREATED);
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
        $careerProfile = $this->careerProfileRepository->fetchProfileByProfession($slug);

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
