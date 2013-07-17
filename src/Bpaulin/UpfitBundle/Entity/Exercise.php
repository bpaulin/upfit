<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Exercise
 *
 * @ORM\Table("exercise")
 * @ORM\Entity()
 */
class Exercise
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
     * stages
     *
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="exercise", cascade={"remove"})
     */
    protected $stages;

    /**
     * workouts
     *
     * @ORM\OneToMany(targetEntity="Workout", mappedBy="exercise", cascade={"remove"})
     */
    protected $workouts;

    /**
     * objectives
     *
     * @ORM\OneToMany(targetEntity="Intensity", mappedBy="exercise", cascade={"remove", "persist"})
     */
    protected $intensities;

    public function fillIntensities($muscles)
    {
        foreach ($muscles as $muscle) {
            if (!$this->getIntensityByMuscle($muscle)) {
                $intensity = new Intensity();
                $intensity
                    ->setExercise($this)
                    ->setMuscle($muscle)
                    ->setIntensity(0);
                $this->addIntensity($intensity);
            }
        }

        return $this;
    }

    public function getIntensityByMuscle($muscle)
    {
        foreach ($this->intensities as $intensity) {
            if ($intensity->getMuscle() === $muscle) {
                return $intensity;
            }
        }

        return false;
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
     * @param  string   $name
     * @return Exercise
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
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workouts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->intensities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stages
     *
     * @param \Bpaulin\UpfitBundle\Entity\Stage $stages
     * @return Exercise
     */
    public function addStage(\Bpaulin\UpfitBundle\Entity\Stage $stages)
    {
        $this->stages[] = $stages;

        return $this;
    }

    /**
     * Remove stages
     *
     * @param \Bpaulin\UpfitBundle\Entity\Stage $stages
     */
    public function removeStage(\Bpaulin\UpfitBundle\Entity\Stage $stages)
    {
        $this->stages->removeElement($stages);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * Add workouts
     *
     * @param \Bpaulin\UpfitBundle\Entity\Workout $workouts
     * @return Exercise
     */
    public function addWorkout(\Bpaulin\UpfitBundle\Entity\Workout $workouts)
    {
        $this->workouts[] = $workouts;

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
     * Add intensities
     *
     * @param \Bpaulin\UpfitBundle\Entity\Intensity $intensities
     * @return Exercise
     */
    public function addIntensity(\Bpaulin\UpfitBundle\Entity\Intensity $intensity)
    {
        $this->intensities[] = $intensity;

        return $this;
    }

    /**
     * Remove intensities
     *
     * @param \Bpaulin\UpfitBundle\Entity\Intensity $intensities
     */
    public function removeIntensity(\Bpaulin\UpfitBundle\Entity\Intensity $intensity)
    {
        $this->intensities->removeElement($intensity);
    }

    /**
     * Get intensities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIntensities()
    {
        return $this->intensities;
    }
}
