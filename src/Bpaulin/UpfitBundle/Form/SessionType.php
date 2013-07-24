<?php

namespace Bpaulin\UpfitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('comment')
            ->add(
                'grade',
                'choice',
                array(
                    'choices' => array(
                        -2 => "Too easy",
                        -1 => "Easy",
                        0  => "Fine",
                        1  => "Hard",
                        2  => "Too Hard"
                    )
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bpaulin\UpfitBundle\Entity\Session'
            )
        );
    }

    public function getName()
    {
        return 'bpaulin_upfitbundle_sessiontype';
    }
}
