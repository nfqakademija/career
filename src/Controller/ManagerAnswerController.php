<?php

namespace App\Controller;

use App\Factory\FormListViewFactory;
use App\Factory\ProfileListViewFactory;
use App\Repository\CareerProfileRepository;
use App\Repository\CriteriaRepository;
use App\Repository\ProfessionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ManagerAnswerController extends AbstractFOSRestController
{
    private $careerFormRepository;
    private $viewHandler;
    private $formListViewFactory;


    public function __construct(
        ViewHandlerInterface $viewHandler,
        CareerFormRepository $careerFormRepository,
        FormListViewFactory $formListViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->formListViewFactory = $formListViewFactory;
        $this->careerFormRepository = $careerFormRepository;
    }




}
