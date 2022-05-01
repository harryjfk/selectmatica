<?php

namespace Store\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity
 */
class Images
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
     * @ORM\Column(name="pathimage", type="string", length=255, nullable=false)
     */
    private $pathimage;



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
}
