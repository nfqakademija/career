<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Factory\ListViewFactory;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\UserRepository;
use App\Service\CareerFormService;
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
 * /api/form/list - get career form list;
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

    /** @var CareerFormService  */
    private $careerFormService;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        CareerProfileRepository $careerProfileRepository,
        UserRepository $userRepository,
        ViewHandlerInterface $viewHandler,
        FormViewFactory $formViewFactory,
        ListViewFactory $listViewFactory,
        CareerFormService $careerFormService
    ) {
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
        $this->careerProfileRepository = $careerProfileRepository;
        $this->userRepository = $userRepository;
        $this->listViewFactory = $listViewFactory;
        $this->careerFormService = $careerFormService;
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
        $user = $this->userRepository->findOneBy(['id' => $slug]);

        $careerForm = $this->careerFormService->getUserCareerForm($user);
        if (!$careerForm) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }

    public function getEvaluationListAction()
    {
        $formList = $this->careerFormRepository->findBy(['underEvaluation'  => true]);
        $this->listViewFactory->setViewFactory(FormViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($formList)));
    }

    public function getEvaluationAction($slug)
    {
        $user = $this->userRepository->findOneBy(['id' => $slug, 'underEvaluation'  => true]);

        $careerForm = $this->careerFormService->getUserCareerForm($user);
        if (!$careerForm) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }
}
