<?php

namespace Common\SeguridadBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SeguridadSalvasRepository extends EntityRepository {

    public function queryResult($params = array()) {
        $cond = array();
        $parameters = array();

        if ($params['fini'] && $params['ffin']) {
            $cond[] = "(s.fechaSalva between :fini and :ffin)";
            $parameters['fini'] = $params['fini'];
            $parameters['ffin'] = $params['ffin'];
        } elseif ($params['fini']) {
            $cond[] = "s.fechaSalva >= :fini";
            $parameters['fini'] = $params['fini'];
        } elseif ($params['ffin']) {
            $cond[] = "s.fechaSalva <=:ffin";
            $parameters['ffin'] = $params['ffin'];
        }
        
        $hasParameters = count($parameters) > 0;
        $q = $hasParameters ? 'where '.implode(' and ', $cond) : '';
        $dql = "select s,u from SeguridadBundle:SeguridadSalvas s join s.idusuario u $q order by s.fechaSalva desc";
        $query = $this->getEntityManager()->createQuery($dql);
        if($hasParameters)
            $query->setParameters ($parameters);
        
        return $query;
    }

}
