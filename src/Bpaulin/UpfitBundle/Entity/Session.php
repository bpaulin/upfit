<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Session
 *
 * @ORM\Table("session")
 * @ORM\Entity(repositoryClass="Bpaulin\UpfitBundle\Entity\SessionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Session
{
    /**
     * id
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * name
     *
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=150)
     */
    private $name;

    /**
     * comment
     *
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * grade
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min = "-2", max = "2")
     */
    protected $grade = 0;

    /**
     * beginning time
     *
     * @ORM\Column(type="datetime")
     */
    protected $beginning;

    /**
     * workouts
     *
     * @ORM\OneToMany(targetEntity="Workout", mappedBy="session", cascade={"remove", "persist"})
     * @Assert\Count(min = "1")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $workouts;

    /**
     * user
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    protected $user;

    /**
     * Set beginning to current time
     *
     * @ORM\PrePersist
     */
    public function initBeginning()
    {
        $this->beginning = new \DateTime();
    }

    /**
     * Duplicate program stages and details into this session
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Program $program origin
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function initWithProgram(\Bpaulin\UpfitBundle\Entity\Program $program)
    {
        $this->setName('following '.$program->getName());
        $this->setGrade(0);
        $this->setComment($program->getName());
        foreach ($program->getStages() as $stage) {
            $workout = $stage->createWorkout();
            $this->addWorkout($workout);
        }

        return $this;
    }

    /**
     * Duplicate session workouts into this session
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Session $session origin
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function initWithSession(\Bpaulin\UpfitBundle\Entity\Session $session)
    {
        $this->setName('following '.$session->getName());
        $this->setGrade(0);
        $this->setComment($session->getComment());
        foreach ($session->getWorkouts() as $index => $workout) {
            if ($workout->isDone() === true) {
                $copy = clone $workout;
                $copy->setDone(null);
                $copy->setGrade(null);
                $copy->setPosition($index);
                $this->addWorkout($copy);
            }
        }

        return $this;
    }

    /**
     * Return the next workout to do
     *
     * @return boolean|\Bpaulin\UpfitBundle\Entity\Session
     */
    public function getNextWorkout()
    {
        foreach ($this->getWorkouts() as $workout) {
            if ($workout->isDone() === null) {
                return $workout;
            }
        }

        return false;
    }

    /**
     * Abandon the next workout to do
     *
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function abandonWorkout()
    {
        $next = $this->getNextWorkout();
        $next->setDone(false);

        return $this;
    }

    /**
     * Pass the next workout to do
     *
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
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

        $this->removeWorkout($next);
        $this->addWorkout($next);

        return $this;
    }

    /**
     * Mark as done the next workout to do
     *
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function doneWorkout()
    {
        $next = $this->getNextWorkout();
        $next->setDone(true);

        return $this;
    }

    /**
     * Set grade to workouts average
     *
     * @return \Bpaulin\UpfitBundle\Entity\Session
     */
    public function setGradeToAverage()
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
            $avg = 0;
        }

        return $this->setGrade($avg);
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
     * @param  string  $name
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
     * @param  \Bpaulin\UpfitBundle\Entity\Workout $workouts
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
     * @param  string  $comment
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
     * Set grade
     *
     * @param  integer $grade
     * @return Session
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

    /**
     * Set user
     *
     * @param  \Bpaulin\UpfitBundle\Entity\User $user
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

    /**
     * Set beginning
     *
     * @param  \DateTime $beginning
     * @return Session
     */
    public function setBeginning($beginning)
    {
        $this->beginning = $beginning;

        return $this;
    }

    /**
     * Get beginning
     *
     * @return \DateTime
     */
    public function getBeginning()
    {
        return $this->beginning;
    }
}
