<?php

namespace App\Controller;

use App\Repository\CareerFormRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CareerFormController extends AbstractFOSRestController
{

    private $careerFormRepository = null;

    public function __construct(CareerFormRepository $careerFormRepository)
    {
        $this->careerFormRepository = $careerFormRepository;
    }

    /**
     * @param string $title
     */
    public function getNewAction(string $title)
    {
        return $this->careerFormRepository->newTable($title);
    }

}
