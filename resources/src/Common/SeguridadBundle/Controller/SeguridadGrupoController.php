<?php

namespace Common\SeguridadBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\SeguridadBundle\Entity\SeguridadGrupo;
use Common\SeguridadBundle\Form\SeguridadGrupoType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * SeguridadGrupo controller.
 *
 */
class SeguridadGrupoController extends Controller {

    /**
     * Lists all SeguridadGrupo entities.
     *
     */
    public function indexAction(Request $request) {
        
        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_VIEW')) {
           throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $params = array('nombre' => $request->get('nombre'));
        $entities = $paginator->paginate(
                $em->getRepository('CommonSeguridadBundle:SeguridadGrupo')->queryResult($params), $request->query->getInt('page', 1), $this->container->getParameter('knp_paginator.page_range')
        );
        $privs = array('new'=>$this->isGranted('ROLE_GRUPO_USUARIO_NEW'),'delete'=>$this->isGranted('ROLE_GRUPO_USUARIO_DELETE'),'edit'=>$this->isGranted('ROLE_GRUPO_USUARIO_EDIT') );

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:index.html.twig', array(
                    'entities' => $entities,'priviligies'=>$privs
        ));
    }

    /**
     * Creates a new SeguridadGrupo entity.
     *
     */
    public function createAction(Request $request) {

        $isAjax = $request->isXmlHttpRequest();
        $json = array('status' => 1, 'error' => array());

        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_NEW')) {
            if (!$isAjax) {
                throw new AccessDeniedException();
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }
        
        $trans = $this->container->get('translator');
        $entity = new SeguridadGrupo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($isAjax) {
                return $this->redirect($this->generateUrl('grupo'));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-success', $trans->trans('js_datos_guardados', array(), 'messages'));
                return $this->redirect($this->generateUrl('grupo_new', array('itemid' => $request->get('itemid'))));
            }
        } else {
            if ($isAjax) {
                $json['status'] = 0;
                $json['error'] = $this->container->get('bandec.util')->getFormErrorMessages($form);
                return new Response(json_encode($json));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-danger', $trans->trans('js_datos_no_guardados', array(), 'messages'));
            }
        }

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SeguridadGrupo entity.
     *
     * @param SeguridadGrupo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SeguridadGrupo $entity) {
        $form = $this->createForm(new SeguridadGrupoType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('grupo_create'),
            'method' => 'POST',
        ));

     /*   $form->add('submit', 'submit', array('label' => 'guardar', 'translation_domain' => 'backend'));
        $form->add('button', 'button', array('label' => 'cancelar', 'translation_domain' => 'backend'));
*/
        return $form;
    }

    /**
     * Displays a form to create a new SeguridadGrupo entity.
     *
     */
    public function newAction() {

        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_NEW')) {
            throw new AccessDeniedException();
        }

        $entity = new SeguridadGrupo();
        $form = $this->createCreateForm($entity);

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),'isNew'=>true
        ));
    }

    /**
     * Finds and displays a SeguridadGrupo entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonSeguridadBundle:SeguridadGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SeguridadGrupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SeguridadGrupo entity.
     *
     */
    public function editAction($id) {
        
        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_EDIT')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonSeguridadBundle:SeguridadGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SeguridadGrupo entity.');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),'isNew'=>false
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a SeguridadGrupo entity.
     *
     * @param SeguridadGrupo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SeguridadGrupo $entity) {
        $form = $this->createForm(new SeguridadGrupoType($this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('grupo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

    /*    $form->add('submit', 'submit', array('label' => 'guardar', 'translation_domain' => 'backend'));
        $form->add('button', 'button', array('label' => 'cancelar', 'translation_domain' => 'backend'));
*/
        return $form;
    }

    /**
     * Edits an existing SeguridadGrupo entity.
     *
     */
    public function updateAction(Request $request, $id) {
        
        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_EDIT')) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonSeguridadBundle:SeguridadGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SeguridadGrupo entity.');
        }

        $trans = $this->container->get('translator');
        $isAjax = $request->isXmlHttpRequest();
        $json = array('status' => 1, 'error' => array());

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($isAjax) {
                return $this->redirect($this->generateUrl('grupo'));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-success', $trans->trans('js_datos_guardados', array(), 'messages'));
                return $this->redirect($this->generateUrl('grupo_edit', array('id' => $id)));
            }
        } else {
            if ($isAjax) {
                $json['status'] = 0;
                $json['error'] = $this->container->get('bandec.util')->getFormErrorMessages($editForm);
                return new Response(json_encode($json));
            } else {
                $this->get('session')->getFlashBag()->add('alert alert-danger', $trans->trans('js_datos_no_guardados', array(), 'messages'));
            }
        }

        return $this->render('CommonSeguridadBundle:SeguridadGrupo:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SeguridadGrupo entity.
     *
     */
    public function deleteAction(Request $request) {

        $json = array('status' => 1, 'ids' => array());
        $isAjax = $request->isXmlHttpRequest();
        if (!$this->get('security.context')->isGranted('ROLE_GRUPO_USUARIO_DELETE')) {
            if (!$isAjax) {
                throw new AccessDeniedException();
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }
        
        $em = $this->getDoctrine()->getManager();
        $listIds = $request->get('idcheck', array());
        foreach ($listIds as $id) {
            $entity = $em->getRepository('CommonSeguridadBundle:SeguridadGrupo')->find($id);
            if ($entity) {
                try {
                    $em->remove($entity);
                    $em->flush();
                    $json['ids'][] = $id;
                } catch (\Exception $e) {
                    
                }
            }
        }

        if (!count($json['ids']))
            $json['status'] = 0;

        return new Response(json_encode($json));

        //return $this->redirect($this->generateUrl('grupo'));
    }

    /**
     * Creates a form to delete a SeguridadGrupo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('grupo_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
