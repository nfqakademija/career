<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Factory\FormViewFactory;
use App\Repository\CareerFormRepository;
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
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $viewHandler;
    private $formListViewFactory;
    private $formViewFactory;


    public function __construct(
        CareerFormRepository $careerFormRepository,
        ViewHandlerInterface $viewHandler,
        FormListViewFactory $formListViewFactory,
        FormViewFactory $formViewFactory
    )
    {
        $this->formListViewFactory = $formListViewFactory;
        $this->formViewFactory = $formViewFactory;
        $this->viewHandler = $viewHandler;
        $this->careerFormRepository = $careerFormRepository;
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
            return JsonResponse::create(['message' => 'Form not found']);
        }
        return $this->viewHandler->handle(View::create($this->formViewFactory->create($careerForm)));
    }

    /**
     *
     * @param Request $request
     *
     */
    public function postFormAction(Request $request)
    {
        // TODO: implement;
        $json = $request->request->all();
        var_dump($json);
    }
}
