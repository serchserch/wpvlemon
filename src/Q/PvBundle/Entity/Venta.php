<?php

namespace Q\PvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Venta
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=14)
     */
    private $codigo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="total_sin_impuesto", type="decimal")
     */
    private $totalSinImpuesto;

    /**
     * @var float
     *
     * @ORM\Column(name="total_con_impuesto", type="decimal")
     */
    private $totalConImpuesto;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var float
     *
     * @ORM\Column(name="no_productos_vendidos", type="decimal")
     */
    private $noProductosVendidos;

    /**
     * @var float
     *
     * @ORM\Column(name="no_articulos_vendidos", type="decimal")
     */
    private $noArticulosVendidos;

    /**
     * @var string
     *
     * @ORM\Column(name="productos_vendidos", type="text")
     */
    private $productosVendidos;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="tienda_id", type="integer")
     */
    private $tienda_id;
    
    public function getTienda_id()
    {
        return $this->tienda_id;
    }

    public function setTienda_id($tienda_id)
    {
        $this->tienda_id = $tienda_id;
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
     * Set codigo
     *
     * @param string $codigo
     * @return Venta
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Venta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set totalSinImpuesto
     *
     * @param float $totalSinImpuesto
     * @return Venta
     */
    public function setTotalSinImpuesto($totalSinImpuesto)
    {
        $this->totalSinImpuesto = $totalSinImpuesto;

        return $this;
    }

    /**
     * Get totalSinImpuesto
     *
     * @return float 
     */
    public function getTotalSinImpuesto()
    {
        return $this->totalSinImpuesto;
    }

    /**
     * Set totalConImpuesto
     *
     * @param float $totalConImpuesto
     * @return Venta
     */
    public function setTotalConImpuesto($totalConImpuesto)
    {
        $this->totalConImpuesto = $totalConImpuesto;

        return $this;
    }

    /**
     * Get totalConImpuesto
     *
     * @return float 
     */
    public function getTotalConImpuesto()
    {
        return $this->totalConImpuesto;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Venta
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set noProductosVendidos
     *
     * @param float $noProductosVendidos
     * @return Venta
     */
    public function setNoProductosVendidos($noProductosVendidos)
    {
        $this->noProductosVendidos = $noProductosVendidos;

        return $this;
    }

    /**
     * Get noProductosVendidos
     *
     * @return float 
     */
    public function getNoProductosVendidos()
    {
        return $this->noProductosVendidos;
    }

    /**
     * Set noArticulosVendidos
     *
     * @param float $noArticulosVendidos
     * @return Venta
     */
    public function setNoArticulosVendidos($noArticulosVendidos)
    {
        $this->noArticulosVendidos = $noArticulosVendidos;

        return $this;
    }

    /**
     * Get noArticulosVendidos
     *
     * @return float 
     */
    public function getNoArticulosVendidos()
    {
        return $this->noArticulosVendidos;
    }

    /**
     * Set productosVendidos
     *
     * @param string $productosVendidos
     * @return Venta
     */
    public function setProductosVendidos($productosVendidos)
    {
        $this->productosVendidos = $productosVendidos;

        return $this;
    }

    /**
     * Get productosVendidos
     *
     * @return string 
     */
    public function getProductosVendidos()
    {
        return $this->productosVendidos;
    }
}
