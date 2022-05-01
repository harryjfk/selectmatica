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


class CartRepository extends StoreBaseRepository
{

    public function getArticulo($entity)
    {
        $rep = $this->getEntityManager()->getRepository('StoreStoreBundle:Producto')->setData($this->data);
        foreach ($entity->getLines() as $line)
            $rep->getArticulo($line->getIdproducto());
        $this->getUser($entity);
    }

    public function getArticulos($entities)
    {
        foreach ($entities as $entity)
            $this->getArticulo($entity);
    }

    public function getUser($entity)
    {


        $user = $this->getEntityManager()->getRepository('CommonSeguridadBundle:Usuario')->setData($this->data)->find($entity->getIduser());

        $entity->setUserObject($user);

    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $t = parent::findBy($criteria, $orderBy, $limit, $offset);
        foreach ($t as $t1)
            $this->getArticulo($t1);
        return $t;
    }

    public function find($id)
    {
        $t = parent::find($id);
        if ($t != null)
            $this->getArticulo($t);
        return $t;
    }

    public function findAll()
    {

        $t = parent::findAll();
        foreach ($t as $t1)
            $this->getArticulo($t1);
        return $t;

    }

    public static function getMonths()
    {
        return array('1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',);
    }

    public function getPreValues($from, $to,$type)
    {
        $t = array();
        $me = $this->getMonths();
        if($type!=0)
        {
            $cat = $this->getEntityManager()->getRepository('StoreStoreBundle:Category')->findBy(array('type_src'=>$type));
      $me =array();
            foreach($cat as $c)
                $me[$c->getId()]=$c->getName();

        }

        for ($i = $from; $i <= $to; $i++) {
            $value = array('y' => $i);
            foreach ($me as $m => $key)
             /*   if($type==0)*/
                    $value[$m] = 0.0;

          /*  else
            {
                foreach($me as $cat)
                    $value[$cat->getId()]=0.0;
            }*/
            $t[$i] = $value;

        }
        $w['values']=$t;
        $w['columns']=$me;
        return $w;


    }

    public function getCartFromDates($profile, $from, $to)
    {
        $f = date($from . '-01-01');
        $t = date($to . '-12-31');
        $p = "";
        if($profile!=="false")

            $p = ' and c.iduser = '.$profile;


        $query = $this->getEntityManager()->createQuery("select c
                from StoreStoreBundle:Cart c
Where c.date BETWEEN '" . $f . "' and '" . $t . "'".$p);


        $carts = $query->getResult();
        $this->getArticulos($carts);
        return $carts;
    }

    public function getComprasGraph($profile, $from, $to)
    {
        $carts = $this->getCartFromDates($profile, $from, $to);
        $values = $this->getPreValues($from, $to,0);
        //  echo count($carts);

        foreach ($carts as $cart) {
            $v = $cart->getTotalPrice();
            $month = $cart->getDate()->format('m');
            if ($month[0] == '0')
                $month = substr($month, 1, 1);

            $values['values'][$cart->getDate()->format('Y')][$month] = $values['values'][$cart->getDate()->format('Y')][$month] + $v;
        }
        return $values;
    }

    public function getCategoryGraph($profile, $from, $to, $type)
    {
        $carts = $this->getCartFromDates($profile, $from, $to);
        $values = $this->getPreValues($from, $to,$type);
        $columns = array();
        $colores =array();
        $values1= array();
        foreach($values['values'] as $v)
              $columns[]=$v['y'];


        foreach($values['columns'] as $c=>$v)
            if(!array_key_exists($c,$values1))
            {
                $w=array();

                foreach($columns as $cw)

                        $w[$cw]=0;
                $values1[$v]=$w;
            }


          foreach ($carts as $cart) {

            foreach($cart->getLines() as $line)
            {
                $cat = $line->getIdproducto()->getIdcategory();
                $K = $cat->getTypeId($type,true);
            $s=0;
                if(array_key_exists($K,$values1))
                  $s=  $values1[$K][$cart->getDate()->format('Y')];
                $values1[$K][$cart->getDate()->format('Y')] =$s+ $line->getCantidad();
            }

        }

        $result=array();
        foreach($values1 as $k=>$v)
        {
            foreach($columns as $c)
                if(!array_key_exists($c,$v))
                    $v[$c]=0;
            $v['y']=$k;
           $result[$k]=$v;
            $colores[$v['y']]['fillColor']="rgba(".random_int(0,255).", ".random_int(0,255)."," .random_int(0,255).", 1)";
            $colores[$v['y']]['stroke']=$colores[$v['y']]['fillColor'];
            $colores[$v['y']]['StrokeColor']=$colores[$v['y']]['fillColor'];
            $colores[$v['y']]['HighlightStroke']=$colores[$v['y']]['fillColor'];
            $colores[$v['y']]['lineColor']=$colores[$v['y']]['fillColor'];
            $colores[$v['y']]['pointColor']=$colores[$v['y']]['fillColor'];



        }
    $result=array('columns'=>$columns,'values'=>$result,'colors'=>$colores);
        return $result;
    }
}
