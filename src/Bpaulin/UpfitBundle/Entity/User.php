<?php

namespace Bpaulin\UpfitBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * Id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * objectives
     *
     * @ORM\OneToMany(targetEntity="Objective", mappedBy="user", cascade={"remove", "persist"})
     */
    protected $objectives;

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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->objectives = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function fillObjectives($muscles)
    {
        foreach ($muscles as $muscle) {
            if (!$this->getObjectiveByMuscle($muscle)) {
                $objective = new Objective();
                $objective
                    ->setUser($this)
                    ->setMuscle($muscle)
                    ->setWill(0);
                $this->addObjective($objective);
            }
        }

        return $this;
    }

    public function getObjectiveByMuscle($muscle)
    {
        foreach ($this->objectives as $objective) {
            if ($objective->getMuscle() === $muscle) {
                return $objective;
            }
        }

        return false;
    }

    /**
     * Add objectives
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Objective $objective
     * @return User
     */
    public function addObjective(\Bpaulin\UpfitBundle\Entity\Objective $objective)
    {
        $this->objectives[] = $objective;
        $objective->setUser($this);

        return $this;
    }

    /**
     * Remove objectives
     *
     * @param \Bpaulin\UpfitBundle\Entity\Objective $objectives
     */
    public function removeObjective(\Bpaulin\UpfitBundle\Entity\Objective $objectives)
    {
        $this->objectives->removeElement($objectives);
    }

    /**
     * Get objectives
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjectives()
    {
        return $this->objectives;
    }
}
