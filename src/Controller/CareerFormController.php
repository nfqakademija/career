<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Factory\ProfileViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Class CareerFormController
 *
 * endpoints:
 * /api/forms/{slug} - get career form by id; TODO: get career form by User id;
 * /api/form/list - get career form list; TODO: get career form list by team;
 * /api/forms - post new career form
 * TODO: get career form list by title;
 *
 * @package App\Controller
 */
class CareerFormController extends AbstractFOSRestController
{

    private $careerFormRepository = null;
    private $careerProfileRepository;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $viewHandler;
    private $formListViewFactory;
    private $formViewFactory;
    private $profileViewFactory;
    private $userRepository;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        ProfileViewFactory $profileViewFactory,
        UserRepository $userRepository,
        ViewHandlerInterface $viewHandler,
        FormListViewFactory $formListViewFactory,
        FormViewFactory $formViewFactory
    )
    {
        $this->formListViewFactory = $formListViewFactory;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->profileViewFactory = $profileViewFactory;
        $this->userRepository = $userRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     *
     *
     * @return Response
     */
    public function getFormListAction()
    {
        $formList = $this->careerFormRepository->findAll();
        return $this->viewHandler->handle(View::create($this->formListViewFactory->create($formList)));
    }


    /**
     *
     * @param $slug
     * @return Response
     */
    public function getFormAction($slug)
    {
        $careerForm = $this->careerFormRepository->findOneBy(['id' => $slug]);
        if ($careerForm === null) {
            return JsonResponse::create(['message' => 'Not found']);
        }
        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function postFormAction(Request $request)
    {
        $data = ((array)json_decode(((string)$request->getContent()), true));
        $userId = (array_key_exists('userId', $data[0])) ? (int)$data[0]['userId'] : null;
        $professionId = (array_key_exists('professionId', $data[2])) ? (int)$data[2]['professionId'] : null;
        $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $professionId]);
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        $existingForm = $this->careerFormRepository->findOneBy(['fkUser' => $userId]);
        $careerForm = ($existingForm) ? $existingForm : new CareerForm();

        if (!$user || !$careerProfile) {
            return JsonResponse::create(['message' => 'not found']);
        }

        $careerForm->setFkUser($user);
        $careerForm->setFkCareerProfile($careerProfile);
        $careerForm->setIsArchived(0);
        $careerForm->setCreatedAt(new \DateTime("now"));
        $this->careerFormRepository->save($careerForm);

        return $this->viewHandler->handle(View::create($this->profileViewFactory->create($careerProfile)));
    }
}
