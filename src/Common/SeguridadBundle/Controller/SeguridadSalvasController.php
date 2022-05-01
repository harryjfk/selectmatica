<?php

namespace Common\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Common\SeguridadBundle\Entity\SeguridadSalvas;
use Common\BandecBundle\Util\ValidationsUtil;
use Common\BandecBundle\Util\UploadUtil;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * SeguridadSalvas controller.
 *
 */
class SeguridadSalvasController extends Controller {

    /**
     * Lists all SeguridadSalvas entities.
     *
     */
    public function indexAction(Request $request) {

        if (!$this->get('security.context')->isGranted('ROLE_SALVAS_VIEW')) {
            throw new AccessDeniedException();
        }

        $fini = $request->get('fini');
        $ffin = $request->get('ffin');

        if (!ValidationsUtil::DateLessThanOrEqual($fini, $ffin)) {
            $this->addFlash('alert alert-danger', $trans->trans('fecha_inicio_mayor_fin', array(), 'validators'));
            $fini = '';
            $ffin = '';
        }

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');


        $params = array(
            'ffin' => $ffin,
            'fini' => $fini
        );

        $entities = $paginator->paginate(
                $em->getRepository('SeguridadBundle:SeguridadSalvas')->queryResult($params), $request->query->getInt('page', 1), $this->container->getParameter('bandec.pagination.items_per_page')
        );

        //$entities = $em->getRepository('SeguridadBundle:SeguridadSalvas')->findAll();

        return $this->render('SeguridadBundle:SeguridadSalvas:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function newSalvaAction(Request $request) {

        $isAjax = $request->isXmlHttpRequest();
        $json = array('status' => 1, 'stringError' => '');
        if (!$this->get('security.context')->isGranted('ROLE_SALVAS_CREATE')) {
            if (!$isAjax) {
                throw new AccessDeniedException();
            } else {
                $json['status'] = 2;
                return new Response(json_encode($json));
            }
        }
        $nameFile = uniqid() . '.sql';
        $stringDump = sprintf("%s -u %s %s --opt %s > %s", $this->getParameter('bandec.ruta_mysqldump'), $this->getParameter('database_user'), $this->getParameter('database_password') ? '-p ' . $this->getParameter('database_password') : '', $this->getParameter('database_name'), UploadUtil::getPathFiles() . $nameFile
        );
        system($stringDump);

        $entity = new SeguridadSalvas();
        $entity->setFechaSalva(new \DateTime());
        $entity->setNombreFichero($nameFile);
        $entity->setIdusuario($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
        return new Response(json_encode($json));
    }

    public function downloadAction($id) {
        $context = $this->get('security.context');
        if (!$context->isGranted('ROLE_SALVAS_VIEW')) {

            throw new AccessDeniedException();
        }

        $salva = $this->getDoctrine()->getManager()->getRepository('SeguridadBundle:SeguridadSalvas')->findOneBy(array('id' => $id));
        if (!$salva)
            throw $this->createNotFoundException();

        $filename = UploadUtil::getPathFiles() . $salva->getNombreFichero();
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($salva->getNombreFichero()) . '";');
        $response->headers->set('Content-length', filesize($filename));

        // Send headers before outputting anything
        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));
        return $response;
    }

}
