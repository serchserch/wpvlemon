<?php

namespace Q\PvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Producto {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime")
     */
    private $fechaModificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_de_barras", type="string", length=120)
     */
    private $codigoDeBarras;
    private
            $almacen,
            $impuesto,
            $precioCompra,
            $precioVenta,
            $precioMayoreo,
            $cantidadParaMayoreo,
            $cantidadMinima,
            $cantidadActual,
            $agotado,
            $disponible,
            $codigoProveedor,
            $sku,
            $codigoDeVenta,
            $codigoDeCompra;

    public function getCodigoProveedor() {
        return $this->codigoProveedor;
    }

    public function setCodigoProveedor($codigoProveedor) {
        $this->codigoProveedor = $codigoProveedor;
    }

        
    public function getAlmacen() {
        return $this->almacen;
    }

    public function setAlmacen($almacen) {
        $this->almacen = $almacen;
    }

    public function getImpuesto() {
        return $this->impuesto;
    }

    public function setImpuesto($impuesto) {
        $this->impuesto = $impuesto;
    }

    public function getPrecioCompra() {
        return $this->precioCompra;
    }

    public function setPrecioCompra($precioCompra) {
        $this->precioCompra = $precioCompra;
    }

    public function getPrecioVenta() {
        return $this->precioVenta;
    }

    public function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    public function getPrecioMayoreo() {
        return $this->precioMayoreo;
    }

    public function setPrecioMayoreo($precioMayoreo) {
        $this->precioMayoreo = $precioMayoreo;
    }

    public function getCantidadParaMayoreo() {
        return $this->cantidadParaMayoreo;
    }

    public function setCantidadParaMayoreo($cantidadParaMayoreo) {
        $this->cantidadParaMayoreo = $cantidadParaMayoreo;
    }

    public function getCantidadMinima() {
        return $this->cantidadMinima;
    }

    public function setCantidadMinima($cantidadMinima) {
        $this->cantidadMinima = $cantidadMinima;
    }

    public function getCantidadActual() {
        return $this->cantidadActual;
    }

    public function setCantidadActual($cantidadActual) {
        $this->cantidadActual = $cantidadActual;
    }

    public function getAgotado() {
        return $this->agotado;
    }

    public function setAgotado($agotado) {
        $this->agotado = $agotado;
    }


    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getCodigoDeVenta() {
        return $this->codigoDeVenta;
    }

    public function setCodigoDeVenta($codigoDeVenta) {
        $this->codigoDeVenta = $codigoDeVenta;
    }

    public function getCodigoDeCompra() {
        return $this->codigoDeCompra;
    }

    public function setCodigoDeCompra($codigoDeCompra) {
        $this->codigoDeCompra = $codigoDeCompra;
    }

        
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Producto
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Producto
     */
    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Producto
     */
    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Producto
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo() {
        return $this->activo;
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     * @return Producto
     */
    public function setDisponible($disponible) {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean 
     */
    public function getDisponible() {
        return $this->disponible;
    }

    /**
     * Set codigoDeBarras
     *
     * @param string $codigoDeBarras
     * @return Producto
     */
    public function setCodigoDeBarras($codigoDeBarras) {
        $this->codigoDeBarras = $codigoDeBarras;

        return $this;
    }

    /**
     * Get codigoDeBarras
     *
     * @return string 
     */
    public function getCodigoDeBarras() {
        return $this->codigoDeBarras;
    }

}
