<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Entity\CareerProfile;
use App\Entity\Criteria;
use App\Repository\CareerFormRepository;
use App\Repository\CareerProfileRepository;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CareerFormController extends AbstractFOSRestController
{

    private $careerFormRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(
        CareerFormRepository $careerFormRepository)
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

        $jsonObject = $this->serializer->serialize($formList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
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

        $jsonObject = $this->serializer->serialize($careerForm, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     *
     * @param Request $request
     *
     */
    public function postFormAction(Request $request)
    {
        $json = $request->request->all();
        var_dump($json);
    }
}
