<?php

namespace Q\PvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productos
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Productos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fecha_creacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime")
     */
    private $fecha_modificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="agotado", type="boolean")
     */
    private $agotado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disponible", type="boolean")
     */
    private $disponible;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_de_barras", type="string", length=120)
     */
    private $codigo_de_barras;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_compra", type="decimal")
     */
    private $precio_compra;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_venta", type="decimal")
     */
    private $precio_venta;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_mayoreo", type="decimal")
     */
    private $precio_mayoreo;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_mayoreo", type="decimal")
     */
    private $cantidad_mayoreo;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_minima", type="decimal")
     */
    private $cantidad_minima;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_actual", type="decimal")
     */
    private $cantidad_actual;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_proveedor", type="string", length=20)
     */
    private $codigo_proveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=20)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_venta", type="string", length=20)
     */
    private $codigo_venta;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_compra", type="string", length=20)
     */
    private $codigo_compra;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="impuesto_id", type="integer")
     */
    private $impuesto_id;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="almacen_id", type="integer")
     */
    private $almacen_id;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=18)
     */
    private $imagen;
    
    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }    
    
    public function getAlmacenId()
    {
        return $this->almacen_id;
    }

    public function setAlmacenId($almacen_id)
    {
        $this->almacen_id = $almacen_id;
    }

        
    public function getImpuestoId()
    {
        return $this->impuesto_id;
    }

    public function setImpuestoId($impuesto_id)
    {
        $this->impuesto_id = $impuesto_id;
    }

    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_has_producto",
     *     joinColumns={@ORM\JoinColumn(name="producto_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $usuarios_productos;
    
    public function getUsuarios_productos()
    {
        return $this->usuarios_productos;
    }

    public function setUsuarios_productos($usuarios_productos)
    {
        $this->usuarios_productos[] = $usuarios_productos;
    }    
    
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha_creacion
     *
     * @param \DateTime $fechaCreacion
     * @return Productos
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fecha_creacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set fecha_modificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Productos
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fecha_modificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fecha_modificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Productos
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set agotado
     *
     * @param boolean $agotado
     * @return Productos
     */
    public function setAgotado($agotado)
    {
        $this->agotado = $agotado;

        return $this;
    }

    /**
     * Get agotado
     *
     * @return boolean 
     */
    public function getAgotado()
    {
        return $this->agotado;
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     * @return Productos
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean 
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set codigo_de_barras
     *
     * @param string $codigoDeBarras
     * @return Productos
     */
    public function setCodigoDeBarras($codigoDeBarras)
    {
        $this->codigo_de_barras = $codigoDeBarras;

        return $this;
    }

    /**
     * Get codigo_de_barras
     *
     * @return string 
     */
    public function getCodigoDeBarras()
    {
        return $this->codigo_de_barras;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Productos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Productos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set precio_compra
     *
     * @param float $precioCompra
     * @return Productos
     */
    public function setPrecioCompra($precioCompra)
    {
        $this->precio_compra = $precioCompra;

        return $this;
    }

    /**
     * Get precio_compra
     *
     * @return float 
     */
    public function getPrecioCompra()
    {
        return $this->precio_compra;
    }

    /**
     * Set precio_venta
     *
     * @param float $precioVenta
     * @return Productos
     */
    public function setPrecioVenta($precioVenta)
    {
        $this->precio_venta = $precioVenta;

        return $this;
    }

    /**
     * Get precio_venta
     *
     * @return float 
     */
    public function getPrecioVenta()
    {
        return $this->precio_venta;
    }

    /**
     * Set precio_mayoreo
     *
     * @param float $precioMayoreo
     * @return Productos
     */
    public function setPrecioMayoreo($precioMayoreo)
    {
        $this->precio_mayoreo = $precioMayoreo;

        return $this;
    }

    /**
     * Get precio_mayoreo
     *
     * @return float 
     */
    public function getPrecioMayoreo()
    {
        return $this->precio_mayoreo;
    }

    /**
     * Set cantidad_mayoreo
     *
     * @param float $cantidadMayoreo
     * @return Productos
     */
    public function setCantidadMayoreo($cantidadMayoreo)
    {
        $this->cantidad_mayoreo = $cantidadMayoreo;

        return $this;
    }

    /**
     * Get cantidad_mayoreo
     *
     * @return float 
     */
    public function getCantidadMayoreo()
    {
        return $this->cantidad_mayoreo;
    }

    /**
     * Set cantidad_minima
     *
     * @param float $cantidadMinima
     * @return Productos
     */
    public function setCantidadMinima($cantidadMinima)
    {
        $this->cantidad_minima = $cantidadMinima;

        return $this;
    }

    /**
     * Get cantidad_minima
     *
     * @return float 
     */
    public function getCantidadMinima()
    {
        return $this->cantidad_minima;
    }

    /**
     * Set cantidad_actual
     *
     * @param float $cantidadActual
     * @return Productos
     */
    public function setCantidadActual($cantidadActual)
    {
        $this->cantidad_actual = $cantidadActual;

        return $this;
    }

    /**
     * Get cantidad_actual
     *
     * @return float 
     */
    public function getCantidadActual()
    {
        return $this->cantidad_actual;
    }

    /**
     * Set codigo_proveedor
     *
     * @param string $codigoProveedor
     * @return Productos
     */
    public function setCodigoProveedor($codigoProveedor)
    {
        $this->codigo_proveedor = $codigoProveedor;

        return $this;
    }

    /**
     * Get codigo_proveedor
     *
     * @return string 
     */
    public function getCodigoProveedor()
    {
        return $this->codigo_proveedor;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Productos
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set codigo_venta
     *
     * @param string $codigoVenta
     * @return Productos
     */
    public function setCodigoVenta($codigoVenta)
    {
        $this->codigo_venta = $codigoVenta;

        return $this;
    }

    /**
     * Get codigo_venta
     *
     * @return string 
     */
    public function getCodigoVenta()
    {
        return $this->codigo_venta;
    }

    /**
     * Set codigo_compra
     *
     * @param string $codigoCompra
     * @return Productos
     */
    public function setCodigoCompra($codigoCompra)
    {
        $this->codigo_compra = $codigoCompra;

        return $this;
    }

    /**
     * Get codigo_compra
     *
     * @return string 
     */
    public function getCodigoCompra()
    {
        return $this->codigo_compra;
    }
}
