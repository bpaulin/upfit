<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table("stage")
 * @ORM\Entity()
 */
class Stage extends ExerciseSettings
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
    protected $id;

    /**
     * exercise
     *
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="stages")
     */
    protected $exercise;

    /**
     * program
     *
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="stages")
     */
    protected $program;

    /**
     * return a new workout created with this stage properties
     *
     * @return \Bpaulin\UpfitBundle\Entity\Workout new workout
     */
    public function createWorkout()
    {
        $workout = new \Bpaulin\UpfitBundle\Entity\Workout();

        $workout->setExercise($this->getExercise())
            ->setPosition($this->getPosition())
            ->setSets($this->getSets())
            ->setNumber($this->getNumber())
            ->setUnit($this->getUnit())
            ->setDifficulty($this->getDifficulty())
            ->setDifficultyUnit($this->getDifficultyUnit());

        return $workout;
    }

    /**
     * Set program
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Program $program
     * @return Stage
     */
    public function setProgram(\Bpaulin\UpfitBundle\Entity\Program $program = null)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \Bpaulin\UpfitBundle\Entity\Program
     */
    public function getProgram()
    {
        return $this->program;
    }
}
