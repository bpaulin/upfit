<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Workout
 *
 * @ORM\Table("workout")
 * @ORM\Entity()
 */
class Workout extends ExerciseSettings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="workouts")
     */
    protected $session;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $done;

    /**
     * Set session
     *
     * @param \Bpaulin\UpfitBundle\Entity\Session $session
     * @return Stage
     */
    public function setSession(\Bpaulin\UpfitBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set done
     *
     * @param boolean $done
     * @return Workout
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->done;
    }
}
