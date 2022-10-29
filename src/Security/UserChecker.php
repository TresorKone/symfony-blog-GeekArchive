<?php

namespace App\Security;

use App\Entity\User;
use DateTime;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user->getTemporalyBan() === null) {
            return;
        }

        $now = new DateTime();

        if ($now < $user->getTemporalyBan()) {
            throw new AccessDeniedHttpException('The user is temporally banned');
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {

    }

}