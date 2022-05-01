<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguridadSeccionesRoles
 *
 * @ORM\Table(name="seguridad_secciones_roles", indexes={@ORM\Index(name="seccionid", columns={"seccionid"})})
 * @ORM\Entity(repositoryClass="Common\SeguridadBundle\Repository\SeguridadSeccionesRolesRepository")
 */
class SeguridadSeccionesRoles {

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rol;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var \SeguridadSecciones
     *
     * @ORM\ManyToOne(targetEntity="SeguridadSecciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seccionid", referencedColumnName="id")
     * })
     */
    private $seccionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SeguridadGrupo", mappedBy="rol")
     */
    private $grupoid;

    /**
     * Constructor
     */
    public function __construct() {
        $this->grupoid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return SeguridadSeccionesRoles
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
     * Set seccionid
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadSecciones $seccionid
     *
     * @return SeguridadSeccionesRoles
     */
    public function setSeccionid(\Common\SeguridadBundle\Entity\SeguridadSecciones $seccionid = null) {
        $this->seccionid = $seccionid;

        return $this;
    }

    /**
     * Get seccionid
     *
     * @return \Common\SeguridadBundle\Entity\SeguridadSecciones
     */
    public function getSeccionid() {
        return $this->seccionid;
    }

    /**
     * Add grupoid
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid
     *
     * @return SeguridadSeccionesRoles
     */
    public function addGrupoid(\Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid) {
        $this->grupoid[] = $grupoid;

        return $this;
    }

    /**
     * Remove grupoid
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid
     */
    public function removeGrupoid(\Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid) {
        $this->grupoid->removeElement($grupoid);
    }

    /**
     * Get grupoid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupoid() {
        return $this->grupoid;
    }

    public function __toString() {
        return $this->nombre;
    }

}
