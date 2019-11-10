<?php

namespace App\Controller;

use App\Entity\Criteria;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\CriteriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CriteriaListController extends AbstractFOSRestController
{

    private $criteriaRepository = null;

    public function __construct(CriteriaRepository $criteriaRepository)
    {
        $this->criteriaRepository = $criteriaRepository;
    }

    /**
     * @return \FOS\RestBundle\View\View
     */
    public function getCriteriaListAction()
    {
        $criteriaList = $this->criteriaRepository->findBy([
            'isApplicable' => 1
        ]);
        // Tip : Inject SerializerInterface $serializer in the controller method
// and avoid these 3 lines of instanciation/configuration
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

// Serialize your object in Json
        $jsonObject = $serializer->serialize($criteriaList, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
// For instance, return a Response with encoded Json
        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);

    }

    /**
     * @param string $title
     * @return Criteria[]
     */
    public function getCriteriaAction(string $title)
    {
        return $this->criteriaRepository->fetchByCompetence($title);
    }

}
