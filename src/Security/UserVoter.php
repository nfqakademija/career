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

            $findUserTeams = $findUser->getTeam();
            $managerTeams = $user->getTeam();
            foreach ($managerTeams as $managerTeam) {
                foreach ($findUserTeams as $findUserTeam) {
                    if ($managerTeam->getId() === $findUserTeam->getId())
                        return true;
                }

            }
            return false;
        }

        // checking if logged user Id matches with given Id
        return $user->getId() === (int)$subject;
    }


    private function canViewByTeamId($subject, User $user)
    {
        if (!$this->security->isGranted('ROLE_HEAD')) {
            return false;
        }
        // checking if logged manager team Id matches with given Id
        $managerTeams = $user->getTeam();
        foreach ($managerTeams as $managerTeam) {
            if ($managerTeam->getId() === (int)$subject)
                return true;
        }
        return false;
    }
}
