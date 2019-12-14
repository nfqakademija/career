<?php

namespace App\Controller;

use App\Factory\ManagerAnswerViewFactory;
use App\Repository\ManagerAnswerRepository;
use App\Repository\UserAnswerRepository;
use App\Request\ManagerFeedbackRequest;
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
        // TODO: implement when json will be ready
        $requestObject = new ManagerFeedbackRequest($request);

        var_dump($requestObject->getMapEvaluationAndComments());

        $form = $this->careerFormRepository->findOneBy(['id' => $requestObject->getFormId()]);

        return new Response(json_encode(['message' => 'Created']), Response::HTTP_CREATED);
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
