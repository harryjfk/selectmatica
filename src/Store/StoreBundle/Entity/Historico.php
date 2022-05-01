<?php

namespace Store\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("historico")
 */
class Historico {

    /**
     * @ORM\Column(type="integer")
     */
    private $agente;
	 /**
     * @ORM\Column(type="integer")
     */
    private $cliente;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $articulo;

    public function getAgente() {
        return $this->agente;
    }

	 public function setAgente($agente) {
         $this->agente = $agente;
        return $this;
    }
	 public function getCliente() {
        return $this->cliente;
    }

	 public function setCliente($cliente) {
         $this->cliente = $cliente;
        return $this;
    }
	
    public function setArticulo($articulo) {
        $this->articulo = $articulo;
        return $this;
    }

    public function getArticulo() {
        return $this->articulo;
    }
}