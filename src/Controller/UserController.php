<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserViewFactory;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Class UserController
 *
 *endpoints:
 * /api/users/logins/ - get user from login;
 * /api/users/{id} - get user information by id;
 * /api/user/all - get all active registered users;
 * /api/teams/{id}/manager - get team manager;
 * /api/teams/{id}/user - get team members;
 *
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{

    private $userRepository = null;
    private $normalizers = [];
    private $encoders = [];
    private $serializer = null;
    private $passwordEncoder;
    private $viewHandler;
    private $userViewFactory;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        ViewHandlerInterface $viewHandler,
        UserViewFactory $userViewFactory
    ) {
        $this->userRepository = $userRepository;
        $this->normalizers[] = new ObjectNormalizer();
        $this->encoders[] = new JsonEncoder();
        $this->serializer = new Serializer($this->normalizers, $this->encoders);
        $this->passwordEncoder = $passwordEncoder;
        $this->viewHandler = $viewHandler;
        $this->userViewFactory = $userViewFactory;
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

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($user)));
    }

    /**
     *
     * @param int $id
     * @return Response
     */
    public function getUserAction(int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            // user not found
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($user)));
    }

    public function getUserAllAction()
    {
        $user = $this->userRepository->findBy(['isActive' => 1]);

        if (!$user) {
            // users not found
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($user)));
    }

    public function getTeamManagerAction($teamId)
    {
        $manager = $this->userRepository->findTeamManager($teamId);

        if (!$manager) {
            // fail to found team manager
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($manager)));
    }

    public function getTeamUsersAction($teamId)
    {
        $users = $this->userRepository->findTeamUsers($teamId);

        if (!$users) {
            // fail to found team users
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($users)));
    }
}
