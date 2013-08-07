<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Email;

class TiendaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nombre', 'text', array(
                    'label' => 'Nombre :',
                    'attr' => array(
                        'placeholder' => 'Nombre de ti tuenda o sucursal.'
                    ),
                    'required' => true,
                ))
                
                ->add('descripcion', 'textarea', array(
                    'label' => 'Descripción :',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Descripción '
                    ),
                ))
                ->add('telefono1', 'text', array(
                    'label' => 'Teléfono :',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'El teléfono del negocio'
                    ),
                ))
                ->add('telefono2', 'text', array(
                    'label' => 'Teléfono alterno:',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Otro teléfono que tengan'
                    ),
                ))
                ->add('email','email',array(
                    'label' => 'E-mail:',
                    'required' => false,
                    'constraints' => array(
                        new Email(array(
                            'message' => "Esto no es un email válido"
                        )),
                    ),
                    'attr' => array(
                        'placeholder' => 'E-mail del negocio'
                    ),
                ))
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
