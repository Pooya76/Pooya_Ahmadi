<?php

use App\Entity\Hotel;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class OwnerVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {

        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Hotel) {
            return false;
        }

        return true;

    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }



        /** @var Hotel $hotel */
        $hotel = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($hotel, $user);
            case self::DELETE:
                return $this->canDelete($hotel, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Hotel $hotel, User $user): bool
    {
        if (in_array('ROLE_EDITOR', $user->getRoles())) {
            return true;
        }
        return $user === $hotel->getCreatedBy();
    }

    private function canEdit(Hotel $hotel, User $user): bool
    {
        if (in_array('ROLE_EDITOR', $user->getRoles())) {
            return true;
        }
        return $user === $hotel->getCreatedBy();
    }
}