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
                ->add('nombre', 'text', array(
                    'label' => 'Nombre :',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Tu nombre',
                    ),
                ))
                ->add('apellidoPaterno', 'text', array(
                    'label' => 'Apellido Paterno :',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Tu Apellido Paterno',
                    ),
                ))
                ->add('apellidoMaterno', 'text', array(
                    'label' => 'Apellido Materno :',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Tu Apellido Materno (si no tienes dejalo vacío)',
                    ),
                ))
                ->add('fechaNacimiento', 'date', array(
                    'label' => 'Fecha de nacimiento :',
                    'invalid_message'            => 'Esta fecha no es valida',
                    'widget' => 'single_text',
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'datepicker'
                    ),
                ))
                ->add('email', 'repeated', array(
                    'type' => 'email',
                    'invalid_message' => 'La dirección de email debe de coincidir ',
                    'required' => true,
                    'first_options' => array(
                        'label' => 'E-mail :',
                        'attr' => array(
                            'placeholder' => 'Un E-Mail que tengas',
                        ),
                    ),
                    'second_options' => array(
                        'label' => 'Repite el E-mail : ',
                        'attr' => array(
                            'placeholder' => 'Repite el E-mail',
                        ),
                    ),
                ))
                ->add('rfc','text',array(
                    'label' => 'R.F.C.',
                    'required' => true,
                ));

        if ($this->exist) {



            $builder->add('username', 'text', array(
                        'label' => 'Usuario :',
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
                        'label' => 'Pass - Contraseña',
                        'required' => true,
                        'attr' => array(
                            'placeholder' => 'Recuerda: tu contraseña, debe tener mas de 8 letras',
                        ),
            ));
        }

        $builder
                
                ->add('genero', 'choice', array(
                    'required' => true,
                    'choices' => array(
                        'm' => 'Mujer',
                        'h' => 'Hombre',
                        //'q' => 'Quimera',
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
                ));

        if ($this->exist) {
            $builder
                    ->add('terminos', 'checkbox', array(
                        'mapped' => false,
                        'label' => 'Ya leí y acepto los términos del servicio',
                        'required' => true,
            ));
        }
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
