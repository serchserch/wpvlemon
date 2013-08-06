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
            ->add('nombre')
            ->add('descripcion')
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
