<?php

namespace App\Controller;

use App\Entity\CareerForm;
use App\Entity\CareerProfile;
use App\Entity\Criteria;
use App\Repository\CareerFormRepository;
use App\Repository\CompetenceRepository;
use App\Repository\CriteriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     */
    public function postCareerAction(Request $request)
    {


    }
}
