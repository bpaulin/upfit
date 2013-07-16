<?php

namespace Bpaulin\UpfitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectiveType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('will')
            ->add(
                'muscle',
                null,
                array (
                    'property'=>'name'
                )
            )
            ->add(
                'user',
                null,
                array (
                    'property'=>'username'
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bpaulin\UpfitBundle\Entity\Objective'
            )
        );
    }

    public function getName()
    {
        return 'bpaulin_upfitbundle_objectivetype';
    }
}
