<?php

namespace App\Controller;

use App\Repository\ProfessionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ProfessionController
 * @package App\Controller
 * routes:
 * /api/profession/list - get all profession registered
 *
 */
class ProfessionController extends AbstractFOSRestController
{
    private $professionRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;


    public function __construct(ProfessionRepository $professionRepository)
    {
        $this->professionRepository = $professionRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
    }

    /**
     *
     * @return Response
     */
    public function getProfessionListAction()
    {
        $professionList = $this->professionRepository->fetchTitlesAndIds();

        $jsonObject = null;
        if (empty($professionList)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($professionList, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
