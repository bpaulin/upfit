<?php
namespace Bpaulin\UpfitBundle\Tests\Form;

use Bpaulin\UpfitBundle\Form\ExerciseType;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Symfony\Component\Form\Test\TypeTestCase;

class ExerciseTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'name' => 'exercise'
        );

        $type = new ExerciseType();
        $form = $this->factory->create($type);

        $object = new Exercise();
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
