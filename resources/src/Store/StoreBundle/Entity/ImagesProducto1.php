<?php

namespace Store\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagesProducto
 *
 * @ORM\Table(name="images_producto", indexes={@ORM\Index(name="FK_4987B7FD6E4E18", columns={"idproducto"})})
 * @ORM\Entity
 */
class ImagesProducto
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
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

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
     * Set path
     *
     * @param string $path
     *
     * @return ImagesProducto
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * @return ImagesProducto
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
    return $this->getPath();
}
    public  function getWebPath()
    {

        return str_replace( "C:\\xampp\\htdocs","http:\\\\localhost:8080",$this->getPath());
    }
}
