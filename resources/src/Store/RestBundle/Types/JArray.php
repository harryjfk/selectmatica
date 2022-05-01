<?php
namespace Store\RestBundle\Types;

class JArray
{

    /**
     * @param array $array
     *
     */
    public function __construct($array)
    {
        $this->array  = $array;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }


}