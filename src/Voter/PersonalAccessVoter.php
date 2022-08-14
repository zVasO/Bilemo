<?php

namespace App\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PersonalAccessVoter extends Voter
{
    private const ROLE_ADMIN = "ROLE_ADMIN";
    private const CAN_ACCESS = "CAN_ACCESS";

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if ($attribute != self::CAN_ACCESS) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $userConnected = $token->getUser();

        if (!$userConnected instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a User object, thanks to `supports()`
        /** @var User $user */
        $user = $subject;

        if ($attribute == self::CAN_ACCESS) {
            return self::canUserAccess($userConnected, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $userConnected
     * @param User $user
     * @return bool
     */
    private function canUserAccess(User $userConnected, User $user): bool
    {
        if (in_array(self::ROLE_ADMIN, $userConnected->getRoles())) {
            return true;
        } else {
            return $userConnected->getId() === $user->getId();
        }
    }
}
