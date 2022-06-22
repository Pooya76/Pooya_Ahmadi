<?php
namespace App\EventListener;
use App\Entity\User;
use App\Entity\UserLogInterface;
use \Doctrine\ORM\Event\LifecycleEventArgs;
use \App\Entity\TimeLogInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MyLogListener
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        if(!is_null($tokenStorage->getToken()))
            $this->user = $tokenStorage->getToken()->getUser()->eraseCredentials();

    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if( $entity instanceof TimeLogInterface){
            $entity->setCreatedAt(new \DateTimeImmutable());
        }
        if(!is_null($this->user)){
            if( $entity instanceof UserLogInterface){
                $entity->setCreatedBy($this->user);
            }

        }

    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if( $entity instanceof TimeLogInterface){
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }

        if( $entity instanceof UserLogInterface){
            $entity->setUpdatedBy($this->user);
        }

    }
}