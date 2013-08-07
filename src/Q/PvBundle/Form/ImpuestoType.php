<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImpuestoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'attr' => array(
                    'value' => 'i.v.a.',
                ),
            ))
            ->add('porcentaje' , 'number', array(
                'attr' => array(
                    'value' => '16',
                ),
                'invalid_message' => 'Solo numeros'
            ))
            //->add('fechaCreacion')
            //->add('fechaModificacion')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\Impuesto'
        ));
    }

    public function getName()
    {
        return 'q_pvbundle_impuestotype';
    }
}
