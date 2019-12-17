<?php

namespace App\Controller;

use App\Factory\ListViewFactory;
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
 * /api/users/{id} - get user information by id;
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

    /** @var ListViewFactory  */
    private $listViewFactory;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        ViewHandlerInterface $viewHandler,
        UserViewFactory $userViewFactory,
        UserListViewFactory $userListViewFactory,
        ListViewFactory $listViewFactory
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->viewHandler = $viewHandler;
        $this->userViewFactory = $userViewFactory;
        $this->listViewFactory = $listViewFactory;
        $this->userListViewFactory = $userListViewFactory;
    }

    /**
     *
     * @param int $id
     * @return Response
     */
    public function getUserAction(int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $this->denyAccessUnlessGranted('user', $user);


        if (!$user) {
            // user not found
            return new Response(Response::HTTP_NOT_FOUND);
        }

        return $this->viewHandler->handle(View::create($this->userViewFactory->create($user)));
    }

    /**
     * @param int $teamId
     * @return Response
     */
    public function getTeamManagerAction(int $teamId)
    {
        $manager = $this->userRepository->findTeamManager($teamId);

        if (!$manager) {
            // fail to found team manager
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $this->listViewFactory->setViewFactory(UserViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($manager)));
    }

    /**
     * @param int $teamId
     * @return Response
     */
    public function getTeamUsersAction(int $teamId)
    {
        $this->denyAccessUnlessGranted('team', $teamId);
        $users = $this->userRepository->findTeamUsers($teamId);

        if (!$users) {
            // fail to found team users
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $this->listViewFactory->setViewFactory(UserViewFactory::class);
        return $this->viewHandler->handle(View::create($this->listViewFactory->create($users)));
    }
}
