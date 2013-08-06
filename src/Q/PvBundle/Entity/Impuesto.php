<?php

namespace Q\PvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Impuesto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Impuesto
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
     * @var integer
     *
     * @ORM\Column(name="porcentaje", type="integer")
     */
    private $porcentaje;

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
     * @ORM\Column(name="activo", type="boolean")
     */
    protected $Activo;


    /**
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_has_impuesto",
     *     joinColumns={@ORM\JoinColumn(name="impuesto_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $usuarios_impuesto;
    
    public function getUsuarios_impuesto()
    {
        return $this->usuarios_impuesto;
    }

    public function setUsuarios_impuesto($usuarios_impuesto)
    {
        $this->usuarios_impuesto[] = $usuarios_impuesto;
    }

    public function getActivo()
    {
        return $this->Activo;
    }

    public function setActivo($Activo)
    {
        $this->Activo = $Activo;
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
     * @return Impuesto
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
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Impuesto
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;
    
        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Impuesto
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
     * @return Impuesto
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
}
