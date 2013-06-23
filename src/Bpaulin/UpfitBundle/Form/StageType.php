<?php

namespace Bpaulin\UpfitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StageType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', 'hidden')
            ->add(
                'exercise',
                null,
                array(
                    'property'=> 'name'
                )
            )
            ->add(
                'sets',
                null,
                array(
                    'attr' => array(
                        'min'=> 0,
                        'max'=> 999,
                    )
                )
            )
            ->add(
                'number',
                null,
                array(
                    'attr' => array(
                        'min'=> 0,
                        'max'=> 999,
                    )
                )
            )
            ->add('unit')
            ->add(
                'difficulty',
                null,
                array(
                    'attr' => array(
                        'min'=> 0,
                        'max'=> 999,
                    )
                )
            )
            ->add('difficultyUnit')
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bpaulin\UpfitBundle\Entity\Stage'
            )
        );
    }

    public function getName()
    {
        return 'bpaulin_upfitbundle_stagetype';
    }
}
