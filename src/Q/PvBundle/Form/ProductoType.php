<?php

namespace Q\PvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;

class ProductoType extends AbstractType
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
                // - - - - - - - - - - - - - - - - - - - - - -  Codigo de barras
                ->add('codigoDeBarras','text',array(
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
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - S K U
                ->add('sku','text',array(
                    'label' => 'SKU:',
                    'attr' => array(
                        'placeholder' => 'Puedes crear tu propio código de artículo. (Lo puedes dejar vacío)',
                    ),
                    'required' => false,
                ))
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Nombre
                ->add('nombre','text',array(
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
                
                ->add('descripcion','textarea',array(
                    'label' => 'Descripción:',
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Describe tu producto'
                    ),
                ))
                
                
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Almacen
                ->add('almacen','choice',array(
                    'label' => 'Almacén',
                    'choices' => $almacenes,
                    'required' => true,
                ))
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - -Impuesto
                ->add('impuesto','choice',array(
                    'label' => 'Impuesto',
                    'choices' => $impuestos,
                    'required' => true,
                    //'data' => 2,
                    /**
                     * @todo Selecionar almacen seleccionado
                     */
                ))
                
                
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - precio compra
                ->add('precioCompra','number',array(
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
                
                // - - - - - - - - - - - - - - - - - - - - - - - - precio venta
                ->add('precioVenta','number',array(
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
                // - - - - - - - - - - - - - - - - - - - - - - - - precio mayoreo
                ->add('precioMayoreo','number',array(
                    'label' => 'Precio de Mayoreo:',
                    'attr' => array(
                        'placeholder' => 'Precio de mayoreo'
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
                
                
                // - - - - - - - - - - - - - - - - - - - - cantidad para mayoreo
                ->add('cantidadParaMayoreo','number',array(
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
                
                
                
                // - - - - - - - - - - - - - - - - - -cantidad minima en almacén
                ->add('cantidadMinima','number',array(
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
                
                
                // - - - - - - - - - - - - - - - - Cantidad actual en el almacén 
                ->add('cantidadActual','number',array(
                    'label' => 'Cantidad Actual',
                    'attr' => array(
                        'placeholder' => 'Las unidades que hay dentro del almacén'
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
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Agotado  
//                ->add('agotado','number',array(
//                    'label' => 'Cantidad actual en almacén:',
//                    'attr' => array(
//                        'placeholder' => 'Las unidades que hay dentro del almacén',
//                    ),
//                    'precision' => 2,
//                    'rounding_mode' => $roundup,
//                    'invalid_message' => 'Solo números',
//                    'constraints' => array(
//                        new Range(array(
//                            'min' => 0,
//                            'minMessage' => 'Debe ser cero o mayor',
//                        )),
//                    ),
//                ))
                
                
                
                // - - - - - - - - - - - - - - - - Cantidad actual en el almacén 
                ->add('disponible','choice',array(
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
                
                // - - - - - - - - - - - - - - - - - - - - Coodigo del proveedor
                ->add('codigoProveedor','text',array(
                    'label' => 'Código del proveedor:',
                    'attr' => array(
                        'placeholder' => 'El código que maneja tu proveedor. (Se puede dejar vacío)',
                    ),
                    'required' => false,
                ))
                
                
                
                
                // - - - - - - - - - - - - - - - - - - - - - - - Codigo de venta
                ->add('codigoDeVenta','text',array(
                    'label' => 'Código de venta',
                    'attr' => array(
                        'placeholder' => 'Código cuando vendes el artículo (Se puede dejar vacío)',
                    ),
                    'required' => false,
                ))
                
                // - - - - - - - - - - - - - - - - - - - - - - Codigo de Compra
                ->add('codigoDeCompra','text',array(
                    'label' => 'Código de compra',
                    'attr' => array(
                        'placeholder' => 'Código cuando compras éste artículo (Se puede dejar vacío)',
                    ),
                    'required' => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Q\PvBundle\Entity\Producto'
        ));
    }

    public function getName()
    {
        return 'producto';
    }

}
