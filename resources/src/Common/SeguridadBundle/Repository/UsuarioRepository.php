<?php

namespace Common\SeguridadBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
//use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Common\SeguridadBundle\Entity\Usuario;

class UsuarioRepository extends EntityRepository implements UserProviderInterface {


    public  function getBaseParams($params= array())
    {
        $cond = array();
        $parameters = new ArrayCollection();

        if($params['nombre']!="")
        {
            $cond[] = '(u.nombre like :nombre or u.primerApellido like :nombre or u.segundoApellido like :nombre)';
            $parameters->add(new Parameter('nombre', '%'.$params['nombre'].'%'));
        }

        if($params['username']!="")
        {
            $cond[] = 'u.username like :username';
            $parameters->add(new Parameter('username', '%'.$params['username'].'%'));

        }

        if($params['email']!="")
        {
            $cond[] = 'u.email like :email';
            $parameters->add(new Parameter('email', '%'.$params['email'].'%'));

        }
       /* if($params['company']!="")
        {
            $cond[] = 'u.company like :company';
            $parameters->add(new Parameter('company', '%'.$params['company'].'%'));

        }*/
        return array('cond'=>$cond,'params'=>$parameters);
    }
    public function queryResult($params = array(),$morewhre="") {

        $t = $this->getBaseParams($params);
        $cond = $t['cond'];
        $parameters = $t['params'];


        $hasParameters = count($cond) > 0;
        $q = $hasParameters|| $morewhre!="" ? 'where '.implode( ' and ', $cond ) : '';
        $q.=$morewhre!="" ? $hasParameters?' and '.$morewhre:$morewhre : $morewhre;


          $query = $this->getEntityManager()->createQuery("select u
                from CommonSeguridadBundle:Usuario u

                ".$q." order by u.nombre asc");
        if($hasParameters)
            $query->setParameters ($parameters);



        // left join u.idcliente as c


        return $query;

    }


    public function getComercialesClientes(Usuario $user,$params=array())
    {

        $em = $this->data["rest"];



      $c=  $em->getRepository('StoreRestBundle:Clientes')->findBy(array('agente'=>$user->getIdComercial()));
        if($params['nombrec']!=null)
        {
            $t= array();
            foreach($c as $w)
                if(strpos(strtolower($w->getNombre()),strtolower($params['nombrec']))!==false)
                    $t[]=$w;
            $c=$t;
        }
        $where=" (";
       for($i=0;$i<count($c);$i++)

        {
            $where.=' u.idcliente = '.$c[$i]->getid();
            if($i<count($c)-1)
                $where.=' or ';
            else
                $where.=")";
        }
        if(trim($where)=='(')
            $where=" (-1=0)";
        $params['username']='';
        $params['email']='';
        $t = $this->queryResult($params,$where);


        return $t;

    }


  public function where($where)
  {
      $q = $this
          ->createQueryBuilder('u')
          ->select('u, gu, r')
          ->where($where)
          ->join('u.grupoid', 'gu')
          ->join('gu.rol', 'r')
          ->getQuery()
      ;
      return $q->getResult();
  }

    public function loadUserByUsername($username) {
       
        $q = $this
                ->createQueryBuilder('u')
                ->select('u, gu, r')
                ->where('u.username = :username OR u.email = :email')
                ->join('u.grupoid', 'gu')
                ->join('gu.rol', 'r')
                ->setParameter('username', $username)
                ->setParameter('email', $username)
                ->getQuery()
        ;

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            //devuelvo una instancia del usuario vacía si no se ha encontrado para que no de error
            $user = new Usuario();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('La instancia de "%s" no está soportada.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
    private $data=null;
    public function setData($data)
{
    $this->data =$data;
    return     $this;
}
    public function getCliente($entity)
    {
          if($this->data==null ||$entity->getidcliente() ==null)
            return;
        $em = $this->data["rest"];
           $p = $em->getRepository('StoreRestBundle:Clientes')->setData($this->data)->find($entity->getidcliente());
        $entity->setCliente($p);
    }
    public function getClientes($list)
    {
        foreach($list as $t1)
            $this->getCliente($t1);
    }
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $t = parent::findBy($criteria, $orderBy, $limit, $offset);
       $this->getClientes($t);
        return $t;
    }
    public function find($id)
    {
        $t = parent::find($id);
        if($t!=null)
            $this->getCliente($t);
        return $t;
    }
    public function findAll()
    {

        $t = parent::findAll();
        $this->getClientes($t);
        return $t;

    }

}
