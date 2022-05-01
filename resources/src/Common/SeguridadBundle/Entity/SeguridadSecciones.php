<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguridadSecciones
 *
 * @ORM\Table(name="seguridad_secciones")
 * @ORM\Entity(repositoryClass="Common\SeguridadBundle\Repository\SeguridadSeccionesRepository")
 */
class SeguridadSecciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;



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
     *
     * @return SeguridadSecciones
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
    
    public function __toString() {
        return $this->nombre;
    }
}
