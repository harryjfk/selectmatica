<?php

namespace Store\RestBundle\Entity;

/**
 * Historico
 */
class Historico
{
    /**
     * @var integer
     */
    private $idCliente;

    /**
     * @var integer
     */
    private $idArticulo;


    /**
     * Set idCliente
     *
     * @param integer $idCliente
     *
     * @return Historico
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * Get idCliente
     *
     * @return integer
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set idArticulo
     *
     * @param integer $idArticulo
     *
     * @return Historico
     */
    public function setIdArticulo($idArticulo)
    {
        $this->idArticulo = $idArticulo;

        return $this;
    }

    /**
     * Get idArticulo
     *
     * @return integer
     */
    public function getIdArticulo()
    {
        return $this->idArticulo;
    }
}
