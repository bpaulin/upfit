<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ExerciseSettings
 */
class ExerciseSettings
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
     * position
     *
     * @ORM\Column(type="smallint")
     */
    protected $position;

    /**
     * sets
     *
     * @ORM\Column(type="smallint")
     * @Assert\Range(min = "0", max = "999")
     */
    protected $sets;

    /**
     * number
     *
     * @ORM\Column(type="smallint")
     * @Assert\Range(min = "0", max = "999")
     */
    protected $number;

    /**
     * unit
     *
     * @ORM\Column(type="string", type="string", length=20 )
     */
    protected $unit;

    /**
     * difficulty
     *
     * @ORM\Column(type="smallint")
     * @Assert\Range(min = "0", max = "999")
     */
    protected $difficulty;

    /**
     * difficulty Unit
     *
     * @ORM\Column(type="string", type="string", length=20 )
     */
    protected $difficultyUnit;

    /**
     * Resting Time
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rest;

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
     * Set rest
     *
     * @param integer $rest
     * @return Stage
     */
    public function setRest($rest)
    {
        $this->rest = $rest;

        return $this;
    }

    /**
     * Get rest
     *
     * @return integer
     */
    public function getRest()
    {
        return $this->rest;
    }

    /**
     * Set position
     *
     * @param  integer          $position
     * @return ExerciseSettings
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
     * @param  \Bpaulin\UpfitBundle\Entity\Exercise $exercise
     * @return ExerciseSettings
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
     * Set sets
     *
     * @param  integer          $sets
     * @return ExerciseSettings
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
     * @param  integer          $number
     * @return ExerciseSettings
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
     * @param  integer          $unit
     * @return ExerciseSettings
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
     * @param  string           $difficulty
     * @return ExerciseSettings
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set difficultyUnit
     *
     * @param  string           $difficultyUnit
     * @return ExerciseSettings
     */
    public function setDifficultyUnit($difficultyUnit)
    {
        $this->difficultyUnit = $difficultyUnit;

        return $this;
    }

    /**
     * Get difficultyUnit
     *
     * @return string
     */
    public function getDifficultyUnit()
    {
        return $this->difficultyUnit;
    }
}
