<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Weight repository
 */
class WeightRepository extends EntityRepository
{
    /**
     * Return user's average weight for the last days
     * @param  User   $user
     * @param  int $days
     * @return int average weight
     */
    public function average(User $user, $days)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT avg(w.weight) AS average
            FROM BpaulinUpfitBundle:Weight w
            WHERE w.user = :user
            AND w.dateRecord >= :data'
        )->setParameter('user', $user)
        ->setParameter('data', new \DateTime("$days days ago"));

        $average = round($query->getResult()[0]['average']);
        return $average;
    }
}
