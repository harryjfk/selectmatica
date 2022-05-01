<?php

namespace Common\SeguridadBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SeguridadGrupoRepository extends EntityRepository {

    public function queryResult($params = array()) {
        $cond = array();
        $parameters = array();

        if ($params['nombre']) {
            $cond[] = "g.nombreGrupo like :nombre";
            $parameters['nombre'] = '%'.$params['nombre'].'%';
        }

        $hasParameters = count($parameters) > 0;
        $where = $hasParameters ? ' and ' . implode(' and ', $cond) : '';
        $query = $this->getEntityManager()->createQuery("select g from CommonSeguridadBundle:SeguridadGrupo g where (g.essistema = false or g.essistema is NULL)
                $where order by g.nombreGrupo asc");

        if ($hasParameters)
            $query->setParameters($parameters);
       
        return $query;
    }

}
