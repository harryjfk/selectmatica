<?php

namespace Store\StoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Store\StoreBundle\Entity\Category;
use Store\StoreBundle\Controller\ProductoController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;


class CategoryRepository extends StoreBaseRepository
{

    public function getArticulo(Category $entity)
    {
        $rep=  $this->getEntityManager()->getRepository('StoreStoreBundle:Producto')->setData($this->data);
        $rep->getArticulos($entity->getProductos());
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
    public function findByLength(array $array,$pos)
    {
        $s = $this->findBy($array);
        $r = array();
        foreach ($s as $w)
            if($w->getLength()==$pos)
                $r[]=$w;
        return $r;
    }
    public function findAll()
    {

        $t = parent::findAll();
        foreach($t as $t1)
            $this->getArticulo($t1);
        return $t;

    }
    public  function findNav($section,$family,$subfamily)
    {
    if($section==true)
        return $this->findBy(array('idparent'=>null));
        else
            if($family==true)
            {
             $parents = $this->findBy(array('idparent'=>null));
                $result = array();
                foreach($parents as $parent )
                    foreach($parent->getChilds() as $child)
                    $result[]=$child;
                return $result;
            }
        else
            if($subfamily==true)
        {
            $parents = $this->findBy(array('idparent'=>null));
            $result = array();
            foreach($parents as $parent )
                foreach($parent->getChilds() as $child)
                    foreach($child->getChilds() as $child1)
                    $result[]=$child1;
            return $result;
        }
    }
}
