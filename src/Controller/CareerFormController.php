<?php

namespace App\Controller;

use App\Repository\CareerFormRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CareerFormController
 *
 * routes:
 * /api/forms/{slug} - get career form by id; TODO: get career form by User id;
 * /api/form/list - get career form list; TODO: get career form list by team;
 * /api/forms - post new career form
 * TODO: get career form list by profession;
 *
 * @package App\Controller
 */
class CareerFormController extends AbstractFOSRestController
{

    private $careerFormRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(CareerFormRepository $careerFormRepository)
    {
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

        $jsonObject = null;
        if (empty($formList)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($formList, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }


    /**
     *
     * @param $slug
     * @return Response
     */
    public function getFormAction($slug)
    {
        $careerForm = $this->careerFormRepository->findBy(['id' => $slug]);

        $jsonObject = null;
        if (empty($careerForm)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($careerForm, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
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
