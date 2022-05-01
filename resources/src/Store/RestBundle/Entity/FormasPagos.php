<?php

namespace Store\RestBundle\Entity;

/**
 * FormasPagos
 */
class FormasPagos
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $prontoPago;

    /**
     * @var float
     */
    private $numeroVencimientos;

    /**
     * @var boolean
     */
    private $cobroDirecto;

    /**
     * @var boolean
     */
    private $negociable;

    /**
     * @var float
     */
    private $porcentajeRecargoFinanciero;

    /**
     * @var float
     */
    private $clasificacionRiesgo;

    /**
     * @var boolean
     */
    private $negativos;

    /**
     * @var string
     */
    private $medioPago;

    /**
     * @var boolean
     */
    private $reembolso;

    /**
     * @var boolean
     */
    private $autorizacionAutomaticaPedidos;

    /**
     * @var string
     */
    private $lineas;

    /**
     * @var string
     */
    private $id;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return FormasPagos
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
     * Set prontoPago
     *
     * @param string $prontoPago
     *
     * @return FormasPagos
     */
    public function setProntoPago($prontoPago)
    {
        $this->prontoPago = $prontoPago;

        return $this;
    }

    /**
     * Get prontoPago
     *
     * @return string
     */
    public function getProntoPago()
    {
        return $this->prontoPago;
    }

    /**
     * Set numeroVencimientos
     *
     * @param float $numeroVencimientos
     *
     * @return FormasPagos
     */
    public function setNumeroVencimientos($numeroVencimientos)
    {
        $this->numeroVencimientos = $numeroVencimientos;

        return $this;
    }

    /**
     * Get numeroVencimientos
     *
     * @return float
     */
    public function getNumeroVencimientos()
    {
        return $this->numeroVencimientos;
    }

    /**
     * Set cobroDirecto
     *
     * @param boolean $cobroDirecto
     *
     * @return FormasPagos
     */
    public function setCobroDirecto($cobroDirecto)
    {
        $this->cobroDirecto = $cobroDirecto;

        return $this;
    }

    /**
     * Get cobroDirecto
     *
     * @return boolean
     */
    public function getCobroDirecto()
    {
        return $this->cobroDirecto;
    }

    /**
     * Set negociable
     *
     * @param boolean $negociable
     *
     * @return FormasPagos
     */
    public function setNegociable($negociable)
    {
        $this->negociable = $negociable;

        return $this;
    }

    /**
     * Get negociable
     *
     * @return boolean
     */
    public function getNegociable()
    {
        return $this->negociable;
    }

    /**
     * Set porcentajeRecargoFinanciero
     *
     * @param float $porcentajeRecargoFinanciero
     *
     * @return FormasPagos
     */
    public function setPorcentajeRecargoFinanciero($porcentajeRecargoFinanciero)
    {
        $this->porcentajeRecargoFinanciero = $porcentajeRecargoFinanciero;

        return $this;
    }

    /**
     * Get porcentajeRecargoFinanciero
     *
     * @return float
     */
    public function getPorcentajeRecargoFinanciero()
    {
        return $this->porcentajeRecargoFinanciero;
    }

    /**
     * Set clasificacionRiesgo
     *
     * @param float $clasificacionRiesgo
     *
     * @return FormasPagos
     */
    public function setClasificacionRiesgo($clasificacionRiesgo)
    {
        $this->clasificacionRiesgo = $clasificacionRiesgo;

        return $this;
    }

    /**
     * Get clasificacionRiesgo
     *
     * @return float
     */
    public function getClasificacionRiesgo()
    {
        return $this->clasificacionRiesgo;
    }

    /**
     * Set negativos
     *
     * @param boolean $negativos
     *
     * @return FormasPagos
     */
    public function setNegativos($negativos)
    {
        $this->negativos = $negativos;

        return $this;
    }

    /**
     * Get negativos
     *
     * @return boolean
     */
    public function getNegativos()
    {
        return $this->negativos;
    }

    /**
     * Set medioPago
     *
     * @param string $medioPago
     *
     * @return FormasPagos
     */
    public function setMedioPago($medioPago)
    {
        $this->medioPago = $medioPago;

        return $this;
    }

    /**
     * Get medioPago
     *
     * @return string
     */
    public function getMedioPago()
    {
        return $this->medioPago;
    }

    /**
     * Set reembolso
     *
     * @param boolean $reembolso
     *
     * @return FormasPagos
     */
    public function setReembolso($reembolso)
    {
        $this->reembolso = $reembolso;

        return $this;
    }

    /**
     * Get reembolso
     *
     * @return boolean
     */
    public function getReembolso()
    {
        return $this->reembolso;
    }

    /**
     * Set autorizacionAutomaticaPedidos
     *
     * @param boolean $autorizacionAutomaticaPedidos
     *
     * @return FormasPagos
     */
    public function setAutorizacionAutomaticaPedidos($autorizacionAutomaticaPedidos)
    {
        $this->autorizacionAutomaticaPedidos = $autorizacionAutomaticaPedidos;

        return $this;
    }

    /**
     * Get autorizacionAutomaticaPedidos
     *
     * @return boolean
     */
    public function getAutorizacionAutomaticaPedidos()
    {
        return $this->autorizacionAutomaticaPedidos;
    }

    /**
     * Set lineas
     *
     * @param string $lineas
     *
     * @return FormasPagos
     */
    public function setLineas($lineas)
    {
        $this->lineas = $lineas;

        return $this;
    }

    /**
     * Get lineas
     *
     * @return string
     */
    public function getLineas()
    {
        return $this->lineas;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return FormasPagos
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
}

