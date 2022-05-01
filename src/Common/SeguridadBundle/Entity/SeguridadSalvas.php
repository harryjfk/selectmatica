<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguridadSalvas
 *
 * @ORM\Table(name="seguridad_salvas")
 * @ORM\Entity(repositoryClass="\Common\SeguridadBundle\Repository\SeguridadSalvasRepository")
 */
class SeguridadSalvas {

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
     * @ORM\Column(name="comentario", type="string", length=255)
     */
    private $comentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salva", type="datetime")
     */
    private $fechaSalva;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_fichero", type="string", length=255)
     */
    private $nombreFichero;

    /**
     * @var \Common\SeguridadBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="\Common\SeguridadBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idusuario", referencedColumnName="id")
     * })    
     */
    private $idusuario;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return SeguridadSalvas
     */
    public function setComentario($comentario) {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario() {
        return $this->comentario;
    }

    /**
     * Set fechaSalva
     *
     * @param \DateTime $fechaSalva
     *
     * @return SeguridadSalvas
     */
    public function setFechaSalva($fechaSalva) {
        $this->fechaSalva = $fechaSalva;

        return $this;
    }

    /**
     * Get fechaSalva
     *
     * @return \DateTime
     */
    public function getFechaSalva() {
        return $this->fechaSalva;
    }

    /**
     * Set nombreFichero
     *
     * @param string $nombreFichero
     *
     * @return SeguridadSalvas
     */
    public function setNombreFichero($nombreFichero) {
        $this->nombreFichero = $nombreFichero;

        return $this;
    }

    /**
     * Get nombreFichero
     *
     * @return string
     */
    public function getNombreFichero() {
        return $this->nombreFichero;
    }

   


    /**
     * Set idusuario
     *
     * @param \Common\SeguridadBundle\Entity\Usuario $idusuario
     *
     * @return SeguridadSalvas
     */
    public function setIdusuario(\Common\SeguridadBundle\Entity\Usuario $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Common\SeguridadBundle\Entity\Usuario
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}
