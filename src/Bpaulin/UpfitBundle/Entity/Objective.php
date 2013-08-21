<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Objective
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Objective extends MuscleSettings
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
     * Will
     *
     * @var integer
     *
     * @ORM\Column(name="will", type="smallint")
     * @Assert\Range(min = "-1", max = "1")
     */
    private $will;

    /**
     * User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="objectives")
     */
    protected $user;

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
     * Set will
     *
     * @param  integer    $will
     * @return UserMuscle
     */
    public function setWill($will)
    {
        $this->will = $will;

        return $this;
    }

    /**
     * Get will
     *
     * @return integer
     */
    public function getWill()
    {
        return $this->will;
    }

    /**
     * Set user
     *
     * @param  \Bpaulin\UpfitBundle\Entity\User $user
     * @return Objective
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
