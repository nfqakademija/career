<?php

namespace App\Controller;

use App\Factory\UserListViewFactory;
use App\Factory\UserViewFactory;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use FOS\RestBundle\View\View;

/**
 * Class UserController
 *
 * endpoints:
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
    /** @var UserRepository */
    private $userRepository;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var UserViewFactory */
    private $userViewFactory;

    /** @var UserListViewFactory */
    private $userListViewFactory;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        ViewHandlerInterface $viewHandler,
        UserViewFactory $userViewFactory,
        UserListViewFactory $userListViewFactory
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->viewHandler = $viewHandler;
        $this->userViewFactory = $userViewFactory;
        $this->userListViewFactory = $userListViewFactory;
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

    public function getTeamManagerAction($teamId)
    {
        $manager = $this->userRepository->findTeamManager($teamId);

        if (!$manager) {
            // fail to found team manager
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userListViewFactory->create($manager)));
    }

    public function getTeamUsersAction($teamId)
    {
        $users = $this->userRepository->findTeamUsers($teamId);

        if (!$users) {
            // fail to found team users
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userListViewFactory->create($users)));
    }
}
