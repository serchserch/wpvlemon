<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    private $exist;

    function __construct($exist = false)
    {
        $this->exist = $exist;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('email', 'email', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Un E-Mail que tengas',
                    ),
        ));

        if ($this->exist) {



            $builder->add('username', 'text', array(
                'label' => 'Usuario',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Tu usuario. Debe de ser único y no lo pdrás cambiar',
                    'class' => 'input',
                    'id' => 'username'
                ),
                'constraints' => array(
                ),
            ))
                    ->add('password', 'password', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Tu contraseña, debe tener mas de 8 letras',
                    ),
                ));
        }

        $builder
                
//            ->add('salt')
//            ->add('fechaCreacion')
//            ->add('fechaModificacion')
//            ->add('fechaVencimiento')
                ->add('nombre', 'text', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Tu nombre',
                    ),
                ))
                ->add('apellidoPaterno', 'text', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Tu Apellido Paterno',
                    ),
                ))
                ->add('apellidoMaterno', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Tu Apellido Materno (si no tienes dejalo vacío)',
                    ),
                ))
                ->add('fechaNacimiento', 'date', array(
                    'widget' => 'single_text',
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'datepicker'
                    ),
                ))
                ->add('genero', 'choice', array(
                    'required' => true,
                    'choices' => array(
                        'm' => 'Mujer',
                        'h' => 'Hombre',
                        'q' => 'Quimera',
                    ),
                ))
                ->add('telefonoFijo', 'text', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Teléfono (de preferencia fijo)',
                    ),
                ))
                ->add('telefonoMovil', 'text', array(
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Teléfono celular',
                    ),
                ))
                ->add('boletin', 'checkbox', array(
                    'label' => '¿Te gustaría que te llegaran noticias mensuales?',
                    'required' => false,
        ));


        if ($this->exist) {
            $builder
                    ->add('terminos', 'checkbox', array(
                        'mapped' => false,
                        'label' => 'Ya leí y acepto los términos del servicio',
                        'required' => true,
            ));
        }
//            ->add('user_role')
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'q_pvbundle_usertype';
    }

}
