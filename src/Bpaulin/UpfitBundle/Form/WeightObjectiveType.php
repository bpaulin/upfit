<?php

namespace Bpaulin\UpfitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeightObjectiveType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'weightObjective',
                null,
                array(
                    "label" => "Objective"
                )
            )
            ->add(
                'weightTolerance',
                null,
                array(
                    "label" => "Tolerance"
                )
            )
            ->add(
                'save',
                'submit',
                array(
                    "label" => "Set Objective"
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bpaulin\UpfitBundle\Entity\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bpaulin_upfitbundle_weightobjectivetype';
    }
}
