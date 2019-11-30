<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Entity\UserAnswer;
use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Factory\ProfileViewFactory;
use App\Factory\UserAnswerViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaChoiceRepository;
use App\Repository\CriteriaRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    private $viewHandler;
    private $formListViewFactory;
    private $formViewFactory;
    private $profileViewFactory;
    private $userRepository;
    private $criteriaRepository;
    private $criteriaChoiceRepository;
    private $userAnswerViewFactory;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        ProfileViewFactory $profileViewFactory,
        UserRepository $userRepository,
        ViewHandlerInterface $viewHandler,
        FormListViewFactory $formListViewFactory,
        FormViewFactory $formViewFactory,
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        UserAnswerViewFactory $userAnswerViewFactory
    )
    {
        $this->formListViewFactory = $formListViewFactory;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->profileViewFactory = $profileViewFactory;
        $this->userRepository = $userRepository;
        $this->criteriaRepository = $criteriaRepository;
        $this->criteriaChoiceRepository = $criteriaChoiceRepository;
        $this->userAnswerViewFactory = $userAnswerViewFactory;
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
     * @throws \Exception
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

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function postAnswerAction(Request $request)
    {

        $data = ((array)json_decode(((string)$request->getContent()), true));
        $formId = (array_key_exists('formId', $data[0])) ? (int)$data[0]['formId'] : null;
        $answers = (array_key_exists('answers', $data[1])) ? (array)$data[1]['answers'] : null;

        $choiceIds = array();
        foreach ($answers as $answerId => $answerBody) {
            foreach ($answerBody as $key => $value) {
                if ($key === 'choice') {
                    $choiceIds[] = (int) $value;
                }
            }
        }

        $choices = $this->criteriaChoiceRepository->findBy(array('id' => $choiceIds));

        $form = $this->careerFormRepository->findOneBy(['id' => $formId]);

        foreach ($choices as $choice) {
            $userAnswer = new UserAnswer();
            $userAnswer->setFkChoice($choice);
            $userAnswer->setFkCriteria($choice->getFkCriteria());
            $userAnswer->setFkCareerForm($form);
            $form->addUserAnswer($userAnswer);
        };

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));

    }
}
