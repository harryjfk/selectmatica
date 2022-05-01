<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguridadTraza
 *
 * @ORM\Table(name="seguridad_traza")
 * @ORM\Entity(repositoryClass="Common\SeguridadBundle\Repository\SeguridadTrazaRepository")
 */
class SeguridadTraza {

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
     * @ORM\Column(name="usuario", type="string", length=255)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="accion", type="string", length=255)
     */
    private $accion;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=100)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="tabla", type="string", length=255)
     */
    private $tabla;

    /**
     * @var string
     *
     * @ORM\Column(name="idregistro", type="string", length=100)
     */
    private $idregistro;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="metadatos", type="text")
     */
    private $metadatos;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set accion
     *
     * @param string $accion
     *
     * @return SeguridadTraza
     */
    public function setAccion($accion) {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return string
     */
    public function getAccion() {
        return $this->accion;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return SeguridadTraza
     */
    public function setIp($ip) {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * Set tabla
     *
     * @param string $tabla
     *
     * @return SeguridadTraza
     */
    public function setTabla($tabla) {
        $this->tabla = $tabla;

        return $this;
    }

    /**
     * Get tabla
     *
     * @return string
     */
    public function getTabla() {
        return $this->tabla;
    }

    /**
     * Set idregistro
     *
     * @param string $idregistro
     *
     * @return SeguridadTraza
     */
    public function setIdregistro($idregistro) {
        $this->idregistro = $idregistro;

        return $this;
    }

    /**
     * Get idregistro
     *
     * @return string
     */
    public function getIdregistro() {
        return $this->idregistro;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return SeguridadTraza
     */
    public function setObservacion($observacion) {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion() {
        return $this->observacion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SeguridadTraza
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set metadatos
     *
     * @param string $metadatos
     *
     * @return SeguridadTraza
     */
    public function setMetadatos($metadatos) {
        $this->metadatos = $metadatos;

        return $this;
    }

    /**
     * Get metadatos
     *
     * @return string
     */
    public function getMetadatos() {
        return $this->metadatos;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return SeguridadTraza
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario() {
        return $this->usuario;
    }

}
