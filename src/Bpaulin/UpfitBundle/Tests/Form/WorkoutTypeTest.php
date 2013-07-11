<?php
namespace Bpaulin\UpfitBundle\Tests\Form;

use Bpaulin\UpfitBundle\Form\WorkoutType;
use Bpaulin\UpfitBundle\Entity\Workout;
use Symfony\Component\Form\Test\TypeTestCase;

class WorkoutTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'grade' => 1
        );

        $type = new WorkoutType();
        $form = $this->factory->create($type);

        $object = new Workout();
        $object->setGrade($formData['grade']);

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
