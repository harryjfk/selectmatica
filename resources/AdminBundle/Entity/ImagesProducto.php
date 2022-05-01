<?php

namespace Store\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagesProducto
 *
 * @ORM\Table(name="images_producto", indexes={@ORM\Index(name="FK_4987B7FD6E4E18", columns={"idproducto"}), @ORM\Index(name="FK_4987B7F13386846", columns={"idimage"})})
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
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproducto", referencedColumnName="id")
     * })
     */
    private $idproducto;

    /**
     * @var \Images
     *
     * @ORM\ManyToOne(targetEntity="Images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idimage", referencedColumnName="id")
     * })
     */
    private $idimage;



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
     * Set idimage
     *
     * @param \Store\AdminBundle\Entity\Images $idimage
     *
     * @return ImagesProducto
     */
    public function setIdimage(\Store\AdminBundle\Entity\Images $idimage = null)
    {
        $this->idimage = $idimage;

        return $this;
    }

    /**
     * Get idimage
     *
     * @return \Store\AdminBundle\Entity\Images
     */
    public function getIdimage()
    {
        return $this->idimage;
    }

    /**
     * Set idproducto
     *
     * @param \Store\AdminBundle\Entity\Producto $idproducto
     *
     * @return ImagesProducto
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
}
