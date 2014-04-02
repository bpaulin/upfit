<?php

namespace Bpaulin\UpfitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Bpaulin\UpfitBundle\Entity\WeightRepository")
 * @ORM\Table(name="weight",
 * uniqueConstraints={@ORM\UniqueConstraint(name="one_a_day", columns={"dateRecord", "user_id"})})
 */
class Weight
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
     * storing date
     *
     * @ORM\Column(type="date")
     */
    protected $dateRecord;

    /**
     * weight
     *
     * @ORM\Column(type="decimal", scale=1, precision=4)
     */
    protected $weight;

    /**
     * user
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="weights")
     */
    protected $user;

    public function daysAgo()
    {
        $datediff = $this->dateRecord->diff(new \DateTime());
        return $datediff->format('%a');
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
     * Set dateRecord
     *
     * @param \DateTime $dateRecord
     * @return Weight
     */
    public function setDateRecord($dateRecord)
    {
        $this->dateRecord = $dateRecord;

        return $this;
    }

    /**
     * Get dateRecord
     *
     * @return \DateTime
     */
    public function getDateRecord()
    {
        return $this->dateRecord;
    }

    /**
     * Set user
     *
     * @param \Bpaulin\UpfitBundle\Entity\User $user
     * @return Weight
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
     * Set weight
     *
     * @param integer $weight
     * @return Weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
