<?php
namespace Bpaulin\UpfitBundle\Tests\Form;

use Bpaulin\UpfitBundle\Form\SessionType;
use Bpaulin\UpfitBundle\Entity\Session;
use Symfony\Component\Form\Test\TypeTestCase;

class SessionTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'name' => 'exercise'
        );

        $type = new SessionType();
        $form = $this->factory->create($type);

        $object = new Session();
        $object->setName($formData['name']);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
