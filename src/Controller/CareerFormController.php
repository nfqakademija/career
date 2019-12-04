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
use App\Repository\UserAnswerRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Class CareerFormController
 *
 * endpoints:
 * /api/forms/{slug} - get career form by User id.
 * If User does not have a career form assigned, create one by career profile;
 * /api/form/list - get career form list; TODO: get career form list by team;
 * /api/answers - post answer
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
    private $userAnswerRepository;
    private $criteriaRepository;
    private $criteriaChoiceRepository;
    private $userAnswerViewFactory;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        ProfileViewFactory $profileViewFactory,
        UserRepository $userRepository,
        UserAnswerRepository $userAnswerRepository,
        ViewHandlerInterface $viewHandler,
        FormListViewFactory $formListViewFactory,
        FormViewFactory $formViewFactory,
        CriteriaRepository $criteriaRepository,
        CriteriaChoiceRepository $criteriaChoiceRepository,
        UserAnswerViewFactory $userAnswerViewFactory
    ) {
        $this->formListViewFactory = $formListViewFactory;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->profileViewFactory = $profileViewFactory;
        $this->userRepository = $userRepository;
        $this->userAnswerRepository = $userAnswerRepository;
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
     * @throws \Exception
     */
    public function getFormAction($slug)
    {

        $user = $this->userRepository->findOneBy(['id' => $slug]);
        $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $user->getProfession()->getId()]);

        $existingForm = $this->careerFormRepository->findOneBy(['fkUser' => $user]);
        $careerForm = ($existingForm) ? $existingForm : new CareerForm();

        if (!$careerForm->getId()) {
            $careerForm->setFkUser($user);
            $careerForm->setFkCareerProfile($careerProfile);
            $careerForm->setIsArchived(0);
            $careerForm->setCreatedAt(new \DateTime("now"));
            $this->careerFormRepository->save($careerForm);
        }
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

        $data = ((array)json_decode(((string)$request->getContent()), true))['data'];
        $formId = (array_key_exists('formId', $data)) ? (int)$data['formId'] : null;
        $answers = (array_key_exists('answers', $data)) ? (array)$data['answers'] : null;

        $choiceIds = array();
        foreach ($answers as $answerId => $answerBody) {
            foreach ($answerBody as $key => $value) {
                if ($key === 'choiceId') {
                    $choiceIds[] = (int)$value;
                }
            }
        }

        $choices = $this->criteriaChoiceRepository->findBy(array('id' => $choiceIds));

        $form = $this->careerFormRepository->findOneBy(['id' => $formId]);

        foreach ($choices as $choice) {
            $answered = $this->userAnswerRepository->findOneBy(['fkChoice' => $choice]);
            $userAnswer = ($answered) ? $answered : new UserAnswer();
            $userAnswer->setFkChoice($choice);
            $userAnswer->setFkCriteria($choice->getFkCriteria());
            $this->userAnswerRepository->save($userAnswer);
            $userAnswer->setFkCareerForm($form);
            $form->addUserAnswer($userAnswer);
        };

        $this->careerFormRepository->save($form);

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($form)));
    }
}
