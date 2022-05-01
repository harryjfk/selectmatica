<?php

namespace Store\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Store\StoreBundle\Entity\Cartline;
use Store\StoreBundle\Form\CartlineType;

/**
 * Cartline controller.
 *
 */
class CartlineController extends Controller
{

    /**
     * Lists all Cartline entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('StoreStoreBundle:Cartline')->findAll();

        return $this->render('StoreStoreBundle:Cartline:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Cartline entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cartline();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cartline_show', array('id' => $entity->getId())));
        }

        return $this->render('StoreStoreBundle:Cartline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cartline entity.
     *
     * @param Cartline $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cartline $entity)
    {
        $form = $this->createForm(new CartlineType(), $entity, array(
            'action' => $this->generateUrl('cartline_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cartline entity.
     *
     */
    public function newAction()
    {
        $entity = new Cartline();
        $form   = $this->createCreateForm($entity);

        return $this->render('StoreStoreBundle:Cartline:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cartline entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cartline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cartline entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreStoreBundle:Cartline:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cartline entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cartline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cartline entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreStoreBundle:Cartline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cartline entity.
    *
    * @param Cartline $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cartline $entity)
    {
        $form = $this->createForm(new CartlineType(), $entity, array(
            'action' => $this->generateUrl('cartline_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cartline entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cartline')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cartline entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cartline_edit', array('id' => $id)));
        }

        return $this->render('StoreStoreBundle:Cartline:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cartline entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('StoreStoreBundle:Cartline')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cartline entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cartline'));
    }

    /**
     * Creates a form to delete a Cartline entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartline_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function  removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreStoreBundle:Cartline')->find($id);

        if (!$entity) {
            return $this->redirect($this->generateUrl('cart_view'));
         /*   throw $this->createNotFoundException('Unable to find Cartline entity.');*/
        }

        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('cart_view'));
    }
}
