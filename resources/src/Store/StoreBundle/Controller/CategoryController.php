<?php

namespace Store\StoreBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Store\StoreBundle\Entity\Category;
use Store\StoreBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction(Request $request)
    {
        $params = null;

        $count=$request->get('dataTables_length');
        $filter=$request->get('dataTables_filter');
        if($filter!=null) {
            $params  = new ArrayCollection();
            $params->add(new Parameter('param','%'.$filter.'%'));
            $filter = 'a.name LIKE :param';
        }

        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Category',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);
        return $this->render('StoreStoreBundle:Category:index.html.twig', array(
            'entities' => $entities
        ));


    }
    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
        }

        return $this->render('StoreStoreBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

     /*   $form->add('submit', 'submit', array('label' => 'Create'));*/

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);

        return $this->render('StoreStoreBundle:Category:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),'isNew'=>true
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreStoreBundle:Category:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction(Request $request ,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $src=   $this->container->getParameter('upload_temp_dir');
        $dest = $this->container->getParameter('upload_images_dir');
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $entity->UploadImages($src, $dest, $em);
            $em->flush();
            return $this->redirect($this->generateUrl('category_list'));
        }
            $entity->PrepareTempFolder($src,$dest);
        return $this->render('StoreStoreBundle:Category:edit.html.twig', array(
            'entity'      => $entity,'isNew'=>false,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(), 'url'=>  $this->container->getParameter('file_uploader.web_base_path')
        ));
    }

    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

     /*   $form->add('submit', 'submit', array('label' => 'Update'));*/

        return $form;
    }
    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);


        $src=   $this->container->getParameter('upload_temp_dir');
        $dest = $this->container->getParameter('upload_images_dir');
        if ($editForm->isValid()) {
            $entity->UploadImages( $src,$dest, $em);
            $em->flush();

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return $this->render('StoreStoreBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
      /*  $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('StoreStoreBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
       /* }*/

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
           /* ->add('submit', 'submit', array('label' => 'Delete'))*/
            ->getForm()
        ;
    }
    public  function  syncAction()
    {
        ProductoController::Syncronize($this);
        return $this->redirect($this->generateUrl('category_list'));
    }
    public  function  navAction()
    {
           $em = $this->getDoctrine()->getManager();
        $options = $em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name'=>'Categorías'))[0];
        $arr= array('section'=>$options->getValueData('section')=='on','family'=>$options->getValueData('family')=='on','subfamily'=>$options->getValueData('subfamily')=='on');

        $entities = $em->getRepository('StoreStoreBundle:Category')->setData(ProductoController::getData($this))->findNav($arr['section'],$arr['family'],$arr['subfamily']);

         return $this->render(
            'StoreStoreBundle:Category:nav.html.twig',
            [
               /* 'currentCategory' => $currentCategory,*/
                'categoryTree'    => $entities,'data'=>$arr

            ]
        );

    }

    public  function  productsAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('StoreStoreBundle:Category')->setData(ProductoController::getData($this))->find($id);

           if($entities==null)
           {
               return new Response("error");
           }
           $e = new ArrayCollection();
            $entities->getAllProductos($e);
           $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->getArticulos($e);


           $w =$entities->getAllParent();
           return $this->render(
               'StoreStoreBundle:Producto:view.html.twig',
               [
'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this),
                   'products'    =>$e ,'base_dir'=>$this->container->getParameter('upload_images_web'),'category'=>$entities,'tree'=>$w,

               ]);

    }
    public  function breadAction($id)
    {
        $em = $this->getDoctrine()->getManager();
         $category = $em->getRepository('StoreStoreBundle:Category')->find($id);

    //  $this->render()



    }
}
