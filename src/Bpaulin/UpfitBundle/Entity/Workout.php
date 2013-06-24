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
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="workouts")
     */
    protected $exercise;

    /**
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="workouts")
     */
    protected $session;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $done;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min = "-2", max = "2")
     */
    protected $grade = 0;

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

    /**
     * Set grade
     *
     * @param integer $grade
     * @return Workout
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }
}
