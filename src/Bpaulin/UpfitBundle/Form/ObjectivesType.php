<?php

namespace Bpaulin\UpfitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectivesType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'objectives',
                'collection',
                array(
                    'type'         => new ObjectiveType(),
                )
            )
            ->add('edit', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'Bpaulin\UpfitBundle\Entity\User'
            )
        );
    }

    public function getName()
    {
        return 'bpaulin_upfitbundle_objectivestype';
    }
}
