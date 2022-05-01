<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SeguridadGrupo
 *
 * @ORM\Table(name="seguridad_grupo")
 * @ORM\Entity(repositoryClass="\Common\SeguridadBundle\Repository\SeguridadGrupoRepository")
 */
class SeguridadGrupo {

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
     * @ORM\Column(name="nombre_grupo", type="string", length=255, nullable=true)
     */
    private $nombreGrupo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SeguridadSeccionesRoles", inversedBy="grupoid")
     * @ORM\JoinTable(name="seguridad_grupo_rol",
     *   joinColumns={
     *     @ORM\JoinColumn(name="grupoid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="rol", referencedColumnName="rol")
     *   }
     * )
     */
    private $rol;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="grupoid")
     */
    private $usuarioid;

    /**
     * @var boolean
     *
     * @ORM\Column(name="essistema", type="boolean", nullable=true)
     */
    private $essistema;

    /**
     * Constructor
     */
    public function __construct() {
        $this->rol = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarioid = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     *
     * @return SeguridadGrupo
     */
    public function setNombreGrupo($nombreGrupo) {
        $this->nombreGrupo = $nombreGrupo;

        return $this;
    }

    /**
     * Get nombreGrupo
     *
     * @return string
     */
    public function getNombreGrupo() {
        return $this->nombreGrupo;
    }

    /* public function setRol($rol)
      {
      $this->rol[] = $rol;

      return $this;
      } */

    /**
     * Add rol
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadSeccionesRoles $rol
     *
     * @return SeguridadGrupo
     */
    public function addRol(\Common\SeguridadBundle\Entity\SeguridadSeccionesRoles $rol) {
        $this->rol[] = $rol;

        return $this;
    }

    /**
     * Remove rol
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadSeccionesRoles $rol
     */
    public function removeRol(\Common\SeguridadBundle\Entity\SeguridadSeccionesRoles $rol) {
        $this->rol->removeElement($rol);
    }

    /**
     * Get rol
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Add usuarioid
     *
     * @param \Common\SeguridadBundle\Entity\Usuario $usuarioid
     *
     * @return SeguridadGrupo
     */
    public function addUsuarioid(\Common\SeguridadBundle\Entity\Usuario $usuarioid) {
        $this->usuarioid[] = $usuarioid;

        return $this;
    }

    /**
     * Remove usuarioid
     *
     * @param \Common\SeguridadBundle\Entity\Usuario $usuarioid
     */
    public function removeUsuarioid(\Common\SeguridadBundle\Entity\Usuario $usuarioid) {
        $this->usuarioid->removeElement($usuarioid);
    }

    /**
     * Get usuarioid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioid() {
        return $this->usuarioid;
    }

    public function __toString() {
        return $this->nombreGrupo;
    }


    /**
     * Set essistema
     *
     * @param boolean $essistema
     *
     * @return SeguridadGrupo
     */
    public function setEssistema($essistema)
    {
        $this->essistema = $essistema;

        return $this;
    }

    /**
     * Get essistema
     *
     * @return boolean
     */
    public function getEssistema()
    {
        return $this->essistema;
    }
}
