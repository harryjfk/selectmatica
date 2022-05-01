<?php

namespace Common\SeguridadBundle\Controller;

use Common\SeguridadBundle\Form\UsuarioSimpleType;
use Doctrine\Common\Collections\ArrayCollection;
use Store\RestBundle\Entity\Clientes;
use Store\StoreBundle\Controller\ProductoController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\SwitchUserRole;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Common\SeguridadBundle\Entity\Usuario,
    Common\SeguridadBundle\Form\UsuarioType;

class DefaultController extends Controller
{

    public function allowedUser($userid)
    {
        return $this->getUser()->getId() == $userid;
    }

    public static function BindCliente($controller, Usuario $entity, $cant = 0)
    {

        if($entity->getIdcliente()==null)
            return;
        $res = $controller->getDoctrine()->getManager('rest');
        $p = $res->getRepository('StoreRestBundle:Clientes')->find($entity->getIdcliente());
        $entity->setCliente($p);

        /*  */

    }

    public static function getClientes($controller, $cant = 0)
    {


        $res = $controller->getDoctrine()->getManager('rest');
        return $res->getRepository('StoreRestBundle:Clientes')->findAll();

    }

    public static function getTarifa($controller, $cant = 0)
    {
        if($controller->getUser()==null)
            return 0;
        if($controller->getUser()->getIdcliente()==null)
            return 0;

        DefaultController::BindCliente($controller, $controller->getUser());

        return $controller->getUser()->getCliente()->getTarifa();


    }

    public function loginAction(Request $request)
    {

        $sesion = $request->getSession();
        \Common\AdminBaseBundle\Controller\LanguagesController::checkdefaultEnabled($this);
        // obtener, si existe, el error producido en el último intento de log
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $sesion->get(SecurityContext::AUTHENTICATION_ERROR);
            $sesion->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('CommonSeguridadBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }

 public static function  getData(Controller $controller)
 {
     $s = ProductoController::getData($controller);
     if ($controller->isGranted('ROLE_PREVIOUS_ADMIN')) {
         $authChecker = $controller->get('security.authorization_checker');
         $tokenStorage = $controller->get('security.token_storage');
         foreach ($tokenStorage->getToken()->getRoles() as $role) {
             if ($role instanceof SwitchUserRole) {
                 $controller->getUser()->setImpersonateUser( $role->getSource()->getUser());

                 break;
             }
         }
     }
   /*  else
         $this->getUser()->setImpersonateUser(null);*/

     return $s;
 }

    public function indexAction(Request $request)
    {

        $trans = $this->get('translator');
        if (!$this->isGranted('ROLE_USUARIO_VIEW')) {
            throw $this->createAccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
        }

        $em = $this->getDoctrine()->getManager();

        $params = array(
            'nombre' => $request->get('nombre'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'company' => $request->get('company'),
        );


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($em->getRepository('CommonSeguridadBundle:Usuario')->setData( DefaultController::getData($this))->queryResult($params));

        $privs = array('new' => $this->isGranted('ROLE_USUARIO_NEW'), 'delete' => $this->isGranted('ROLE_USUARIO_DELETE'), 'edit' => $this->isGranted('ROLE_USUARIO_EDIT'));

        return $this->render('CommonSeguridadBundle:Default:index.html.twig', array(
            'entities' => $pagination, 'priviligies' => $privs
        ));
    }

    public function registerAction(Request $request)
    {

        $isAjax = $request->isXmlHttpRequest();
        if (!$this->get('security.context')->isGranted('ROLE_USUARIO_NEW')) {
            if (!$isAjax) {
                throw new AccessDeniedException();
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }

        $form = $this->createCreateForm(new Usuario(), $request);
        return $this->render('CommonSeguridadBundle:Default:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, $id)
    {

        $trans = $this->get('translator');
        $isAllowed = (!$this->get('security.context')->isGranted('ROLE_USUARIO_EDIT') && $this->allowedUser($id));


        if (!$this->get('security.context')->isGranted('ROLE_USUARIO_EDIT') && !$this->allowedUser($id)) {
            throw new AccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommonSeguridadBundle:Usuario')->setData(DefaultController::getData($this))->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bancos entity.');
        }

        //se controla que solo el admin de sistema pueda editar sus datos
        $loguser = $this->getUser();
        if ($entity->getEsadmin()) {
            if ($loguser->getId() != $entity->getId()) {
                throw $this->createAccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
            }
        }

        $form = $this->createEditForm($entity, $request);
        return $this->render('CommonSeguridadBundle:Default:edit.html.twig', array(
            'form' => $form->createView(),
            'isAllowed' => $isAllowed, 'isNew' => false, 'clientes' => DefaultController::getClientes($this),'base_dir'=>$this->container->getParameter('user_upload_web')
        ));
    }

    public function registerCreateAction(Request $request)
    {

        $trans = $this->get('translator');
        $isAjax = $request->isXmlHttpRequest();
        $json = array('status' => 1, 'error' => array());
        if (!$this->get('security.context')->isGranted('ROLE_USUARIO_NEW')) {
            if (!$isAjax) {
                throw new AccessDeniedException();
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }

        $entity = new Usuario;
        $entity->setCreado(new \DateTime());
        $form = $this->createCreateForm($entity, $request);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //cifrando la contraseña
            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $salt = sha1(time() . rand(1, 999999));
            $entity->setSalt($salt);
            $passCodif = $encoder->encodePassword($entity->getPassword(), $salt);
            $entity->setPassword($passCodif);
            //fin cifrando la contraseña

            $em->persist($entity);
            $em->flush();

            if ($isAjax) {
                return $this->redirect($this->generateUrl('seguridad_list_users'));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-success', $trans->trans('js_datos_guardados', array(), 'messages'));
                return $this->redirect($this->generateUrl('seguridad_register', array('itemid' => $request->get('itemid'))));
            }
        }/* else {
            if ($isAjax) {
                $json['status'] = 0;
                $json['error'] = $this->container->get('bandec.util')->getFormErrorMessages($form);
                return new Response(json_encode($json));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-danger', $trans->trans('js_datos_no_guardados', array(), 'messages'));
            }
        }*/

        return $this->render('CommonSeguridadBundle:Default:edit.html.twig', array(
            'form' => $form->createView(), 'isNew' => true, 'clientes' => DefaultController::getClientes($this),'base_dir'=>$this->container->getParameter('user_upload_web')
        ));
    }

     private function getPassword($entity,$passOriginal)
     {

         if ($entity->getPassword() != NULL) {
             //cifrando la contraseña
             $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
             $salt = sha1(time() . rand(1, 999999));
             $entity->setSalt($salt);
             $passCodif = $encoder->encodePassword($entity->getPassword(), $salt);

             $entity->setPassword($passCodif);
             //fin cifrando la contraseña
         } else {
             $entity->setPassword($passOriginal);
         }
     }
    public function updateAction(Request $request, $id)
    {
        $isAjax = $request->isXmlHttpRequest();
        $json = array('status' => 1, 'error' => array());
        $trans = $this->get('translator');
        $isAllowedUser = $this->allowedUser($id);
        if (!$this->get('security.context')->isGranted('ROLE_USUARIO_EDIT') && !$isAllowedUser) {
            if (!$isAjax) {
                throw new AccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CommonSeguridadBundle:Usuario')->setData(DefaultController::getData($this))->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bancos entity.');
        }

        //se controla que solo el admin de sistema pueda editar sus datos
        $loguser = $this->getUser();
        if ($entity->getEsadmin()) {
            if ($loguser->getId() != $entity->getId()) {
                throw $this->createAccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
            }
        }


        $editForm = $this->createEditForm($entity, $request);
        $passOriginal = $editForm->getData()->getPassword();

        $editForm->handleRequest($request);

        $this->getPassword($entity,$passOriginal);

        if ($editForm->isValid()) {


         /*   $entity->setFile($request->files->get('usuario_file'));*/
   $em->persist($entity);
            $em->flush();
           if ($isAjax) {
                return $this->redirect($this->generateUrl('seguridad_list_users'));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-success', $trans->trans('js_datos_guardados', array(), 'messages'));
                return $this->redirect($this->generateUrl('seguridad_register_edit', array('id' => $id, 'itemid' => $request->get('itemid'))));
            }
        } else {
            if ($isAjax) {
                $json['status'] = 0;
                echo $editForm->getErrorsAsString();
             /*   $json['error'] = $this->container->get('bandec.util')->getFormErrorMessages($editForm);*/
                return new Response(json_encode($json));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-danger', $trans->trans('js_datos_no_guardados', array(), 'messages'));
            }
        }

        return $this->render('CommonSeguridadBundle:Default:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView()
        ));
    }

    private function createCreateForm(Usuario $entity, Request $request)
    {
        $form = $this->createForm(new UsuarioType($entity), $entity, array(
            'action' => $this->generateUrl('seguridad_register_create', array('itemid' => $request->get('itemid'))),
            'method' => 'POST',
        ));

        /*   $form->add('submit', 'submit', array('label' => 'guardar', 'translation_domain' => 'seguridad'));
              $form->add('button', 'button', array('label' => 'cancelar', 'translation_domain' => 'seguridad'));
      */
        return $form;
    }

    private function createEditForm(Usuario $entity, Request $request,$simple = false)
    {
        if($simple==true)
            $form = $this->createForm(new UsuarioSimpleType($this->getUser()), $entity, array(
                'action' => $this->generateUrl('seguridad_view', array('id' => $entity->getId(), 'itemid' => $request->get('itemid'))),
                'method' => 'POST',
            ));
            else
        $form = $this->createForm(new UsuarioType($this->getUser()), $entity, array(
            'action' => $this->generateUrl('seguridad_register_update', array('id' => $entity->getId(), 'itemid' => $request->get('itemid'))),
            'method' => 'POST',
        ));

        /*  $form->add('submit', 'submit', array('label' => 'guardar', 'translation_domain' => 'seguridad'));

          if ($this->get('security.context')->isGranted('ROLE_USUARIO_EDIT')) {
              $form->add('button', 'button', array('label' => 'cancelar', 'translation_domain' => 'seguridad'));
          }*/

        return $form;
    }

    /**
     * Deletes a Nomencladores entity.
     *
     */
    public function deleteUserAction(Request $request)
    {

        $json = array('status' => 1);
        $trans = $this->get('translator');
        if (!$this->get('security.context')->isGranted('ROLE_USUARIO_DELETE')) {
            $json['status'] = 2;
            return new Response(json_encode($json));
        }

        $em = $this->getDoctrine()->getManager();

        $listIds = $request->get('idcheck', array());
        $json['ids'] = array();
        $haeliminado = false;
        foreach ($listIds as $id) {
            $entity = $em->getRepository('CommonSeguridadBundle:Usuario')->setData(DefaultController::getData($this))->find($id);

            if ($entity->getEsadmin()) {
                $this->addFlash('alert alert-danger', $trans->trans('no_eliminar_admin', array(), 'messages'));
                continue;
            }

            if ($entity) {
                try {
                    $em->remove($entity);
                    $json['ids'][] = $id;
                    $em->flush();
                    $haeliminado = true;
                } catch (\Exception $e) {
                    $json['status'] = 0;
                }
            }
        }

        if (!$haeliminado) {


            $json['status'] = 0;
        } else {
            $this->addFlash('alert alert-success', $trans->trans('js_eliminados_correctamente', array(), 'messages'));
        }

        return new Response(json_encode($json));
    }

    public function viewAction(Request $request)
    {
        $em  = $this->getDoctrine()->getEntityManager();
             $user=  $this->getUser();
        $this->BindCliente($this,$user);
        $form = $this->createEditForm($user,$request,true);
        $passOriginal = $form->getData()->getPassword();

        $form->handleRequest($request);

        echo $form->getErrorsAsString();
        if( $form->isValid())
        {

      $t = $em->getRepository('CommonSeguridadBundle:Usuario')->setData(DefaultController::getData($this))->find($user->getId());

            $this->getPassword($t,$passOriginal);

            $em->persist($t);
            $em->flush();

        }
        return $this->render('@CommonSeguridad/Default/view.html.twig',array('form'=>$form->CreateView(),'isNew'=>false,'base_dir'=>$this->container->getParameter('user_upload_web')));
    }
    public function controlAction(Request $request)
    {
        $trans = $this->get('translator');
     /*   if (!$this->isGranted('ROLE_USUARIO_VIEW')) {
            throw $this->createAccessDeniedException($trans->trans('acceso_denegado', array(), 'messages'));
        }*/

        $em = $this->getDoctrine()->getManager();

        $params = array(
            'nombrec' => $request->get('nombrec'),
            'nombre'=>$request->get('nombre')

        );


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($em->getRepository('CommonSeguridadBundle:Usuario')->setData(DefaultController::getData($this))->getComercialesClientes($this->getUser(),$params));

        $privs = array('new' => false, 'delete' => false, 'edit' => false);

        return $this->render('CommonSeguridadBundle:Default:control.html.twig', array(
            'entities' => $pagination, 'priviligies' => $privs,'controller'=>$this
        ));
    }
    public function navAction(Request $request)
    {
        DefaultController::getData($this);

        return $this->render('CommonSeguridadBundle:Default:nav.html.twig', array(
        'base_dir'=>$this->container->getParameter('user_upload_web')
        ));
    }
    public function control_userAction($user)
    {
        return $this->redirect($this->generateUrl('store_homepage').'?_switch_user='.$user);
    }
}
