<?php

namespace Store\StoreBundle\Entity;

/**
 * Options
 */
class Options
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $columns;

    /**
     * @var string
     */
    private $valores;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Options
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set columns
     *
     * @param string $columns
     *
     * @return Options
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get columns
     *
     * @return string
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set valores
     *
     * @param string $valores
     *
     * @return Options
     */
    public function setValores($valores)
    {
        $this->valores = $valores;

        return $this;
    }

    /**
     * Get valores
     *
     * @return string
     */
    public function getValores()
    {
        return $this->valores;
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
