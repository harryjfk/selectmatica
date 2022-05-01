<?php

namespace Store\StoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaginatorAware extends \Knp\Bundle\PaginatorBundle\Definition\PaginatorAware
{


    public  function  ExecutePagination(Controller $controller,$table,$page,$container,$count=null,$filter="",$params=null)

    {
        $em = $controller->getDoctrine()->getManager();
        $c= $count;
        if($c==null)
          $c= $container->getParameter('knp_paginator.page_range');

        if($filter!="")
            $filter="WHERE ".$filter;
        $dql   = "SELECT a FROM ".$table." a " .$filter;
        $query = $em->createQuery($dql);
      //  echo $query->getQuery();
        if($filter!="")
            $query->setParameters($params);
        $pagination = $this->getPaginator()->paginate(
            $query, $page
            , $c
        );
        return $pagination;
    }


}
