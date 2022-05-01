<?php

namespace Common\AdminBaseBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Common\AdminBaseBundle\Entity\Languages;
use Common\AdminBaseBundle\Form\LanguagesType;

/**
 * Languages controller.
 *
 */
class LanguagesController extends Controller
{

    /**
     * Lists all Languages entities.
     *
     */
    public function indexAction(Request $request)
    {

        $params = null;
        $count=$request->get('dataTables_length');
        $filter=$request->get('dataTables_filter');
        if($filter!='')
        {
            $params = new ArrayCollection();
            $params->add(new Parameter('name','%'.$filter.'%'));
            $filter = 'a.name LIKE :name';

        }
$em = $this->getDoctrine()->getEntityManager();
        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'CommonAdminBaseBundle:Languages',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);
        $primary =LanguagesController::getPrimary($em);
        $priv= array('new'=>false,'delete'=>false,'edit'=>true);
        return $this->render('CommonAdminBaseBundle:Languages:index.html.twig', array(
            'entities' => $entities,'priviligies'=>$priv, 'base_dir'=>$this->container->getParameter('file_uploader.web_base_path').'languages/','primary'=>$primary
        ));
    }
    public static function getPrimary(EntityManager $controller,$value=null)
    {
        $em = $controller;
        $t = $em->getRepository('CommonAdminBaseBundle:Options')->find(2);

        if($value!=null)
           if($value['value']==true)
               $t->setColumnData('default',$value['id']);
      return $t->getValueData('default');

    }
    /**
     * Creates a new Languages entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Languages();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('languages_show', array('id' => $entity->getId())));
        }

        return $this->render('CommonAdminBaseBundle:Languages:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Languages entity.
     *
     * @param Languages $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Languages $entity)
    {
        $form = $this->createForm(new LanguagesType(), $entity, array(
            'action' => $this->generateUrl('languages_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Languages entity.
     *
     */
    public function newAction()
    {
        $entity = new Languages();
        $form   = $this->createCreateForm($entity);

        return $this->render('CommonAdminBaseBundle:Languages:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Languages entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonAdminBaseBundle:Languages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Languages entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('CommonAdminBaseBundle:Languages:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),'controller'=>$this
        ));
    }

    /**
     * Displays a form to edit an existing Languages entity.
     *
     */

    public function editAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonAdminBaseBundle:Languages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Languages entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $primary = $request->get('primary');
            $r = array();
            if ($primary == null)

                $r['value'] = false;
            else
                $r['value'] = true;
            $r['id']=$entity->getId();
            LanguagesController::getPrimary($em, $r);
            $entity->preUpload();
            $em->persist($entity);

            $entity->upload();
           $em->flush();


            return $this->redirect($this->generateUrl('languages'));
        }
        $primary =   $primary =LanguagesController::getPrimary($em);

        return $this->render('CommonAdminBaseBundle:Languages:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(), 'base_dir'=>$this->container->getParameter('file_uploader.web_base_path').'languages/',
            'isNew'=>false,'primary'=>$primary
        ));
    }

    /**
    * Creates a form to edit a Languages entity.
    *
    * @param Languages $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Languages $entity)
    {
        $form = $this->createForm(new LanguagesType(), $entity, array(
            'action' => $this->generateUrl('languages_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

      //  $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Languages entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonAdminBaseBundle:Languages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Languages entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('languages_edit', array('id' => $id)));
        }

        return $this->render('CommonAdminBaseBundle:Languages:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Languages entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CommonAdminBaseBundle:Languages')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Languages entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('languages'));
    }

    /**
     * Creates a form to delete a Languages entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('languages_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    public function langNavAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities= $em->getRepository('CommonAdminBaseBundle:Languages')->findAll();
        return $this->render('@CommonAdminBase/Default/_language_nav.html.twig',array('entities'=>$entities,'base_dir'=>$this->container->getParameter('file_uploader.web_base_path').'languages/',));
    }
    private  static function setDefault(Controller $controller)
    {
        $em = $controller->getDoctrine()->getManager();
        $default = $controller->container->getParameter('locale');


        $entities = $em->getRepository('CommonAdminBaseBundle:Languages')->findBy(array('enabled' => true, 'locale' => $default));

        if (count($entities) == 0) {
            $entities = $em->getRepository('CommonAdminBaseBundle:Languages')->findOneBy(array('enabled' => true));

            $controller->getRequest()->setLocale($entities->getLocale());
            $controller->getRequest()->getSession()->set('_locale', $entities->getLocale());
        }

    }

    public static function checkdefaultEnabled(Controller $controller)
    {

        $default = $controller->getRequest()->getSession()->get('_locale', '');
        $em = $controller->getDoctrine()->getManager();

        if($default==='')
        {

            $primary = LanguagesController::getPrimary($em);
            if ($primary != null) {
                $primary = $em->getRepository('CommonAdminBaseBundle:Languages')->find($primary);

                $controller->getRequest()->setLocale($primary->getLocale());
                $controller->getRequest()->getSession()->set('_locale', $primary->getLocale());

            }
            else
                LanguagesController::setDefault($controller);
        }
        else
            LanguagesController::setDefault($controller);


    }

}
