<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Class UserController
 *
 *  * endpoints:
 * /api/users/logins/ - get user from login; TODO: get user by UserName and Password;
 * /api/users/{id} - get user information by id; TODO: get user by Id;
 * /api/users/all - get all users; TODO: get all registered users;
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{

    private $userRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $passwordEncoder;


    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function postUserLoginAction(Request $request)
    {

        // Fetch data from JSON
        $data = json_decode($request->getContent(), true);

        $user = $this->userRepository->findOneBy(['email' => $data['email']]);


        if (!$user) {
            // fail authentication with a custom error
            return new Response(Response::HTTP_NOT_FOUND);
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $data['password'])) {

            // fail authentication because bad password
            return new Response(Response::HTTP_UNAUTHORIZED);

        }

        $jsonObject = null;
        $jsonObject = $this->serializer->serialize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }


    /**
     *
     * @param int $id
     * @return Response
     */
    public function getUserAction(int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $jsonObject = null;
        if (empty($professionList)) {
            $jsonObject = json_encode(['message' => 'empty']);
        } else {
            $jsonObject = $this->serializer->serialize($user, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        }

        return new Response($jsonObject, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
