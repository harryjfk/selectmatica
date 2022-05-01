<?php

namespace Common\AdminBaseBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Common\AdminBaseBundle\Entity\Options;
use Symfony\Component\HttpFoundation\Request;

/**
 * Options controller.
 *
 */
class OptionsController extends Controller
{

    /**
     * Lists all Options entities.
     *
     */
    public function indexAction(Request $request,$view =false)
    {


        $params = null;

        $count=$request->get('dataTables_length');
        $filter=$request->get('dataTables_filter');
        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'CommonAdminBaseBundle:Options',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);
        $privs = array('new'=>false,'delete'=>false,'edit'=>true);
        if($view)
            return $this->render('CommonAdminBaseBundle:Options:view.html.twig', array(
                'entities' => $entities,'priviligies'=>$privs,'controller'=>$this
            ));
        else
        return $this->render('CommonAdminBaseBundle:Options:index.html.twig', array(
            'entities' => $entities,'priviligies'=>$privs,
        ));
    }

    /**
     * Finds and displays a Options entity.
     *
     */

    public function showAction(Request $request,$id,$view =false)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CommonAdminBaseBundle:Options')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Options entity.');
        }

        if($request->request->count()>0)
        {

            $entity->handleRequest($request);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('options_list',array('view'=>$view)));
        }
$trans= $this->get('translator');
       return $this->render('CommonAdminBaseBundle:Options:show.html.twig', array(
            'entity'      => $entity, 'translator'=>$trans,'controller'=>$this,'view'=>$view,'base_dir'=>$this->container->getParameter('options_upload_web')
        ));
    }
}
