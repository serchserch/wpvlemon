<?php

namespace Q\PvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tienda
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tienda
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
     * @var string
     *
     * @ORM\Column(name="telefono1", type="string", length=15)
     */
    private $telefono1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono2", type="string", length=15)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45)
     */
    private $email;

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
     * @var \Boolean
     *
     * @ORM\Column(name="activa", type="boolean")
     */
    private $activa;

    
    /**
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_has_tienda",
     *     joinColumns={@ORM\JoinColumn(name="tienda_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $usuarios_tienda;


    public function getUsuarios_tienda()
    {
        return $this->usuarios_tienda;
    }

    public function setUsuarios_tienda($usuarios_tienda)
    {
        $this->usuarios_tienda[] = $usuarios_tienda;
    }
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Almacen")
     * @ORM\JoinTable(name="tienda_has_almacen",
     *     joinColumns={@ORM\JoinColumn(name="tienda_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="almacen_id", referencedColumnName="id")}
     * )
     */
    protected $tienda_almacen;
    
    public function getTienda_almacen()
    {
        return $this->tienda_almacen;
    }

    public function setTienda_almacen($tienda_almacen)
    {
        $this->tienda_almacen[] = $tienda_almacen;
    }

    public function __toString() {
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Tienda
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
     * @return Tienda
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
     * Set telefono1
     *
     * @param string $telefono1
     * @return Tienda
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;
    
        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string 
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     * @return Tienda
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;
    
        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string 
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Tienda
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Tienda
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    
        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Tienda
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
    
        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }
    
    public function getActiva()
    {
        return $this->activa;
    }

    public function setActiva($activa)
    {
        $this->activa = $activa;
    }


}
