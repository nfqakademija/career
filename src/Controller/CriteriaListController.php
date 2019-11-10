<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\CriteriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CriteriaListController extends AbstractFOSRestController
{

    private $criteriaRepository = null;

    public function __construct(CriteriaRepository $criteriaRepository)
    {
        $this->criteriaRepository = $criteriaRepository;
    }

    /**
     * @return \App\Entity\Criteria[]
     */

    public function getCriteriaListAction()
    {
        return $this->criteriaRepository->fetchByCompetenceTitle('Experience');
    }
}
