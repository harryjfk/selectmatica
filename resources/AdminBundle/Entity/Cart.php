<?php

namespace Store\AdminBundle\Entity;

/**
 * Cart
 */
class Cart
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    //aqui ver pq no me genera los hijos

    public  function gettotalItemNumber()
    {
        return 0;
    }
}

