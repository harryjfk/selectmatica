<?php

namespace Common\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\SeguridadBundle\Entity\SeguridadTraza;

/**
 * SeguridadTraza controller.
 *
 */
class SeguridadTrazaController extends Controller {

    /**
     * Lists all SeguridadTraza entities.
     *
     */
    public function indexAction(Request $request) {

        if (!$this->get('security.context')->isGranted('ROLE_TRAZA_VIEW')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $fi_solicitud = $request->get('fini');
        $fn_solicitud = $request->get('ffin');

        if (!\Bandec\BandecBundle\Util\ValidationsUtil::DateLessThanOrEqual($fi_solicitud, $fn_solicitud)) {
            $this->addFlash('alert alert-danger', $this->get('translator')->trans('fecha_inicio_mayor_fin', array(), 'messages'));
            $fi_solicitud = '';
            $fn_solicitud = '';
        }

        $params = array(
            'usuario' => $request->get('usuario'),
            'accion' => $request->get('accion'),
            'tabla' => $request->get('tabla'),
            'fini' => $fi_solicitud,
            'ffin' => $fn_solicitud
        );

        $entities = $paginator->paginate(
                $em->getRepository('SeguridadBundle:SeguridadTraza')->queryResult($params), $request->query->getInt('page', 1), $this->container->getParameter('bandec.pagination.items_per_page')
        );

        //$entities = $em->getRepository('SeguridadBundle:SeguridadTraza')->findAll();

        return $this->render('SeguridadBundle:SeguridadTraza:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

}
