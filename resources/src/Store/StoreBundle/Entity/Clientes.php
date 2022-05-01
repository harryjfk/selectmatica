<?php

namespace Store\StoreBundle\Entity;

/**
 * Clientes
 */
class Clientes
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Facturas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Facturas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add factura
     *
     * @param \Store\StoreBundle\Entity\Facturas $factura
     *
     * @return Clientes
     */
    public function addFactura(\Store\StoreBundle\Entity\Facturas $factura)
    {
        $this->Facturas[] = $factura;

        return $this;
    }

    /**
     * Remove factura
     *
     * @param \Store\StoreBundle\Entity\Facturas $factura
     */
    public function removeFactura(\Store\StoreBundle\Entity\Facturas $factura)
    {
        $this->Facturas->removeElement($factura);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->Facturas;
    }
}
