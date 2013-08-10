<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Program repository
 */
class ProgramRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BpaulinUpfitBundle:Program p ORDER BY p.name ASC'
            )
            ->getResult();
    }

    public function findRecent(User $user)
    {
        return $this->findAllOrderedByName();
    }

    public function findProposed(User $user)
    {
        $programs = $this->findAllOrderedByName();
        $return = array();
        foreach ($programs as $program) {
            $grade = $program->getGradeForUser($user);
            $return[] = array(
                'grade' => $grade,
                'program' => $program
            );
        }
        return $return;
    }
}
