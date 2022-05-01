<?php

namespace Store\RestBundle\Entity;

/**
 * Familias
 */
class Familias
{
    /**
     * @var integer
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
     * @param integer $id
     *
     * @return Familias
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Add articulo
     *
     * @param \Store\RestBundle\Entity\Articulos $articulo
     *
     * @return Familias
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
     * @var string
     */
    private $sctaCompras;

    /**
     * @var string
     */
    private $sctaVentas;

    /**
     * @var string
     */
    private $sctaAbonoCompras;

    /**
     * @var string
     */
    private $sctaAbonoVentas;

    /**
     * @var float
     */
    private $porcTarifa1;

    /**
     * @var float
     */
    private $porcTarifa2;

    /**
     * @var float
     */
    private $porcTarifa3;

    /**
     * @var float
     */
    private $porcTarifa4;

    /**
     * @var float
     */
    private $porcTarifa5;

    /**
     * @var boolean
     */
    private $venta;

    /**
     * @var boolean
     */
    private $validaVentas;

    /**
     * @var boolean
     */
    private $validaCompras;

    /**
     * @var boolean
     */
    private $noUsarEnNecesidadesCompra;

    /**
     * @var boolean
     */
    private $noPermitirPedidoSinPrecioEspecial;

    /**
     * @var string
     */
    private $zonaComanda;

    /**
     * @var string
     */
    private $seriePrevento;

    /**
     * @var boolean
     */
    private $pasarADispositivo;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Familias
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
     * Set sctaCompras
     *
     * @param string $sctaCompras
     *
     * @return Familias
     */
    public function setSctaCompras($sctaCompras)
    {
        $this->sctaCompras = $sctaCompras;

        return $this;
    }

    /**
     * Get sctaCompras
     *
     * @return string
     */
    public function getSctaCompras()
    {
        return $this->sctaCompras;
    }

    /**
     * Set sctaVentas
     *
     * @param string $sctaVentas
     *
     * @return Familias
     */
    public function setSctaVentas($sctaVentas)
    {
        $this->sctaVentas = $sctaVentas;

        return $this;
    }

    /**
     * Get sctaVentas
     *
     * @return string
     */
    public function getSctaVentas()
    {
        return $this->sctaVentas;
    }

    /**
     * Set sctaAbonoCompras
     *
     * @param string $sctaAbonoCompras
     *
     * @return Familias
     */
    public function setSctaAbonoCompras($sctaAbonoCompras)
    {
        $this->sctaAbonoCompras = $sctaAbonoCompras;

        return $this;
    }

    /**
     * Get sctaAbonoCompras
     *
     * @return string
     */
    public function getSctaAbonoCompras()
    {
        return $this->sctaAbonoCompras;
    }

    /**
     * Set sctaAbonoVentas
     *
     * @param string $sctaAbonoVentas
     *
     * @return Familias
     */
    public function setSctaAbonoVentas($sctaAbonoVentas)
    {
        $this->sctaAbonoVentas = $sctaAbonoVentas;

        return $this;
    }

    /**
     * Get sctaAbonoVentas
     *
     * @return string
     */
    public function getSctaAbonoVentas()
    {
        return $this->sctaAbonoVentas;
    }

    /**
     * Set porcTarifa1
     *
     * @param float $porcTarifa1
     *
     * @return Familias
     */
    public function setPorcTarifa1($porcTarifa1)
    {
        $this->porcTarifa1 = $porcTarifa1;

        return $this;
    }

    /**
     * Get porcTarifa1
     *
     * @return float
     */
    public function getPorcTarifa1()
    {
        return $this->porcTarifa1;
    }

    /**
     * Set porcTarifa2
     *
     * @param float $porcTarifa2
     *
     * @return Familias
     */
    public function setPorcTarifa2($porcTarifa2)
    {
        $this->porcTarifa2 = $porcTarifa2;

        return $this;
    }

    /**
     * Get porcTarifa2
     *
     * @return float
     */
    public function getPorcTarifa2()
    {
        return $this->porcTarifa2;
    }

    /**
     * Set porcTarifa3
     *
     * @param float $porcTarifa3
     *
     * @return Familias
     */
    public function setPorcTarifa3($porcTarifa3)
    {
        $this->porcTarifa3 = $porcTarifa3;

        return $this;
    }

    /**
     * Get porcTarifa3
     *
     * @return float
     */
    public function getPorcTarifa3()
    {
        return $this->porcTarifa3;
    }

    /**
     * Set porcTarifa4
     *
     * @param float $porcTarifa4
     *
     * @return Familias
     */
    public function setPorcTarifa4($porcTarifa4)
    {
        $this->porcTarifa4 = $porcTarifa4;

        return $this;
    }

    /**
     * Get porcTarifa4
     *
     * @return float
     */
    public function getPorcTarifa4()
    {
        return $this->porcTarifa4;
    }

    /**
     * Set porcTarifa5
     *
     * @param float $porcTarifa5
     *
     * @return Familias
     */
    public function setPorcTarifa5($porcTarifa5)
    {
        $this->porcTarifa5 = $porcTarifa5;

        return $this;
    }

    /**
     * Get porcTarifa5
     *
     * @return float
     */
    public function getPorcTarifa5()
    {
        return $this->porcTarifa5;
    }

    /**
     * Set venta
     *
     * @param boolean $venta
     *
     * @return Familias
     */
    public function setVenta($venta)
    {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return boolean
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * Set validaVentas
     *
     * @param boolean $validaVentas
     *
     * @return Familias
     */
    public function setValidaVentas($validaVentas)
    {
        $this->validaVentas = $validaVentas;

        return $this;
    }

    /**
     * Get validaVentas
     *
     * @return boolean
     */
    public function getValidaVentas()
    {
        return $this->validaVentas;
    }

    /**
     * Set validaCompras
     *
     * @param boolean $validaCompras
     *
     * @return Familias
     */
    public function setValidaCompras($validaCompras)
    {
        $this->validaCompras = $validaCompras;

        return $this;
    }

    /**
     * Get validaCompras
     *
     * @return boolean
     */
    public function getValidaCompras()
    {
        return $this->validaCompras;
    }

    /**
     * Set noUsarEnNecesidadesCompra
     *
     * @param boolean $noUsarEnNecesidadesCompra
     *
     * @return Familias
     */
    public function setNoUsarEnNecesidadesCompra($noUsarEnNecesidadesCompra)
    {
        $this->noUsarEnNecesidadesCompra = $noUsarEnNecesidadesCompra;

        return $this;
    }

    /**
     * Get noUsarEnNecesidadesCompra
     *
     * @return boolean
     */
    public function getNoUsarEnNecesidadesCompra()
    {
        return $this->noUsarEnNecesidadesCompra;
    }

    /**
     * Set noPermitirPedidoSinPrecioEspecial
     *
     * @param boolean $noPermitirPedidoSinPrecioEspecial
     *
     * @return Familias
     */
    public function setNoPermitirPedidoSinPrecioEspecial($noPermitirPedidoSinPrecioEspecial)
    {
        $this->noPermitirPedidoSinPrecioEspecial = $noPermitirPedidoSinPrecioEspecial;

        return $this;
    }

    /**
     * Get noPermitirPedidoSinPrecioEspecial
     *
     * @return boolean
     */
    public function getNoPermitirPedidoSinPrecioEspecial()
    {
        return $this->noPermitirPedidoSinPrecioEspecial;
    }

    /**
     * Set zonaComanda
     *
     * @param string $zonaComanda
     *
     * @return Familias
     */
    public function setZonaComanda($zonaComanda)
    {
        $this->zonaComanda = $zonaComanda;

        return $this;
    }

    /**
     * Get zonaComanda
     *
     * @return string
     */
    public function getZonaComanda()
    {
        return $this->zonaComanda;
    }

    /**
     * Set seriePrevento
     *
     * @param string $seriePrevento
     *
     * @return Familias
     */
    public function setSeriePrevento($seriePrevento)
    {
        $this->seriePrevento = $seriePrevento;

        return $this;
    }

    /**
     * Get seriePrevento
     *
     * @return string
     */
    public function getSeriePrevento()
    {
        return $this->seriePrevento;
    }

    /**
     * Set pasarADispositivo
     *
     * @param boolean $pasarADispositivo
     *
     * @return Familias
     */
    public function setPasarADispositivo($pasarADispositivo)
    {
        $this->pasarADispositivo = $pasarADispositivo;

        return $this;
    }

    /**
     * Get pasarADispositivo
     *
     * @return boolean
     */
    public function getPasarADispositivo()
    {
        return $this->pasarADispositivo;
    }
}
