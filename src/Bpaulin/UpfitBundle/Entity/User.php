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
     * weights
     *
     * @ORM\OneToMany(targetEntity="Weight", mappedBy="user", cascade={"remove", "persist"})
     */
    protected $weights;

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

    /**
     * Init missing objectives
     *
     * @param  Array $muscles
     * @return User
     */
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

    /**
     * Get objective for a muscle, return false if not defined
     *
     * @param  \Bpaulin\UpfitBundle\Entity\Muscle            $muscle
     * @return boolean|\Bpaulin\UpfitBundle\Entity\Objective
     */
    public function getObjectiveByMuscle(\Bpaulin\UpfitBundle\Entity\Muscle $muscle)
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

    /**
     * Add weights
     *
     * @param \Bpaulin\UpfitBundle\Entity\Weight $weights
     * @return User
     */
    public function addWeight(\Bpaulin\UpfitBundle\Entity\Weight $weights)
    {
        $this->weights[] = $weights;

        return $this;
    }

    /**
     * Remove weights
     *
     * @param \Bpaulin\UpfitBundle\Entity\Weight $weights
     */
    public function removeWeight(\Bpaulin\UpfitBundle\Entity\Weight $weights)
    {
        $this->weights->removeElement($weights);
    }

    /**
     * Get weights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWeights()
    {
        return $this->weights;
    }
}
