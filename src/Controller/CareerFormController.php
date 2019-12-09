<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
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
 * /api/answers/{slug} - get answers by form id
 *
 * @package App\Controller
 */
class CareerFormController extends AbstractFOSRestController
{
    /** @var CareerFormRepository */
    private $careerFormRepository;

    /** @var CareerProfileRepository */
    private $careerProfileRepository;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var FormListViewFactory */
    private $formListViewFactory;

    /** @var FormViewFactory */
    private $formViewFactory;

    /** @var UserRepository */
    private $userRepository;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        UserRepository $userRepository,
        ViewHandlerInterface $viewHandler,
        FormListViewFactory $formListViewFactory,
        FormViewFactory $formViewFactory
    ) {
        $this->formListViewFactory = $formListViewFactory;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->userRepository = $userRepository;
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
    public function getFormAction(int $slug)
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
}
