<?php

namespace Store\AdminBundle\Controller;

use Store\AdminBundle\Entity\ImagesProducto;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Store\AdminBundle\Entity\Producto;
use Store\AdminBundle\Form\ProductoType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Producto controller.
 *
 */
class ProductoController extends Controller
{

    /**
     * Lists all Producto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('StoreAdminBundle:Producto')->findAll();

        return $this->render('StoreAdminBundle:Producto:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Producto entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $msg = "";
        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);

                $em->flush();

                return $this->redirect($this->generateUrl('producto_show', array('id' => $entity->getId(), 'msg' => 'Todo Ok')));

            } catch (Exception $w) {
                $msg = "error";
            }

        }

        return $this->render('StoreAdminBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

    /**
     * Creates a form to create a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_create'),
            'method' => 'POST',
        ));


        //   $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    private function GetEditId($id)
    {
        $t = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $id) || $t == null) {
            $t = sprintf('%09d', mt_rand(0, 1999999999));
            if ($id) {
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $id,
                        'to_folder' => 'tmp/attachments/' . $t,
                        'create_to_folder' => true));
            }
        }
        return $t;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     */
    public function newAction(Request $request)
    {
       /* $entity = new Note();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
if($form->isValid())
{
    $s = $this->get('store.client');
    $note = ['message'=>'wwwww'];
    $request = $s->post('notes.json',["note"],['note'=>$note]);
    $response = $request->send();

}*/

        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setSessionid($request->get('editId'));
            $files = $entity->UploadImages($request->get('editId'), 'C:\xampp\htdocs\store\web\uploads\tmp\attachments', $em);

            $em->persist($entity);

            foreach ($files as $file) {
                $imgprod = new ImagesProducto();
                $imgprod->setIdimage($file);
                $imgprod->setIdproducto($entity);
                $em->persist($imgprod);
            }

            $em->flush();
            $this->redirectToRoute('producto');
        }
        $editId = $this->GetEditId($entity->getId());
        return $this->render('StoreAdminBundle:Producto:edit.html.twig', array(
            'entity' => $entity, 'editId' => $editId,
            'form' => $form->createView(), 'isNew' => true
        ));

    }

    /**
     * Finds and displays a Producto entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreAdminBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreAdminBundle:Producto:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     */
    public function editAction($id,Request $request)
    {
       /* $s = $this->get('store.client');
        $request = $s->get('notes.json');
        $response = $request->send();
        $t = json_decode($response->getBody(true));
        $i = 0;
        $em = $this->getDoctrine()->getManager();
        $n=$response->json()['notes'][0];
        $note  = new Note();
        $note->setMessage($n["message"]);
        $note->setId(0);


        $editForm = $this->createEditForm($note);
*/
$rest= new RESTController();


         $em = $this->getDoctrine()->getManager();

         $entity = $em->getRepository('StoreAdminBundle:Producto')->find($id);
         $entity->__construct();
         $editId = $entity->getSessionid();
        if (!$entity) {
             throw $this->createNotFoundException('Unable to find Producto entity.');
         }

     /* $rest->GetData($this,'notes',$entity->getidproducto(),$entity);*/
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        /*    $entity->setSessionid($request->get('editId'));*/
            $files = $entity->UploadImages($request->get('editId'), 'C:\xampp\htdocs\store\web\uploads\tmp\attachments', $em);

            $em->persist($entity);

            foreach ($files as $file) {
                $imgprod = new ImagesProducto();
                $imgprod->setIdimage($file);
                $imgprod->setIdproducto($entity);
                $em->persist($imgprod);
            }

            $em->flush();

            $this->redirect( $this->generateUrl('producto'));
        }

         $editForm = $this->createEditForm($entity);
         $deleteForm = $this->createDeleteForm($id);
         $entity->getImageProductos($em);
        return $this->render('StoreAdminBundle:Producto:edit.html.twig', array(
             'entity' => $entity, 'editId' => $editId,
             'form' => $editForm->createView(), 'isNew' => false,
             'delete_form' => $deleteForm->createView(),
         ));/*
         return $this->render('StoreAdminBundle:Producto:edit.html.twig', array(
             'entity' => $note, 'editId' =>0,
             'form' => $editForm->createView(), 'isNew' => false,

         ));*/
    }

    /**
     * Creates a form to edit a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Producto $entity)
    {
       $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
    /*    $form = $this->createForm(new NoteType(), $entity, array(
            'action' => $this->generateUrl('producto_update', array('id' => 0)),
            'method' => 'PUT',
        ));*/

        return $form;
    }

    /**
     * Edits an existing Producto entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
    /*    $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreAdminBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('producto_edit', array('id' => $id)));
        }

        return $this->render('StoreAdminBundle:Producto:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));*/
    }

    /**
     * Deletes a Producto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreAdminBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('producto'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     *
     * @Route("/upload", name="producto_upload")
     * @Template()
     */
    public function uploadAction()
    {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new Exception("Bad edit id");
        }

        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }

    public function  syncAction()
    {
$t = RESTController::GetData($this,'notes');
$em = $this->getDoctrine()->getManager();
        $i=0;
        foreach ($t->notes as $node) {
            $entity = $em->getRepository('StoreAdminBundle:Producto')->findBy(array('idproducto' => $i));
            if ($entity == null) {
                $p = new Producto();
                $p->setIdproducto($i);

                // echo $this->GetEditId($i);
                $p->setSessionid($this->GetEditId($i));
                $em->persist($p);
            }

            $i++;
            $em->flush();
        }
        // $v = new View()
        return $this->redirect($this->generateUrl('producto'));
    }
}
