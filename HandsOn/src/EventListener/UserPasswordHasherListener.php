<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'hashPassword', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'hashPassword', entity: User::class)]
class UserPasswordHasherListener
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function hashPassword(User $user, LifecycleEventArgs $event): void
    {
        if (!$user->getPassword() || str_starts_with($user->getPassword(), '$')) {
            return;
        }
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
    }
}
