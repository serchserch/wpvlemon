<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;


//  Validadores
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
        
        $roundup = \Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer::ROUND_UP;
        
        $builder
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - -  Código de barras
                ->add('codigo_de_barras', 'text', array(
                    'label' => 'Código de barras:',
                    'required' => false,
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
                    
                ))
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Almacen
                ->add('almacen_id', 'choice', array(
                    'label' => 'Almacén',
                    'required' => true,
                    'choices' => $almacenes,
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
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - -  Nombre
                ->add('nombre', 'text', array(
                    'label' => 'Nombre:',
                    'attr' => array(
                        'placeholder' => 'Nombre de tu producto'
                    ),
                    'required' => true,
                    'constraints' => array(
                        new Length(array(
                            'min' => 5,
                            'max' => 45,
                            'maxMessage' => 'El nombre es muy largo',
                            'minMessage' => 'El nombre es muy corto'
                                )),
                    ),
                ))
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - Descripcion
                ->add('descripcion', 'textarea', array(
                    'label' => 'Descripción:',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Describe tu producto'
                    ),
                ))
                
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - -Precio de compra
                ->add('precio_compra', 'number', array(
                    'label' => 'Precio de compra:',
                    'attr' => array(
                        'placeholder' => 'Precio al que tu lo adquieres'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números ',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - Precio de venta
                ->add('precio_venta', 'number', array(
                    'label' => 'Precio de venta:',
                    'attr' => array(
                        'placeholder' => 'Precio de venta'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                // - - - - - - - - - - - - - - - - - - - - - -Precio de mayoreo
                ->add('precio_mayoreo', 'number', array(
                    'label' => 'Precio de Mayoreo:',
                    'attr' => array(
                        'placeholder' => 'Precio de mayoreo, si no manejas pon el mismo precio de venta'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números ',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                // - - - - - - - - - - - - - - - - - - - - - Cantidad de mayoreo
                ->add('cantidad_mayoreo', 'number', array(
                    'label' => 'Cantidad Mayoreo:',
                    'attr' => array(
                        'placeholder' => 'Cantidad que necesitas vender para que se considere mayoreo'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                // - - - - - - - - - - - - - - - - - - - - - - - Cantidad minima
                ->add('cantidad_minima', 'number', array(
                    'label' => 'Cantidad Mínima',
                    'attr' => array(
                        'placeholder' => 'Cantidad mínima de unidades que requieres en almacén'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                // - - - - - - - - - - - - - - - - - - - - - - - Cantidad actual
                ->add('cantidad_actual', 'number', array(
                    'label' => 'Cantidad Actual',
                    'attr' => array(
                        'placeholder' => 'Las cantidad que hay en almacén'
                    ),
                    'precision' => 2,
                    'rounding_mode' => $roundup,
                    'invalid_message' => 'Solo números',
                    'constraints' => array(
                        new Range(array(
                            'min' => 0,
                            'minMessage' => 'Debe ser cero o mayor',
                                )),
                    ),
                ))
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - SKU
                ->add('sku','text',array(
                    'label' => 'SKU:',
                    'attr' => array(
                        'placeholder' => 'Puedes crear tu propio código de artículo. (Lo puedes dejar vacío)',
                    ),
                    'required' => false,
                ))

                 
                // ->add('codigo_proveedor')
                //->add('codigo_venta')
                //->add('codigo_compra')
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - SKU
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
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - -Imagen
                ->add('imagen', 'file', array(
                    'mapped' => false,
                    'required' => false,
                    'constraints' => array(
                        new File(array(
                            'maxSize' => '2M',
                            'maxSizeMessage' => 'Máximo 2 MBs',
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
