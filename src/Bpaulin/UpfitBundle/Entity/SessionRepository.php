<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function findUnfinishedByUser($user)
    {
        return $this->createQueryBuilder('s')
            ->join('s.workouts', 'w')
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->andWhere('w.done IS NULL')
            ->getQuery()
            ->getResult();
    }
}
