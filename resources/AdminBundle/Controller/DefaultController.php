<?php

namespace Store\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StoreAdminBundle:Default:index.html.twig');
    }
}
