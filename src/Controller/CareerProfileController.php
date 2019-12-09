<?php

namespace App\Controller;

use App\Entity\CareerProfile;
use App\Factory\ProfileViewFactory;
use FOS\RestBundle\View\ViewHandlerInterface;
use App\Factory\ProfileListViewFactory;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CareerProfileController
 *
 * endpoints:
 * /api/profiles/{slug} - get career profile title and id by profession id;
 * /api/profile/list - get all career profiles;
 * /api/profiles - post new career profile
 *
 * @package App\Controller
 */
class CareerProfileController extends AbstractFOSRestController
{
    /** @var CriteriaRepository  */
    private $criteriaRepository;

    /** @var CareerProfileRepository  */
    private $careerProfileRepository;

    /** @var ProfessionRepository  */
    private $professionRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    /** @var ProfileListViewFactory  */
    private $profileListViewFactory;

    /** @var ProfileViewFactory  */
    private $profileViewFactory;


    public function __construct(
        ViewHandlerInterface $viewHandler,
        CriteriaRepository $criteriaRepository,
        ProfessionRepository $professionRepository,
        CareerProfileRepository $careerProfileRepository,
        ProfileListViewFactory $profileListViewFactory,
        ProfileViewFactory $profileViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->profileListViewFactory = $profileListViewFactory;
        $this->profileViewFactory = $profileViewFactory;
        $this->professionRepository = $professionRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->criteriaRepository = $criteriaRepository;
    }

    /**
     *
     * @param Request $request
     * @return Response
     */
    public function postProfileAction(Request $request)
    {
        // Fetch data from JSON
        $data = ((array)json_decode(((string)$request->getContent()), true))['data'];

        // Get position ID from data
        $positionId = (int)array_shift($data)['position'];

        // Check if position has its career profile and create career profile object depending on the decision
        $existingProfile = $this->careerProfileRepository->findOneBy(['profession' => $positionId]);
        $careerProfile = ($existingProfile) ? $existingProfile : new CareerProfile();

        // Get competence array from data
        $competences = (array)array_shift($data)['competences'];
        // Gather all checked criteria ids
        $checkedCriteriaIdList = array();
        foreach ($competences as $competenceId => $competenceBody) {
            foreach ($competenceBody as $key => $value) {
                if ($key === 'criteriaList') {
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
        $careerProfile->setCriteriaCount(count($checkedCriteriaIdList));

        $this->careerProfileRepository->save($careerProfile);
        return new Response(json_encode(['message' => 'Created']), Response::HTTP_CREATED);
    }

    /**
     *
     * @return Response
     */
    public function getProfileListAction()
    {
        $profileList = $this->careerProfileRepository->findBy(['isArchived' => 0]);
        return $this->viewHandler->handle(View::create($this->profileListViewFactory->create($profileList)));
    }

    /**
     *
     * @param string $slug
     * @return Response
     */
    public function getProfileAction($slug)
    {
        $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $slug]);
        if (!$careerProfile) {
            return new Response(Response::HTTP_NOT_FOUND);
        }
        return $this->viewHandler->handle(View::create($this->profileViewFactory->create($careerProfile)));
    }
}
