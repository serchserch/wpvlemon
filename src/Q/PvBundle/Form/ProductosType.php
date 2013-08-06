<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ProductosType extends AbstractType
{

    private $impuestos;
    private $almacenes;

    public function __construct($data)
    {
        $this->impuestos = $data['impuestos'];
        $this->almacenes = $data['almacenes'];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $impuestos = array();
        foreach ($this->impuestos as $value) {
            $impuestos += array($value['id'] => "{$value['nombre']} - {$value['porcentaje']} %");
        }

        $almacenes = array();
        foreach ($this->almacenes as $value) {
            $almacenes += array($value['id'] => $value['nombre']);
        }
        $builder
//            ->add('fecha_creacion')
//            ->add('fecha_modificacion')
//            ->add('activo')
//            ->add('agotado')
                ->add('codigo_de_barras', 'text', array(
                    'label' => 'Código de barras:',
                    'attr' => array(
                        'placeholder' => 'Si no tienes escáner, déjalo vacío'
                    ),
                    'constraints' => array(
                        new Length(array(
                            'min' => 0,
                            'max' => 120,
                            'maxMessage' => 'Es muy largo el código',
                            'minMessage' => 'Es muy corto el código'
                                )),
                        new Regex(array(
                            'message' => 'Sólo números y letras . Sin espacios',
                            'pattern' => '/^[a-zA-Z0-9]*$/',
                                )),
                    ),
                    'required' => false,
                ))
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Almacen
                ->add('almacen_id', 'choice', array(
                    //'mapped' => false,
                    'label' => 'Almacén',
                    'choices' => $almacenes,
                    'required' => true,
                ))

                // - - - - - - - - - - - - - - - - - - - - - - - - - - -Impuesto
                ->add('impuesto_id', 'choice', array(
                    //'mapped' => false,
                    'label' => 'Impuesto',
                    'choices' => $impuestos,
                    'required' => true,
                        //'data' => 2,
                        /**
                         * @todo Selecionar almacen seleccionado anteriormente
                         */
                ))
                ->add('nombre')
                ->add('descripcion')
                ->add('precio_compra')
                ->add('precio_venta')
                ->add('precio_mayoreo')
                ->add('cantidad_mayoreo')
                ->add('cantidad_minima')
                ->add('cantidad_actual')
                ->add('codigo_proveedor')
                ->add('sku')
                ->add('codigo_venta')
                ->add('codigo_compra')
                ->add('disponible', 'choice', array(
                    'attr' => array(
                        'class' => 'choice'
                    ),
                    'label' => 'Disponible para venta al público:',
                    'choices' => array(
                        0 => 'No disponible',
                        1 => 'Disponible',
                    ),
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
                    'data' => 1,
                ))
                ->add('imagen', 'file',array(
                    'mapped' => false,
                    'required' => false,
                    'constraints' => array(
                        new File(array(
                            'maxSize' => '2M',
                            'maxSizeMessage'=> 'Máximo 2Megas',
                            'notReadableMessage' => 'No se puede leer tu archivo',
                            
                        )),
                        new Image(array(
                            'mimeTypesMessage' => 'Solo imágenes.',
                            'sizeNotDetectedMessage' => 'No se puede detectar el tamaño',
                            
                        )),
                    ),
                ))

        ;

//        $callback = function(FormInterface $form){
//            if ( ! is_numeric($form['almacen'])){
//                $form->addError(new FormError('No es válido'));
//            }
//            
//            if ( ! is_numeric($form['impuesto'])){
//                $form->addError(new FormError('No es válido'));
//            }
//            
//        };
//        
//        $builder->addValidator($callback);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\Productos'
        ));
    }

    public function getName()
    {
        return 'q_pvbundle_productostype';
    }

}
