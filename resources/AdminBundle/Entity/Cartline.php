<?php

namespace Store\AdminBundle\Entity;

/**
 * Cartline
 */
class Cartline
{
    /**
     * @var integer
     */
    private $cantidad;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Store\AdminBundle\Entity\Producto
     */
    private $idproducto;

    /**
     * @var \Store\AdminBundle\Entity\Cart
     */
    private $idcart;


    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return Cartline
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
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
     * Set idproducto
     *
     * @param \Store\AdminBundle\Entity\Producto $idproducto
     *
     * @return Cartline
     */
    public function setIdproducto(\Store\AdminBundle\Entity\Producto $idproducto = null)
    {
        $this->idproducto = $idproducto;

        return $this;
    }

    /**
     * Get idproducto
     *
     * @return \Store\AdminBundle\Entity\Producto
     */
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * Set idcart
     *
     * @param \Store\AdminBundle\Entity\Cart $idcart
     *
     * @return Cartline
     */
    public function setIdcart(\Store\AdminBundle\Entity\Cart $idcart = null)
    {
        $this->idcart = $idcart;

        return $this;
    }

    /**
     * Get idcart
     *
     * @return \Store\AdminBundle\Entity\Cart
     */
    public function getIdcart()
    {
        return $this->idcart;
    }
}

