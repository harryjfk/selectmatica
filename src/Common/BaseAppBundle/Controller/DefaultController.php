<?php

namespace Common\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CommonBaseAppBundle:Default:index.html.twig', array('name' => $name));
    }
    public function error500Action()
    {
        return $this->render('CommonBaseAppBundle:Default:500.html.twig');
    }
    public function error400Action()
    {
        return $this->render('CommonBaseAppBundle:Default:400.html.twig');
    }
    public function languageAction(Request $request,$lang)
    {
       $request->getSession()->set('_locale',$lang);
       return $this->redirect($this->generateUrl('store_homepage'));
    }
}
