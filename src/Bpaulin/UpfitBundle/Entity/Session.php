<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Session
 *
 * @ORM\Table("session")
 * @ORM\Entity()
 */
class Session
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity="Workout", mappedBy="session", cascade={"persist"})
     * @Assert\Count(min = "1")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $workouts;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;

    /**
     * Duplicate program stages into this session
     */
    public function initWithProgram(\Bpaulin\UpfitBundle\Entity\Program $program)
    {
        $this->setName('following '.$program->getName());
        $this->setDifficulty(0);
        $this->setComment($program->getName());
        foreach ($program->getStages() as $stage) {
            $workout = $stage->createWorkout();
            $this->addWorkout($workout);
        }
        return $this;
    }

    /**
     * Duplicate session workouts into this session
     */
    public function initWithSession(\Bpaulin\UpfitBundle\Entity\Session $session)
    {
        $this->setName('following '.$session->getName());
        $this->setDifficulty(0);
        $this->setComment($session->getComment());
        foreach ($session->getWorkouts() as $workout) {
            if ($workout->isDone() === true) {
                $copy = clone $workout;
                $copy->setDone(null);
                $this->addWorkout($copy);
            }
        }
        return $this;
    }

    public function getNextWorkout()
    {
        foreach ($this->getWorkouts() as $workout) {
            if ($workout->isDone() === null) {
                return $workout;
            }
        }
        return false;
    }

    public function abandonWorkout()
    {
        $next = $this->getNextWorkout();
        $next->setDone(false);
    }

    public function passWorkout()
    {
        $max = 0;
        foreach ($this->getWorkouts() as $workout) {
            if ($workout->getPosition() > $max) {
                $max = $workout->getPosition();
            }
        }
        $next = $this->getNextWorkout();
        $next->setPosition($max+1);
    }

    public function doneWorkout()
    {
        $next = $this->getNextWorkout();
        $next->setDone(true);
    }

    public function setDifficultyToAverage()
    {
        $sum = 0;
        $nb = 0;
        foreach ($this->getWorkouts() as $workout) {
            if ($workout->isDone()) {
                $sum += $workout->getGrade();
                $nb++;
            }
        }
        if ($nb>0) {
            $avg = round($sum/$nb);
        } else {
            $avg = 2;
        }
        return $this->setDifficulty($avg);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Session
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workouts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workouts
     *
     * @param \Bpaulin\UpfitBundle\Entity\Workout $workouts
     * @return Session
     */
    public function addWorkout(\Bpaulin\UpfitBundle\Entity\Workout $workouts)
    {
        $this->workouts[] = $workouts;
        $workouts->setSession($this);

        return $this;
    }

    /**
     * Remove workouts
     *
     * @param \Bpaulin\UpfitBundle\Entity\Workout $workouts
     */
    public function removeWorkout(\Bpaulin\UpfitBundle\Entity\Workout $workouts)
    {
        $this->workouts->removeElement($workouts);
    }

    /**
     * Get workouts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkouts()
    {
        return $this->workouts;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Session
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set difficulty
     *
     * @param integer $difficulty
     * @return Session
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set user
     *
     * @param \Bpaulin\UpfitBundle\Entity\User $user
     * @return Session
     */
    public function setUser(\Bpaulin\UpfitBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Bpaulin\UpfitBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
