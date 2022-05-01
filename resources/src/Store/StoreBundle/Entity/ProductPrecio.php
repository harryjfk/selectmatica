<?php

namespace Store\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPrecio
 *
 * @ORM\Table(name="product_precio", indexes={@ORM\Index(name="producto", columns={"idproducto"})})
 * @ORM\Entity
 */
class ProductPrecio
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
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var float
     *
     * @ORM\Column(name="precioiva", type="float", precision=10, scale=0, nullable=false)
     */
    private $precioiva;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproducto", referencedColumnName="id")
     * })
     */
    private $idproducto;



    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return ProductPrecio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set precioiva
     *
     * @param float $precioiva
     *
     * @return ProductPrecio
     */
    public function setPrecioiva($precioiva)
    {
        $this->precioiva = $precioiva;

        return $this;
    }

    /**
     * Get precioiva
     *
     * @return float
     */
    public function getPrecioiva()
    {
        return $this->precioiva;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return ProductPrecio
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
     * @return ProductPrecio
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
    public function __toString()
    {
        return  escapeshellarg( $this->getId());
    }
}
