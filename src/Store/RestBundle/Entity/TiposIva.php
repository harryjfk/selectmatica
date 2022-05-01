<?php

namespace Store\RestBundle\Entity;

/**
 * TiposIva
 */
class TiposIva
{
    /**
     * @var string
     */
    private $id;

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
     * @return TiposIva
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
     * Add articulo
     *
     * @param \Store\RestBundle\Entity\Articulos $articulo
     *
     * @return TiposIva
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
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var float
     */
    private $porcentajeIVA;

    /**
     * @var float
     */
    private $porcentajeRE;

    /**
     * @var boolean
     */
    private $aplicaRetencion;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TiposIva
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
     * Set porcentajeIVA
     *
     * @param float $porcentajeIVA
     *
     * @return TiposIva
     */
    public function setPorcentajeIVA($porcentajeIVA)
    {
        $this->porcentajeIVA = $porcentajeIVA;

        return $this;
    }

    /**
     * Get porcentajeIVA
     *
     * @return float
     */
    public function getPorcentajeIVA()
    {
        return $this->porcentajeIVA;
    }

    /**
     * Set porcentajeRE
     *
     * @param float $porcentajeRE
     *
     * @return TiposIva
     */
    public function setPorcentajeRE($porcentajeRE)
    {
        $this->porcentajeRE = $porcentajeRE;

        return $this;
    }

    /**
     * Get porcentajeRE
     *
     * @return float
     */
    public function getPorcentajeRE()
    {
        return $this->porcentajeRE;
    }

    /**
     * Set aplicaRetencion
     *
     * @param boolean $aplicaRetencion
     *
     * @return TiposIva
     */
    public function setAplicaRetencion($aplicaRetencion)
    {
        $this->aplicaRetencion = $aplicaRetencion;

        return $this;
    }

    /**
     * Get aplicaRetencion
     *
     * @return boolean
     */
    public function getAplicaRetencion()
    {
        return $this->aplicaRetencion;
    }
}
