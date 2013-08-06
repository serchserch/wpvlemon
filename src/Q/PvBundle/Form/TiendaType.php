<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TiendaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('telefono1')
            ->add('telefono2','text',array(
                'required' => false,
            ))
            ->add('email')
            //->add('fechaCreacion')
            //->add('fechaModificacion')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\Tienda'
        ));
    }

    public function getName()
    {
        return 'q_pvbundle_tiendatype';
    }
}
