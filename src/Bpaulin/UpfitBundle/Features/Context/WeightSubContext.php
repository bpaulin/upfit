<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

use Bpaulin\UpfitBundle\Entity\Weight;

class WeightSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
    }

    /**
     * @Given /^I filled weights:$/
     */
    public function iFilledWeights(TableNode $table)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();

        $user = $em->getRepository('BpaulinUpfitBundle:User')->findOneByUsername("member");
        foreach ($table->getHash() as $row) {
            $weight = new Weight();
            $weight
                ->setWeight($row["weight"])
                ->setDateRecord(new \DateTime($row["days ago"]." days ago"))
                ->setUser($user);
            $em->persist($weight);
        }
        $em->flush();
    }
}
