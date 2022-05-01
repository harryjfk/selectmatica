<?php

namespace Store\StoreBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Store\StoreBundle\Entity\Clientes;
use Store\StoreBundle\Form\ClienteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Store\StoreBundle\Entity\Facturas;
use Store\StoreBundle\Form\FacturasType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Facturas controller.
 *
 */
class FacturasController extends Controller
{

    /**
     * Lists all Facturas entities.
     *
     */
    public function indexAction(Request $request,$profile)
    {
        $params = null;

        $count=$request->get('dataTables_length');
        $filter=$request->get('dataTables_filter');
        $params = new ArrayCollection();
        if($filter!='')
        {

            $params->add(new Parameter('numero','%'.$filter.'%'));
            $filter = 'a.numero LIKE :numero';

        }
        if($profile==true)
        {
            \Common\SeguridadBundle\Controller\DefaultController::BindCliente($this,$this->getUser());
            $params->add(new Parameter('idcliente',$this-> getUser()->getIdCliente()));
            $filter .='a.idcliente = :idcliente';
        }

        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Facturas',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);
        //$privs = array('new'=>$this->isGranted('ROLE_USUARIO_NEW'),'delete'=>$this->isGranted('ROLE_USUARIO_DELETE'),'edit'=>$this->isGranted('ROLE_USUARIO_EDIT') );
        if($profile==false)
        $privs = \Common\AdminBaseBundle\Controller\DefaultController::DefaultPriv();
else
    $privs = array('new'=>false,'delete'=>false,'edit'=>true);

        $rest=$this->getDoctrine()->getEntityManager('rest');
        foreach($entities as $e)
        {
          $e->setClienteObject($rest->getRepository('StoreRestBundle:Clientes')->find($e->getidCliente()));
        }

if($profile==true)
    return $this->render('StoreStoreBundle:Facturas:index_profile.html.twig', array(
        'entities' => $entities,'priviligies'=>$privs,'base_dir'=>$this->container->getParameter('file_uploader.web_base_path').'facturas/'
    ));
    else
        return $this->render('StoreStoreBundle:Facturas:index.html.twig', array(
            'entities' => $entities,'priviligies'=>$privs,'base_dir'=>$this->container->getParameter('file_uploader.web_base_path').'facturas/'
        ));
    }
    /**
     * Creates a new Facturas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Clientes();
        $form = $this->createCreateForm($entity);

        return $this->render('StoreStoreBundle:Facturas:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),'isNew'=>true
        ));
    }

    /**
     * Creates a form to create a Facturas entity.
     *
     * @param Facturas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Clientes $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('facturas_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Facturas entity.
     *
     */
    public function newAction(Request $request)
    {
          $entity = new Clientes();
        $form   = $this->createCreateForm($entity);
        $clients = \Common\SeguridadBundle\Controller\DefaultController::getClientes($this);
        $originals = new ArrayCollection();
        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getFacturas() as $precios) {
            $originals->add($precios);
        }
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($originals as $precios) {
                if (false === $entity->getFacturas()->contains($precios)) {
                    $entity->getFacturas()->removeElement($precios);
                    $precios->removeUpload();
                    $em->remove($precios);

                }
            }

            foreach($entity->getFacturas() as $p)
            {
                $p->setidCliente($request->get('idcliente'));
                $p->preUpload();
                $em->persist($p);
                $p->upload();
            }

            $em->flush();

              return $this->redirect($this->generateUrl('facturas'));
        }



        return $this->render('StoreStoreBundle:Facturas:edit.html.twig', array(
            'entity' => $entity,'clientes'=>$clients,
            'form'   => $form->createView(),'isNew'=>true
        ));
    }

    /**
     * Finds and displays a Facturas entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Facturas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facturas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreStoreBundle:Facturas:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Facturas entity.
     *
     */
    public function editAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Facturas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facturas entity.');
        }
        $clients = \Common\SeguridadBundle\Controller\DefaultController::getClientes($this);

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);
         if ($form->isValid()) {

             $entity->setIdcliente($request->get('idcliente'));
             $entity->preUpload();
            $em->persist($entity);
             $entity->upload();
             $em->flush();
           return  $this->redirect($this->generateUrl('facturas'));
        }


        return $this->render('StoreStoreBundle:Facturas:edit.html.twig', array(
            'entity'      => $entity,'clientes'=>$clients,'form'   => $form->createView(),
      'isNew'=>false
        ));

    }

    /**
    * Creates a form to edit a Facturas entity.
    *
    * @param Facturas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Facturas $entity)
    {
        $form = $this->createForm(new FacturasType(), $entity, array(
            'action' => $this->generateUrl('facturas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));



        return $form;
    }
    /**
     * Edits an existing Facturas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Facturas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facturas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

      /*      return $this->redirect($this->generateUrl('facturas_edit', array('id' => $id)));*/
        }

        return $this->render('StoreStoreBundle:Facturas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Facturas entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = array('status' => 1);
        $listIds = $request->get('idcheck', array());
        $json['ids']= array();
        $haeliminado = false;
        foreach ($listIds as $id) {
            $entity = $em->getRepository('StoreStoreBundle:Facturas')->find($id);


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
        $trans = $this->get('translator');
        if (!$haeliminado) {


            $json['status'] = 0;
        } else {
            $this->addFlash('alert alert-success', $trans->trans('js_eliminados_correctamente', array(), 'messages'));
        }

        return new Response(json_encode($json));
    }

    /**
     * Creates a form to delete a Facturas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facturas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function downloadAction(Request $request,$id)
    {
          $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Facturas')->find($id);

        return 'C:\xampp\htdocs\store\web\uploads\facturas\003-02.jpg';


        $response = new Response('', 200, array('Content-Type'          => 'application/jpg',
              'Content-Disposition'   => 'attachment; filename="C:\xampp\htdocs\store\web\uploads\facturas\003-02.jpg"'));
        return $response;
        /*
           return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );*/

    }
}
