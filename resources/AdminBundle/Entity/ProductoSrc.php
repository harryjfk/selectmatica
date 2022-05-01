<?php
namespace Store\AdminBundle\Entity;
use JMS\Serializer\Annotation as JMS;


class ProductoSrc
{

    /**
     * @JMS\Type("string")
     */
    private $message;

    public function setMessage($value)
    {
        $this->message = $value;
    }

    public function  getMessage()
    {
        return $this->message;
    }
}
