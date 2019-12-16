<?php


namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{

    const USER_ID = 'user_id';
    const TEAM_ID = 'team_id';

    private $security;

    private $userRepository;

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::USER_ID, self::TEAM_ID])) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::USER_ID:
                return $this->canViewByUserId($subject, $user);
            case self::TEAM_ID:
                return $this->canViewByTeamId($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canViewByUserId($subject, User $user)
    {
        if ($this->security->isGranted('ROLE_HEAD')) {
            $findUser = $this->userRepository->findOneBy(['id' => $subject]);
            $findUserTeam = $findUser->getTeam();
            $managerTeam = $user->getTeam();
            return $managerTeam['id'] === $findUserTeam['id'];

        }

        // checking if logged user Id matches with given Id
        return $user->getId() === $subject;
    }


    private function canViewByTeamId($subject, User $user)
    {
        if (!$this->security->isGranted('ROLE_HEAD')) {
            return false;
        }
        // checking if logged manager team Id matches with given Id
        $managerTeam = $user->getTeam();
        return $managerTeam['id'] === $subject;
    }
}
