<?php

namespace Common\AdminBaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {


        return $this->render('CommonAdminBaseBundle:Default:index.html.twig', array('name' => $name));
    }
    public static function DefaultPriv()
    {
        return array('new'=>true,'delete'=>true,'edit'=>true);
    }

}
