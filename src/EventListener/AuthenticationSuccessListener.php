<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Factory\UserViewFactory;

class AuthenticationSuccessListener
{
    /** @var UserViewFactory */
    private $userViewFactory;

    /**
     * AuthenticationSuccessListener constructor.
     * @param UserViewFactory $userViewFactory
     */
    public function __construct(UserViewFactory $userViewFactory)
    {
        $this->userViewFactory = $userViewFactory;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        if (!$user->getIsActive()) {
            return;
        }

        $data['data'] = $this->userViewFactory->create($user);
        $event->setData($data);
    }
}
