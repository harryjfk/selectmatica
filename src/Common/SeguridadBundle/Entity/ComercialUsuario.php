<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComercialUsuario
 *
 * @ORM\Table(name="comercial_usuario")
 * @ORM\Entity(repositoryClass="\Common\SeguridadBundle\Repository\ComercialUsuarioRepository")
 */
class ComercialUsuario {

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
     * @ORM\Column(name="idcomercial", type="string", length=255, nullable=true)
     */
    private $idcomercial;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="idcomercial")
     */
    private $idcliente;



    /**
     * Constructor
     */
    public function __construct() {
         $this->$idcliente = new \Doctrine\Common\Collections\ArrayCollection();
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
