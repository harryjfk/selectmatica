<?php

namespace Store\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Store\RestBundle\Entity\Clientes;

/**
 * Cartline
 *
 * @ORM\Table(name="cartline", indexes={@ORM\Index(name="fk_producto", columns={"idproducto"}), @ORM\Index(name="fk_cart", columns={"idcart"})})
 * @ORM\Entity
 */
class Cartline
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var \Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcart", referencedColumnName="id")
     * })
     */
    private $idcart;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproducto", referencedColumnName="id")
     * })
     */
    private $idproducto;



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
     * @param \Store\StoreBundle\Entity\Producto $idproducto
     *
     * @return Cartline
     */
    public function setIdproducto(\Store\StoreBundle\Entity\Producto $idproducto = null)
    {
        $this->idproducto = $idproducto;

        return $this;
    }

    /**
     * Get idproducto
     *
     * @return \Store\StoreBundle\Entity\Producto
     */
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * Set idcart
     *
     * @param \Store\StoreBundle\Entity\Cart $idcart
     *
     * @return Cartline
     */
    public function setIdcart(\Store\StoreBundle\Entity\Cart $idcart = null)
    {
        $this->idcart = $idcart;

        return $this;
    }

    /**
     * Get idcart
     *
     * @return \Store\StoreBundle\Entity\Cart
     */
    public function getIdcart()
    {
        return $this->idcart;
    }
    public  function getPrice($tarifa)
    {

        return $this->getIdproducto()->basePrice($tarifa,$this->getCantidad());

    }
    public function getIVA()
    {
        return $this->getIdproducto()->getproducto()->getTipoIvaObject()->getporcentajeIVA();
    }
    public function getDiscount($tarifa)
    {
        $tarifabase = $this-> getIdproducto()->getProducto()->getTarifaValue($tarifa);
    return $this-> getIdproducto()->getProducto()->getDiscount($tarifabase,$this->getCantidad());
    }
    public function getIVAVAlue($tarifa)
    {
        return $this->getIVA()*$this->getFinalPrice($tarifa)/100;

    }
    public  function getFinalPrice($tarifa)
    {
        return $this->getIdproducto()->basePrice($tarifa,$this->getCantidad())*$this->getCantidad();
    }
    public  function getFinalPriceIVA($tarifa)
    {
        return $this->getFinalPrice($tarifa)+$this->getIVAVAlue($tarifa);
    }
    public function getAsPedidoLinea(Clientes $cliente)
    {
        $tarifa =  $this->getIdproducto()->getProducto()->getTarifaValue($cliente->getTarifa());
        $result = array();
        $linea = new \stdClass();
        $linea->articulo = $this->getIdproducto()->getIdproducto();
        $linea->cajas = 0;
        $linea->unidades = $this->getCantidad();
        $linea->tarifa = $cliente->getTarifa();
        $linea->precio = $tarifa->pvp;
        $linea->descuento1 = $this->getDiscount($cliente->getTarifa());
        $linea->descuento2 =0;
        $linea->descuento3 = 0;
        $linea->observaciones = $this->getIdcart()->getObservaciones();
        $linea->defectuoso = false;
        $result[] = $linea;

       $precios = $this->getIdproducto()->getProducto()->getPrecioEspecial();
        if ($precios != null) {


            $regalocant = $precios->getRegaloCant($this->cantidad);
            if ($regalocant > 0) {

                $linea = new \stdClass();
                $linea->articulo = $precios->getRegaloObject()->idArticulo;
                $linea->cajas = 0;
                $linea->unidades = $regalocant;
                $linea->tarifa = $cliente->getTarifa();
                $linea->precio = 0;
                $linea->descuento1 = 0;
                $linea->descuento2 = 0;
                $linea->descuento3 = 0;
                $linea->observaciones = '';
                $linea->defectuoso = false;
                $result[] = $linea;
            }
        }
        return $result;
    }

    public  function  __toString()
    {return "aaa";}
}
