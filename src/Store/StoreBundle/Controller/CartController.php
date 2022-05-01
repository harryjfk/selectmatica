<?php

namespace Store\StoreBundle\Controller;



use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Store\RestBundle\Entity\Clientes;
use Store\StoreBundle\Entity\Cartline;
use Store\StoreBundle\Form\CartlineType;
use Store\StoreBundle\Form\CartType;
use Store\StoreBundle\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Store\StoreBundle\Entity\Cart;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPPdf\Core\FacadeBuilder;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Cart controller.
 *
 */
class CartController extends Controller
{


    /**
     * Lists all Cart entities.
     *
     */


    public function SendRequest(Cart $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $v = $em->getRepository('CommonAdminBaseBundle:Options')->findOneBy(array('name'=>'Vendedor'));
         $v =$v->getValueData('id');

        \Common\SeguridadBundle\Controller\DefaultController::getData($this);
      /*  $s = $em->getRepository('CommonAdminBaseBundle:Options')->findOneBy(array('name'=>'Serie'));
        $s =$s->getValueData('default');*/
        $data = json_encode($entity->getAsPedido($v,''));
      //  echo $data;
  return    \Store\RestBundle\Controller\DefaultController::GetRest($this,"pedidos/store",$data,'POST');
   }
   private  function getparams()
  {
    return array('iduser'=>$this->getUser()->getId(),'ordered'=>false);
  }
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->findBy($this->getparams());


        // $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Cart',$request->query->getInt('page', 1),$this->container);
       if(count($entity)==0)
           $entity = new Cart();
           else

        $entity = $entity[0];
           $form   = $this->createCreateForm($entity);

        $form->handleRequest($request);
        \Common\SeguridadBundle\Controller\DefaultController::BindCliente($this,$this->getUser());
//-----
	
		
		
		
//------		

	     if ($form->isValid()) {

           $sended = array('response' => 1);
          	 $mail = $em->getRepository('CommonAdminBaseBundle:Options')->findOneBy(array('name' => 'E-Mail'));

             if ($mail != null) {

                 $attach=$this->getPdf($entity->getId()); //binary
                 $w=\Swift_Attachment::newInstance($attach, 'Pedido.pdf','application/pdf');
                 $store = $em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name' => 'Tienda'));
                 $app_file = $this->container->getParameter('options_upload_web').$store[0]->getValueData('file');
                 $app_name = $store[0]->getValueData('name');
                 $app_text = $store[0]->getValueData('mail_text');

                 $app_text = str_replace('user_name',$this->getUser()->getNombreCompleto(),$app_text);
				 $body = $this->renderView(
'@StoreStore/Cart/mail.html.twig',
array('app_name' => $app_name,'app_img' =>$app_file,'app_text' => $app_text)
);
               $message = \Swift_Message::newInstance()
->setSubject('Tienda')
->setFrom($mail->getValueData('email'))
 ->setTo($this->getUser()->getEmail())->setCc($mail->getValueData('email'))
				   ->setBody(strip_tags($body))
->addPart($body, 'text/html')
->attach($w);

$t= $this->get('mailer')->send($message);
				
                 $sended['response'] =$t;
                 $sended['error']='';
             }


             if ($sended['response'] == 0)

                 $form->addError(new FormError($this->get('translator')->trans('order.mailsenderror') . $sended["error"]));
             else {

                 $id = $this->SendRequest($entity);

                 $ex = strpos($id, 'Excepción');
                 if ($ex === false) {

                     $entity->setClave($id);
                     $entity->setDate(new \DateTime());
                     $em->persist($entity);

                     $entity->setOrdered(true);
                     $em->flush();


                    return $this->redirect($this->generateUrl('cart_finished', array('id' => $entity->getId())));
                 } else
                     $form->addError(new FormError($this->get('translator')->trans('cart.send.error')));

             }
           return $this->redirect($this->generateUrl('cart_finished',array('id'=>$entity->getId())));

             //
         }
        $view = $form->createView();

          return $this->render('StoreStoreBundle:Cart:index.html.twig', array(
            'entities' => $entity, 'form'=>$view,'base_dir'=>$this->container->getParameter('upload_images_web'),'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)
        ));
    }

    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->findBy($this->getparams());


        // $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Cart',$request->query->getInt('page', 1),$this->container);
        if(count($entity)==0)
            $entity = new Cart();
        else

            $entity = $entity[0];

        $form   = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($entity);
            $em->flush();

        }
        $view = $form->createView();

        return $this->render('StoreStoreBundle:Cart:index.html.twig', array(
            'entities' => $entity, 'form'=>$view,'base_dir'=>$this->container->getParameter('upload_images_web'),'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)
        ));
    }


    /**
     * Finds and displays a Cart entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cart')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cart entity.');
        }

        return $this->render('StoreStoreBundle:Cart:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
    public function navAction()
    {

if($this->isGranted('ROLE_FACTURAS_VIEW'))
    return new Response();
        $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->findBy($this->getparams());

            if (count($entity)==0)
                $entity = new Cart();
            else
                $entity = $entity[0];


     return   $this->render('@StoreStore/Cart/nav.html.twig',array('cart'=>$entity,'base_dir'=>$this->container->getParameter('upload_images_web'),'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));
    }
    private function createCreateForm(Cart $entity)
    {
        $form = $this->createForm(new CartType(), $entity, array(
            'action' => $this->generateUrl('cart_view'),
            'method' => 'POST',
        ));

       //    $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
 public function checkEmptyCart()
 {

     $em = $this->getDoctrine()->getConnection()->getWrappedConnection();
     $stmt = $em->prepare('DELETE cart FROM cart LEFT JOIN cartline ON cartline.idcart = cart.id
WHERE cartline.id IS NULL
');
     $stmt->execute();
    /* $carts = $query->ex();
     foreach($carts as $cart)
         $em->remove($cart);
     $em->flush();*/
 }
    public function listAction(Request $request,$profile =false)
    {
        $this->checkEmptyCart();
        $params=null;   $count=$request->get('dataTables_length');
        $filter=$request->get('dataTables_filter');
        $params = new ArrayCollection();
      if($filter!='')
      {

          $params->add(new Parameter('clave','%'.$filter.'%'));
          $filter = "a.clave LIKE :clave";


      }

        if($profile==true)
        {

            $params->add(new Parameter('user',$this->getUser()->getId()));
            if($filter!='')
                $filter.=' and ';
            $filter .= " a.iduser = :user";
        }

        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Cart',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);


        $rep =$this->getDoctrine()->getManager()->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->getArticulos($entities);


        $privs = array('new'=>false,'delete'=>false &&!$profile,'edit'=>true);
        if($profile)
            return   $this->render('@StoreStore/Cart/list_profile.html.twig',array('entities'=>$entities,'priviligies'=>$privs,'profile'=>$profile,'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));

else
        return   $this->render('@StoreStore/Cart/list.html.twig',array('entities'=>$entities,'priviligies'=>$privs,'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));

    }
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $json = array('status' => 1);
        $listIds = $request->get('idcheck', array());
        $json['ids']= array();
        $haeliminado = false;
        foreach ($listIds as $id) {
            $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->find($id);


            if ($entity) {
                try {
                    $em->remove($entity);
                    $json['ids'][] = $id;
                    $em->flush();
                    $haeliminado = true;
                } catch (\Exception $e) {
                    $json['status'] = 0;
                }
            }
        }
        $trans = $this->get('translator');
        if (!$haeliminado) {


            $json['status'] = 0;
        } else {
            $this->addFlash('alert alert-success', $trans->trans('js_eliminados_correctamente', array(), 'messages'));
        }

        return new Response(json_encode($json));
    }
    public function viewAction(Request $request,$id)
    {
       $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->find($id);
        $form   = $this->createCreateForm($entity);

        $form->handleRequest($request);


          $view = $form->createView();

           return $this->render('StoreStoreBundle:Cart:view.html.twig', array(
               'entities' => $entity, 'form'=>$view,'base_dir'=>$this->container->getParameter('upload_images_web'),'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)
           ));
    }
    /**
     * @Pdf()
     */
    public function getPdf($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->find($id);
        $em = $this->getDoctrine()->getManager();
        $store = $em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name' => 'Tienda'));
        $app_file = $this->container->getParameter('options_upload_web').$store[0]->getValueData('file');
        $app_name = $store[0]->getValueData('name');
        $app_resp = $store[0]->getValueData('resp');
        $app_cif = $store[0]->getValueData('cif');
        $app_resp2 =$store[0]->getValueData('resp1');
        $app_telf = $store[0]->getValueData('phone');
        $app_mail = $store[0]->getValueData('mail');
        $app_dir = $store[0]->getValueData('address');
        $form = $this->createCreateForm($entity);
     /*   $form->handleRequest($request);
*/
        $view = $form->createView();

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        /*  return $this->render('StoreStoreBundle:Cart:pdf.html.twig', array(
              'entities' => $entity, 'app_file' => $app_file, 'form' => $view, 'base_dir' => $this->container->getParameter('upload_images_web'), 'dir' => $this->container->getParameter('server_dir'), 'tarifa' => \Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));
     */

        $content = $this->render('StoreStoreBundle:Cart:pdf.html.twig', array(
        'entities' => $entity, 'app_file' => $app_file,'app_dir' => $app_dir,'app_name' => $app_name,'app_resp' => $app_resp,'app_cif' => $app_cif,'app_resp2' => $app_resp2,'app_telf' => $app_telf,'app_mail' => $app_mail, 'form' => $view, 'base_dir' => $this->container->getParameter('upload_images_web'), 'dir' => $this->container->getParameter('server_dir'), 'tarifa' => \Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)), $response);

        $xml = $response->getContent();
        $styles = $this->render('StoreStoreBundle:Cart:pdf_styles.html.twig', array(), $response);
      return $facade->render($xml, $styles->getContent());

    }

    public function pdfAction($id)
    {
        //$this->get('knp_snappy.pdf')->generate('http://localhost', '/path/to/the/file.pdf');

        $content =$this->getPdf($id);


        $response = new Response($content, 200, array('Content-Type' => 'application/pdf',
          ));
        return $response;

    }
    public function add_toAction(Request $request,$id,$cant)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->findBy($this->getparams());

        if (count($entity)==0) {
            $entity = new Cart();
            $now = new \DateTime();
            $entity->setIduser($this->getUser()->getId());
            $entity->setDate( $now);
            $entity->setOrdered(0);
            $em->persist($entity);

        }
        else
            $entity = $entity[0];
        $exists = $em->getRepository('StoreStoreBundle:Cartline')->setData(ProductoController::getData($this))->findBy(array('idcart'=>$entity->getId(),'idproducto'=>$id));
        if(count($exists)==0)
        {
        $line = new Cartline();
        $line->setIdcart($entity);
        $product = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);
        $line->setIdproducto($product);


        $line->setCantidad($cant);
            $em->persist($line);

        }
        else
        {
            $exists[0]->setCantidad($exists[0]->getCantidad()+$cant);
            $em->persist($exists[0]);

        }

         $em->flush();
        return   $this->redirect( $this->generateUrl('cart_view'));
    }
    public function finishedAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->find($id);
        return $this->render('StoreStoreBundle:Cart:finished.html.twig',array('cart'=>$cart));
    }
    public function emptyAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->findBy($this->getparams());



        // $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Cart',$request->query->getInt('page', 1),$this->container);
        if(count($cart)==0)
            $cart = new Cart();
        else
        $cart = $cart[0];

        $form = $this->createCreateForm($cart);
        foreach($cart->getLines() as $line)
        $em->remove($line);
        $em->persist($cart);
        $em->flush();
        return $this->render('StoreStoreBundle:Cart:index.html.twig',array('entities'=>$cart,'form'=>$form->createView()));
}

    public function graphAction($profile)
    {

        $em = $this->getDoctrine()->getManager();
        $options = $em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name'=>'Gráficos'))[0];
        $from = $options->getValueData('from');
        $to = $options->getValueData('to');
        $colors= array();
        for($i=0;$i<255;$i++)
            array_push($colors,$i);
        $global=null;
        $seccion=null;
        $familia=null;
        $subfamilia=null;
        $t = $profile;

        if($profile==="true"||$profile==="1")
        {
           $t = "true";
            $profile = $this->getUser()->getId();
        }

        else
            $profile ="false";

        if($t==="true"||$t==="2"||$t==="false" )
       $global= $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->getComprasGraph($profile,$from,$to);
        if($t==="true"||$t=="3"||$t==="false")
      $seccion= $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->getCategoryGraph($profile,$from,$to,1);
        if($t==="true"||$t=="4"||$t==="false")
      $familia= $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->getCategoryGraph($profile,$from,$to,2);
        if($t==="true"||$t=="5"||$t==="false")
    $subfamilia= $em->getRepository('StoreStoreBundle:Cart')->setData(ProductoController::getData($this))->getCategoryGraph($profile,$from,$to,3);

       if($t==="true")
           return $this->render('@StoreStore/Cart/graph_profile.html.twig',array('global'=>$global,'colors'=>$colors,'seccion'=>$seccion,'familia'=>$familia,'subfamilia'=>$subfamilia));
else
        return $this->render('@StoreStore/Cart/graph.html.twig',array('global'=>$global,'colors'=>$colors,'seccion'=>$seccion,'familia'=>$familia,'subfamilia'=>$subfamilia));


    }
}