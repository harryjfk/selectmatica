<?php

namespace Store\RestBundle\Repository;

//use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Store\RestBundle\Entity\Articulos;
use Store\RestBundle\Entity\PreciosEspeciales;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class PreciosEspecialesRepository extends RestBaseRepository
{


    public function getArticulo(PreciosEspeciales $preciosEspeciales)
    {

        $id = $preciosEspeciales->getRegaloObject()->idArticulo;

        if ($id != "" && $id != null) {

            $a = $this->getEntityManager()->getRepository('StoreRestBundle:Articulos')->setData($this->data)->find($id);
            if ($a != null) {
                $preciosEspeciales->setArticuloRegaloObject($a);

                $w = $this->data["store"]->getRepository('StoreStoreBundle:Producto')->setData($this->data)->findBy(array('idproducto' => $a->getId()));
                if (count($w) > 0)
                    $a->setProducto($w[0]);
            }
        }
    }

    public function getByProduct($id, Articulos $articulos = null)
    {
        $precios = $this->findAll();
        $result = array('0'=>array(),'1'=>array(),'2'=>array());
        if ($articulos != null)
            $articulos->__construct();

        $proesp = false;
        /*   $pureclient=false;*/
        $tarifa = $this->data['tarifa'];

        foreach ($precios as $precio) {


          /*  if ($precio->getDto1() > 0)*/ {
$full = ($precio->getTarifa() != null) && ($precio->getIdArticulo() != null) && ($precio->getIdCliente() != null);

                if (($precio->getTarifa() == $tarifa) && ($precio->getIdArticulo() == $id) && ($precio->getIdCliente() == $this->data["cliente"])) {
                    $result['0'][] = $precio;
                } else
                    if (!$full)
                    {
                        $partial = (($precio->getTarifa() != null) && ($precio->getIdArticulo() != null) && ($precio->getIdCliente() == null))||
                            (($precio->getTarifa() != null) && ($precio->getIdArticulo() == null) && ($precio->getIdCliente() != null))||
                            (($precio->getTarifa() == null) && ($precio->getIdArticulo() != null) && ($precio->getIdCliente() != null)) ;
                        if ((($precio->getTarifa() == $tarifa) && ($precio->getIdCliente() == $this->data["cliente"])) ||
                            (($precio->getIdArticulo() == $id) && ($precio->getIdCliente() == $this->data["cliente"])) ||
                            (($precio->getTarifa() == $tarifa) && ($precio->getIdArticulo() == $id))
                        ) {

                            $result['1'][] = $precio;
                        } else if(!$partial)
                            if ((($precio->getTarifa() == $tarifa) || ($precio->getIdCliente() == $this->data["cliente"])) ||
                                (($precio->getIdArticulo() == $id))
                            )
                            {

                                $result['2'][] = $precio;
                            }

            }}
            /*   if (($precio->getIdArticulo() == $id ||$precio->getIdArticulo() == null) && ($precio->getIdCliente() == null || ($precio->getIdCliente() != null && $precio->getIdCliente() == $this->data["cliente"])) && ($precio->getDto1()>0)) {

                    if ($articulos != null ) {
                      //

                       {
                           $articulos->getPreciosEspeciales()->clear();
                           $result->clear();
                           $proesp = False;
                           $result->add($precio);
                           $articulos->addPreciosEspeciale($precio);
                           break;
                       }else if ($precio->getTarifa() == null)
                       if (($precio->getIdCliente() != null && $precio->getIdCliente() == $this->data["cliente"])) {
                           $proesp = true;
                           if ($pureclient == false && $precio->getIdArticulo() == null)
                               $pureclient = true;

                       }

                   }
                   if ($precio->getTarifa() == null )
                   {
                       $articulos->addPreciosEspeciale($precio);
                       $result->add($precio);
                   }




               }*/
        }

        /*   if($proesp)
           {

             $res = new ArrayCollection();
               foreach ($result as $r)
                   if($r->getIdCliente()==null)
                  $articulos->removePreciosEspeciale($r);
               else

                   $res->add($r);

               $result=$res;
           }
        */
$res = new ArrayCollection();
        if (count($result['0']) != 0)
            $res= $result['0'];
        else
            if (count($result['1']) != 0)
                $res= $this->getInternalPriority($result['1'],$tarifa,$id);
            else if (count($result['2']) != 0)
                $res=  $this->getInternalPriority($result['2'],$tarifa,$id);

        if($articulos!=null)
            foreach($res as $r)
            {
              $this->getArticulo($r);
                $articulos->addPreciosEspeciale($r);

            }




            return $res;

    }

    private function getInternalPriority($arr,$tarifa,$id)
    {

        if(count($arr)==1)
            return $arr;
        else {
            $w = array('0'=>array(),'1'=>array(),'2'=>array());
            foreach ($arr as $t)
                if ($t->getIdCliente() == $this->data["cliente"])
                    $w['0'][] = $t;
                else

                    if ($t->getTarifa() == $tarifa)
                        $w['1'][] = $t;
                    else
                        $w['2'][] = $t;
            $result =array();
            foreach($w as $k=>$v)
                foreach($v as $f)
                    $result[]=$f;


    return $result;
        }

    }
}
