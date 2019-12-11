<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Entity\User;
use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Factory\ListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\UserRepository;
use App\Service\CareerProfileService;
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

    /** @var FormViewFactory */
    private $formViewFactory;

    /** @var UserRepository */
    private $userRepository;

    /** @var ListViewFactory  */
    private $listViewFactory;

    /** @var CareerProfileService */
    private $careerProfileService;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        UserRepository $userRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        ListViewFactory $listViewFactory,
        CareerProfileService $careerProfileService
    ) {
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->userRepository = $userRepository;
        $this->listViewFactory = $listViewFactory;
        $this->careerProfileService = $careerProfileService;
    }

    /**
     *
     * @return Response
     */
    public function getFormListAction()
    {
        $formList = $this->careerFormRepository->findAll();
        $this->listViewFactory->setViewFactory(FormViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($formList)));
    }


    /**
     *
     * @param $slug
     * @return Response
     * @throws \Exception
     */
    public function getFormAction(int $slug)
    {
        $careerForm = $this->careerFormRepository->findOneBy(['fkUser' => $slug]) ?? new CareerForm();

        if (!$careerForm->getId()) {
            $user = $this->userRepository->findOneBy(['id' => $slug]);
            $careerProfile = $this->careerProfileRepository->findOneBy(['profession' => $user->getProfession()->getId()]);
            $careerForm->setFkUser($user);
            $careerForm->setFkCareerProfile($careerProfile);
            $careerForm->setIsArchived(0);
            $careerForm->setCreatedAt(new \DateTime("now"));
            $this->careerFormRepository->save($careerForm);
        }
        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }
}
