<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseSettings
 */
class MuscleSettings
{

    /**
     * muscle
     *
     * @ORM\ManyToOne(targetEntity="Muscle")
     */
    protected $muscle;

    /**
     * Set muscle
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Muscle $muscle
     * @return Objective
     */
    public function setMuscle(\Bpaulin\UpfitBundle\Entity\Muscle $muscle = null)
    {
        $this->muscle = $muscle;

        return $this;
    }

    /**
     * Get muscle
     *
     * @return \Bpaulin\UpfitBundle\Entity\Muscle
     */
    public function getMuscle()
    {
        return $this->muscle;
    }
}
