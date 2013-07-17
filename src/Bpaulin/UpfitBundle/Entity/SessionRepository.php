<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Session repository
 */
class SessionRepository extends EntityRepository
{
    /**
     * Return unfinished sessions for a user
     *
     * @param  \Bpaulin\UpfitBundle\Entity\User $user
     */
    public function findUnfinishedByUser(\Bpaulin\UpfitBundle\Entity\User $user)
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
