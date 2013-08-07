<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlmacenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre','text',array(
                'label' => 'Nombre :',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'El nombre de tu almacén'
                ),
            ))
            ->add('descripcion','textarea',array(
                'label' => 'Descripción : ',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'El nombre de tu almacén.'
                ),
            ))
            //->add('fechaCreacion')
            //->add('fechaModificacion')
            //->add('activo')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\Almacen'
        ));
    }

    public function getName()
    {
        return 'q_pvbundle_almacentype';
    }
}
