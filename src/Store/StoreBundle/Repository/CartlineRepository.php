<?php

namespace Store\StoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Store\StoreBundle\Controller\ProductoController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;


class CartlineRepository extends StoreBaseRepository
{
    public function getArticulo($entity)
    {
        $rep=  $this->getEntityManager()->getRepository('StoreStoreBundle:Producto')->setData($this->data);
        $rep->getArticulo($entity->getIdproducto());
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $t = parent::findBy($criteria, $orderBy, $limit, $offset);
        foreach($t as $t1)
            $this->getArticulo($t1);
        return $t;
    }
    public function find($id)
    {
        $t = parent::find($id);
        if($t!=null)
            $this->getArticulo($t);
        return $t;
    }
    public function findAll()
    {

        $t = parent::findAll();
        foreach($t as $t1)
            $this->getArticulo($t1);
        return $t;

    }
}
