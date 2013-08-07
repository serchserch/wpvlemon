<?php

/**
Sin CONTINUACION
 */
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
                ->add('codigoDeBarras')
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - - S K U
                ->add('sku')
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - - - Nombre
                ->add('nombre')
                
                // - - - - - - - - - - - - - - - - - - - - - - - - - Descripcion
                
                ->add('descripcion')
                
                
                
                
                
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
                ->add('precioCompra')
                
                // - - - - - - - - - - - - - - - - - - - - - - - - precio venta
                ->add('precioVenta')
                // - - - - - - - - - - - - - - - - - - - - - - - - precio mayoreo
                ->add('precioMayoreo')
                
                
                // - - - - - - - - - - - - - - - - - - - - cantidad para mayoreo
                ->add('cantidadParaMayoreo')
                
                
                
                // - - - - - - - - - - - - - - - - - -cantidad minima en almacén
                ->add('cantidadMinima')
                
                
                // - - - - - - - - - - - - - - - - Cantidad actual en el almacén 
                ->add('cantidadActual')
                
                
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
