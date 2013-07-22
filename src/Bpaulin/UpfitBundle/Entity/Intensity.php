<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Insentity
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Intensity
{
    /**
     * Id
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * intensity
     *
     * @var integer
     *
     * @ORM\Column(name="intensity", type="smallint")
     * @Assert\Range(min = "-1", max = "1")
     */
    private $intensity;

    /**
     * Exercise
     *
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="intensities")
     */
    protected $exercise;

    /**
     * muscle
     *
     * @ORM\ManyToOne(targetEntity="Muscle")
     */
    protected $muscle;

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
     * Set intensity
     *
     * @param  integer   $intensity
     * @return Intensity
     */
    public function setIntensity($intensity)
    {
        $this->intensity = $intensity;

        return $this;
    }

    /**
     * Get intensity
     *
     * @return integer
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Set exercise
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Exercise $exercise
     * @return Intensity
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
     * Set muscle
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Muscle $muscle
     * @return Intensity
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
