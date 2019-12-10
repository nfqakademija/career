<?php

namespace App\Controller;

use App\Factory\ManagerAnswerViewFactory;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerFeedbackController extends AbstractFOSRestController
{
    /** @var UserAnswerRepository  */
    private $userAnswerRepository;

    /** @var ManagerAnswerRepository  */
    private $managerAnswerRepository;

    /** @var ViewHandlerInterface  */
    private $viewHandler;

    /** @var ManagerAnswerViewFactory  */
    private $managerAnswerListViewFactory;


    public function __construct(
        ViewHandlerInterface $viewHandler,
        UserAnswerRepository $userAnswerRepository,
        ManagerAnswerViewFactory $managerAnswerViewFactory,
        ManagerAnswerRepository $managerAnswerRepository
    ) {
        $this->viewHandler = $viewHandler;
        $this->userAnswerRepository = $userAnswerRepository;
        $this->managerAnswerListViewFactory = $managerAnswerViewFactory;
        $this->managerAnswerRepository = $managerAnswerRepository;
    }


    public function postFeedbackAction(Request $request)
    {
        $data = ((array)json_decode(((string)$request->getContent()), true))['data'];
        $formId = (array_key_exists('formId', $data)) ? (int)$data['formId'] : null;
        $criterias = (array_key_exists('criterias', $data)) ? (array)$data['criterias'] : null;

        if (!$criterias) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $form = $this->careerFormRepository->findOneBy(['id' => $formId]);

        return true;
    }

    /**
     * @param $slug
     * @return Response
     */
    public function getFeedbackAction($slug)
    {
        $userAnswers = $this->userAnswerRepository->findBy(['fkCareerForm' => $slug]);
        $feedback = $this->managerAnswerRepository->findBy(['fkUserAnswer' => $userAnswers]);

        if (!$feedback) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->managerAnswerListViewFactory->create($feedback)));
    }
}
