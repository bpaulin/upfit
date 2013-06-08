<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stage
 *
 * @ORM\Table("stage")
 * @ORM\Entity()
 */
class Stage
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
     * @ORM\ManyToOne(targetEntity="Exercise")
     */
    protected $exercise;

    /**
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="stages")
     */
    protected $program;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $position;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $sets;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $number;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $unit;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $difficulty;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $difficultyUnit;

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
     * Set position
     *
     * @param integer $position
     * @return Stage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set exercise
     *
     * @param \Bpaulin\UpfitBundle\Entity\Exercise $exercise
     * @return Stage
     */
    public function setExercise(\Bpaulin\UpfitBundle\Entity\Exercise $exercise = null)
    {
        $this->exercise = $exercise;

        return $this;
    }

    /**
     * Get exercise
     *
     * @return \Bpaulin\UpfitBundle\Entity\Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * Set program
     *
     * @param \Bpaulin\UpfitBundle\Entity\Program $program
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

    /**
     * Set sets
     *
     * @param integer $sets
     * @return Stage
     */
    public function setSets($sets)
    {
        $this->sets = $sets;

        return $this;
    }

    /**
     * Get sets
     *
     * @return integer
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Stage
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set unit
     *
     * @param integer $unit
     * @return Stage
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return integer
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set difficulty
     *
     * @param integer $difficulty
     * @return Stage
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
     * Set difficultyUnit
     *
     * @param integer $difficultyUnit
     * @return Stage
     */
    public function setDifficultyUnit($difficultyUnit)
    {
        $this->difficultyUnit = $difficultyUnit;

        return $this;
    }

    /**
     * Get difficultyUnit
     *
     * @return integer
     */
    public function getDifficultyUnit()
    {
        return $this->difficultyUnit;
    }
}
