<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

class StyleSubContext extends BehatContext
{
    public function assertElementContainsIcon($element, $iconClass)
    {
        $icon = $element->find('css', 'i');
        if (!$icon) {
            throw new \Exception('icon not found, icon-'.$icon.' wanted ');
        }
        $icon = $icon->getAttribute('class');
        if ($icon != 'icon-'.$iconClass) {
            throw new \Exception($icon.' is not expected, icon-'.$iconClass.' wanted ');
        }
    }

    public function assertElementContainsNoIcon($element)
    {
        $icon = $element->find('css', "i[class^='icon-']");
        if ($icon) {
            throw new \Exception('icon found, none wanted');
        }
    }
}
