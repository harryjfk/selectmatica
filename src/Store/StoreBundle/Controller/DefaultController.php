<?php

namespace Store\StoreBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function nameAction()
    {
        $em = $this->getDoctrine()->getManager();
        $store=      $em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name'=>'Tienda'));
        $appname = $store[0]->getValueData('name');
        return $this->render('StoreStoreBundle:Default:_name.html.twig', array('app_name' =>$appname));
    }
    public function indexAction(Request $request)
    {

            \Common\AdminBaseBundle\Controller\LanguagesController::checkdefaultEnabled($this);
if($this->getUser()->getidCliente()==null && !$this->getUser()->isComercial())
    return $this->render('@StoreStore/Default/missing_id.twig');
      return $this->redirect($this->generateUrl('store_start'));
    }
    public function startAction(Request $request)
    {

        if($this->getUser()->isComercial())
        return    $this->redirect($this->generateUrl('seguridad_control'));
        return $this->render('StoreStoreBundle:Default:_start.html.twig',ProductoController::getDestacados($this));
    }
    public function apiAction(Request $request)
    {

        return $this->render('StoreStoreBundle:Default:api.html.twig');
    }
}
