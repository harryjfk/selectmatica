<?php

namespace Store\StoreBundle\Entity;

/**
 * ImagesProducto
 */
class ImagesProducto
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Store\StoreBundle\Entity\Producto
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
    public function getRandom()
    {
        return md5(rand(1, 999999999999999999999)*microtime());
    }

    public  function getWebPath($type=null )
    {
        if($this->path=='no-img.png')
            return $this->path;
        $t = $type;
        if($t==null )
            $t="";
        return "/".$t."/".$this->getPath()/*. '?rand='*/;
    }
}
