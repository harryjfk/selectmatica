<?php

namespace Common\SeguridadBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Common\SeguridadBundle\Entity\SeguridadTraza,
    Common\BandecBundle\Entity\DocumentosNegociacion,
    Common\BandecBundle\Entity\DocumentosNegociacionPresentacion;

/**
 * Description of LogListener
 *
 * @author cronk
 */
class LogListener
{

    /**
     *
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    private function logObject($entity)
    {
        $reflect = new \ReflectionClass(get_class($entity));
        $prop = $reflect->getProperties();
        $format = array();
        foreach ($prop as $itm) {
            $nameprop = $itm->name;
            $iprop = $reflect->getProperty($nameprop);
            $iprop->setAccessible(true);
            $valueProp = $iprop->getValue($entity);

            if ($valueProp instanceof \DateTime && $valueProp) {
                $format[$nameprop] = $valueProp->format('d-m-Y');
                continue;
            }
            if (!$valueProp || is_object($valueProp))
                continue;
            $format[$nameprop] = $valueProp;
        }
        return $format;
    }

    private function registerEntityLog(LifecycleEventArgs $args, $actionName)
    {
        $entity = $args->getEntity();

        if ($entity instanceof SeguridadTraza || $entity instanceof DocumentosNegociacion || $entity instanceof DocumentosNegociacionPresentacion)
            return;


        $em = $args->getEntityManager();
        $obj = get_class($entity);
        $className = $em->getClassMetadata($obj)->table['name'];

        try {
            $request = $this->container->get('request');
        } catch (InactiveScopeException $e) {
            return;
        }

      /*  $log = new SeguridadTraza();
        $log->setAccion($actionName);
        $log->setFecha(new \DateTime());
        $log->setIp($request->getClientIp());
        $log->setIdregistro($entity->getId());
       $log->setUsuario($this->container->get('security.context')->getToken()->getUser()->getUsername());
        $log->setTabla($className);

        $format = array();
        $list = $this->logObject($entity);
        foreach ($list as $k => $v) {
            $format[] = $k . ': ' . $v;
        }
        $log->setObservacion(implode(' || ', $format));
        $log->setMetadatos(json_encode($list));
        $em->persist($log);
        $em->flush();*/
    }

    /**
     * Doctrine postRemove listener
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->registerEntityLog($args, 'Eliminar');
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->registerEntityLog($args, 'Editar');
    }

    /**
     * Doctrine postPersistlistener
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->registerEntityLog($args, 'Registrar');
    }

    /**
     * Doctrine onSecurityInteractiveLogin
     * @param \Doctrine\ORM\Event\InteractiveLoginEvent. $args
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $args)
    {
        $usuario = $args->getAuthenticationToken()->getUser();

        $em = $this->container->get('doctrine')->getEntityManager();
        $obj = get_class($usuario);
        $className = $em->getClassMetadata($obj)->table['name'];

        $request = $this->container->get('request');

        $log = new SeguridadTraza();
        $log->setAccion('Identificación');
        $log->setFecha(new \DateTime());
        $log->setIp($request->getClientIp());
        $log->setIdregistro($usuario->getId());
        $log->setUsuario($usuario->getUsername());
        $log->setTabla($className);
        $em->persist($log);
        $em->flush();
    }

}
