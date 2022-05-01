<?php

namespace Store\StoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Store\StoreBundle\Controller\ProductoController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;


class ProductoRepository extends StoreBaseRepository
{

    public function getArticulo($entity)
    {
        if($this->data==null)
            return;
       $em = $this->data["rest"];
        $p = $em->getRepository('StoreRestBundle:Articulos')->setData($this->data)->find($entity->getIdproducto());
        $entity->setProducto($p);
    }
    public function getArticulos( $arrayCollection)
    {
        foreach($arrayCollection as $a)
            $this->getArticulo($a);
    }

     public function frame()
     {

         $rsm = new ResultSetMapping();
         $rsm->addEntityResult('StoreStoreBundle:Producto', 'p');
         $rsm->addFieldResult('p', 'idproducto', 'idproducto');
         $rsm->addFieldResult('p', 'id', 'id');
         $rsm->addFieldResult('p', 'sessionid', 'sessionid');
         $dql   = "SELECT idproducto,id,sessionid FROM producto LIMIT 0,5";
         $query = $this->getEntityManager()->createNativeQuery($dql,$rsm);

      $e =    $query->getResult();

        $this->getArticulos($e);
         return $e;

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
	 public function findByEmpty(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $t = parent::findBy($criteria, $orderBy, $limit, $offset);
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
