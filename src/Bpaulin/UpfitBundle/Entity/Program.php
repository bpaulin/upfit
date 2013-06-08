<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Program
 *
 * @ORM\Table("program")
 * @ORM\Entity(repositoryClass="Bpaulin\UpfitBundle\Entity\ProgramRepository")
 */
class Program
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
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="program", cascade={"remove", "persist"})
     * @Assert\Count(min = "1")
     */
    protected $stages;


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
     * @return Program
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
    }

    /**
     * Add stages
     *
     * @param \Bpaulin\UpfitBundle\Entity\Stage $stages
     * @return Program
     */
    public function addStage(\Bpaulin\UpfitBundle\Entity\Stage $stages)
    {
        $this->stages[] = $stages;
        $stages->setProgram($this);
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
}
