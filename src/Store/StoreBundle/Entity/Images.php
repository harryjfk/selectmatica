<?php

namespace Store\StoreBundle\Entity;

/**
 * Images
 */
class Images
{
    /**
     * @var string
     */
    private $pathimage;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set pathimage
     *
     * @param string $pathimage
     *
     * @return Images
     */
    public function setPathimage($pathimage)
    {
        $this->pathimage = $pathimage;

        return $this;
    }

    /**
     * Get pathimage
     *
     * @return string
     */
    public function getPathimage()
    {
        return $this->pathimage;
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
     * Add image
     *
     * @param \Store\StoreBundle\Entity\ImagesProducto $image
     *
     * @return Images
     */
    public function addImage(\Store\StoreBundle\Entity\ImagesProducto $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Store\StoreBundle\Entity\ImagesProducto $image
     */
    public function removeImage(\Store\StoreBundle\Entity\ImagesProducto $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
