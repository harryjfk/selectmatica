<?php

namespace Common\SeguridadBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SeguridadTrazaRepository extends EntityRepository {

    public function queryResult($params = array()) {
        $cond = array();
        $parameters = array();

        if ($params['usuario']) {
            $cond[] = 's.usuario like :usuario';
            $parameters['usuario'] = '%' . $params['usuario'] . '%';
        }

        if ($params['accion']) {
            $cond[] = 's.accion like :accion';
            $parameters['accion'] = '%' . $params['accion'] . '%';
        }

        if ($params['tabla']) {
            $cond[] = 's.tabla like :tabla';
            $parameters['tabla'] = '%' . $params['tabla'] . '%';
        }

        if($params['fini'])
        {
            $params['fini'] .= ' '.date('H:i:s'); 
        }
        
        if($params['ffin'])
        {
            $params['ffin'] .= ' '.date('H:i:s'); 
        }

        if ($params['fini'] && $params['ffin']) {
            $cond[] = "(s.fecha between :fini and :ffin)";
            $parameters['fini'] = $params['fini'];
            $parameters['ffin'] = $params['ffin'];
        } elseif ($params['fini']) {
            $cond[] = "s.fecha >= :fini";
            $parameters['fini'] = $params['fini'];
        } elseif ($params['ffin']) {
            $cond[] = "s.fecha <=:ffin";
            $parameters['ffin'] = $params['ffin'];
        }

        $hasParameters = count($parameters) > 0;
        $q = $hasParameters ? 'where ' . implode(' and ', $cond) : '';
        $dql = "select s from SeguridadBundle:SeguridadTraza s $q order by s.fecha desc";
        $query = $this->getEntityManager()->createQuery($dql);
        if ($hasParameters)
            $query->setParameters($parameters);

        return $query;
    }

}
