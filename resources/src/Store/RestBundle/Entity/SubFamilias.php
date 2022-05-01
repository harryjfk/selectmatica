<?php

namespace Store\RestBundle\Entity;

/**
 * SubFamilias
 */
class SubFamilias
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Articulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return SubFamilias
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return SubFamilias
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
     * Add articulo
     *
     * @param \Store\RestBundle\Entity\Articulos $articulo
     *
     * @return SubFamilias
     */
    public function addArticulo(\Store\RestBundle\Entity\Articulos $articulo)
    {
        $this->Articulos[] = $articulo;

        return $this;
    }

    /**
     * Remove articulo
     *
     * @param \Store\RestBundle\Entity\Articulos $articulo
     */
    public function removeArticulo(\Store\RestBundle\Entity\Articulos $articulo)
    {
        $this->Articulos->removeElement($articulo);
    }

    /**
     * Get articulos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticulos()
    {
        return $this->Articulos;
    }
}
