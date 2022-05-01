<?php

namespace Store\StoreBundle\Controller;

use Circle\RestClientBundle\Exceptions\CouldntResolveProxyException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Store\RestBundle\Entity\Articulos;
use Store\RestBundle\Entity\Familias;
use Store\RestBundle\Entity\PreciosEspeciales;
use Store\RestBundle\Entity\Secciones;
use Store\RestBundle\Entity\SubFamilias;
use Store\StoreBundle\Entity\Category;
use Store\StoreBundle\Entity\ProductPrecio;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Store\StoreBundle\Entity\Producto;
use Store\StoreBundle\Form\ProductoType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Producto controller.
 *
 */
class ProductoController extends Controller
{

    /**
     * Lists all Producto entities.
     *
     */

    public function indexAction(Request $request,$search=null)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $opciones =$em->getRepository('CommonAdminBaseBundle:Options')->findBy(array('name'=>'Categorías'))[0];
        $ops = $opciones->getValueData('section');

        $opf = $opciones->getValueData('family');

        $opsf = $opciones->getValueData('subfamily');
        $params = new ArrayCollection();

       $searchobj = null;
        if($search=="null")
        {
            $count=$request->get('dataTables_length');
            $codigo=$request->get('codigo');
            $producto=$request->get('producto');
            $seccion=$request->get('seccion');
            $familia=$request->get('familia');
            $subfamilia=$request->get('subfamilia');
        }
        else
        {
            $searchobj=array();
            parse_str($search,$searchobj);
            $count=$searchobj['dataTables_length'];
            $codigo=$searchobj['codigo'];
            $producto=$searchobj['producto'];
           $seccion=null;
            if(array_key_exists('seccion',$searchobj))
            $seccion=$searchobj['seccion'];
            $familia=null;
            if(array_key_exists('familia',$searchobj))
            $familia=$searchobj['familia'];
            $subfamilia=null;
            if(array_key_exists('subfamilia',$searchobj))
            $subfamilia=$searchobj['subfamilia'];

        }

        $filter=$codigo!=null || $producto!=null || $seccion !=null || $familia!=null || $subfamilia!=null;
        if($filter==true) {
            $array=array('codigo'=>$codigo,'producto'=>$producto,'seccion'=>$seccion,'familia'=>$familia,'subfamilia'=>$subfamilia,);
            if($ops=='off')
                $array['seccion']=null;
            if($opf=='off')
                $array['familia']=null;
            if($opsf=='off')
                $array['subfamilia']=null;
            $filter = $this->getFilter($array,true);
            if($filter->count()==0)
                $filter=' 0 = -1 ';
            else
            {

                $t = '';
                for($i=0;$i<$filter->count();$i++)
                {
                    $t.= ' a.idproducto = :p'.$i.' ';
                   $param = new Parameter('p'.$i,$filter[$i]->getIdproducto());
                       $params->add($param);

                    if($i<$filter->count()-1)
                       $t.=' OR ';
                }

           $filter =$t;
            }

        }

        $entities  = $this->get('store.paginator_aware')->ExecutePagination($this,'StoreStoreBundle:Producto',$request->query->getInt('page', 1),$this->container,$count,$filter,$params);
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->getArticulos($entities);


         return $this->render('StoreStoreBundle:Producto:index.html.twig', array(
            'entities' => $entities,'ops'=>$ops=="on",'opf'=>$opf=="on",'opsf'=>$opsf=="on",'search'=>$searchobj
        ));
    }
    private function getFilter($array,$admin)
    {
        if($admin==true)
        {
            $params =null;
            $res = $this->getDoctrine()->getManager();
            $temp1 = $res->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->findAll();

            $temp = new ArrayCollection();
                foreach($temp1 as $t1)
                {

                    $t = $t1->getProducto();
                    $cod = true;
                    if($array['codigo']!=null)
                        $cod =strpos(strtolower( $t->getId()),strtolower($array['codigo']))!==false || strpos(strtolower($t->getId2()),strtolower($array['codigo']));
                    $producto = true;
                    if($array['producto']!=null)
                        $producto =(
                            strpos(strtolower($t->getNombre()),strtolower($array['producto']))!==false ||

                            strpos(strtolower($t->getObservaciones()),strtolower($array['producto']))!==false ||
                            strpos(strtolower($t->getDescripcion()),strtolower($array['producto']))!==false

                        );
                    $seccion = true;
                    if($array['seccion']!=null)
                        $seccion =strpos(strtolower( $t1->getIdCategory()->getParentByLength(1)->getName()),strtolower($array['seccion']))!==false ;
                    $familia = true;
                    if($array['familia']!=null)
                        $familia =strpos(strtolower( $t1->getIdCategory()->getParentByLength(2)->getName()),strtolower($array['familia']))!==false ;
                    $subfamilia = true;
                    if($array['subfamilia']!=null)
                        $subfamilia =strpos(strtolower( $t1->getIdCategory()->getParentByLength(3)->getName()),strtolower($array['subfamilia']))!==false ;

                    if($cod && $producto&& $seccion&& $familia&& $subfamilia)
                        $temp->add($t1);
                }
            return $temp;

        }
        else
        {
       $params =null;
        $res = $this->getDoctrine()->getManager();
        $temp1 = $res->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->findAll();

            $temp = new ArrayCollection();
        if($array['nombre']==null)
            $temp =$temp1;
        else

            foreach($temp1 as $t1)
            {

                $t = $t1->getProducto();
                if(strpos(strtolower( $t->getId()),strtolower($array['nombre']))!==false ||
                    strpos(strtolower($t->getNombre()),strtolower($array['nombre']))!==false ||
                    strpos(strtolower($t->getId2()),strtolower($array['nombre']))!==false ||
                    strpos(strtolower($t->getObservaciones()),strtolower($array['nombre']))!==false ||
                    strpos(strtolower($t->getDescripcion()),strtolower($array['nombre']))!==false

                )
                    $temp->add($t1);
            }
        if(array_key_exists('range',$array))
        if($array['range']!='')
        {
           $r =  explode(';',$array['range']) ;
            $start = $r[0];
            $end =  $r[1];
            $tarifa = \Common\SeguridadBundle\Controller\DefaultController::getTarifa($this);
            $temp1 = $temp;
            $temp = new ArrayCollection();
            foreach($temp1 as $t1)
            {
                $t = $t1->getProducto();
                $p=$t->getPrice($tarifa,1);
                if( $p>=$start && $p<=$end)
                    $temp->add($t1);

            }
        }
            return $temp;
        }

    }


    /**
     * Creates a new Producto entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('producto_show', array('id' => $entity->getId())));
        }

        return $this->render('StoreStoreBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     */
    public function newAction()
    {
        $entity = new Producto();
        $form = $this->createCreateForm($entity);

        return $this->render('StoreStoreBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Producto entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StoreStoreBundle:Producto:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     */

    public function editAction(Request $request, $id)
    {
        $forms=$request->request->all();
       //parse_str

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }
        $editForm = $this->createEditForm($entity);

        $originals = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database


        $editForm->handleRequest($request);




        $src=   $this->container->getParameter('upload_temp_dir');
        $dest = $this->container->getParameter('upload_images_dir');



        if ($editForm->isValid()) {
            $entity->UploadImages( $src,$dest, $em);





            $em->persist($entity);
            $em->flush();
if($entity->getHeadimg()!=null)
            try
            {

                $t=($entity->getHeadimg()->getId());
                if($t!=null)
               $t =  $em->getRepository('StoreStoreBundle:ImagesProducto')->find($t); if(
                $t==null            )
            {
                $entity->setHeadimg(null);
                $em->persist($entity);
                $em->flush();
            }
            }catch (\Exception $e){
                $entity->setHeadimg(null);
                $em->persist($entity);
                $em->flush();
            }


           return $this->redirect($this->generateUrl('producto_list',array('search'=>$request->request->get("search"))));
        }
        $entity->PrepareTempFolder($src,$dest);


          return $this->render('StoreStoreBundle:Producto:edit.html.twig', array(
               'entity' => $entity,
               'form' => $editForm->createView(),'isNew'=>false,'search'=>$forms["frmsearch"],
               'url'=>  $this->container->getParameter('file_uploader.web_base_path')
           ));
    }

    /**
     * Creates a form to edit a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_edit', array('id' => $entity->getId())),
             /*'method' => 'GET',*/
        ));

        // $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Producto entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('producto_edit', array('id' => $id)));
        }

        return $this->render('StoreStoreBundle:Producto:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Producto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('producto'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function uploadAction($editId)
    {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new Exception("Bad edit id");
        }

        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }

    public static function getData($controller)
    {
        $cliente = -1;
        if($controller->getUser()!=null)
            $cliente = $controller->getUser()->getIdCliente();
        return array('tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($controller),'cliente'=>$cliente,'rest'=>$controller->getDoctrine()->getEntityManager('rest'),'store'=>$controller->getDoctrine()->getEntityManager());
    }
    public function view_itemAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $w =$entity->getIdcategory()->getAllParent();
        return $this->render('StoreStoreBundle:Producto:view_item.html.twig', array('producto' => $entity,'base_dir'=>$this->container->getParameter('upload_images_web'),'tree'=>$w,'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));
    }
    public static function getDestacados(Controller $controller)
    {
        $em = $controller->getDoctrine()->getManager();
        $entites = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($controller))->findBy(array('destacado'=>true));
              return array('products'=>$entites,'base_dir'=>$controller->container->getParameter('upload_images_web'),'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($controller));
    }
    public static function GetEditId($controller,$id)
    {
        $t = $controller->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $id) || $t == null) {
            $t = sprintf('%09d', mt_rand(0, 1999999999));
            if ($id) {
                $controller->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $id,
                        'to_folder' => 'tmp/attachments/' . $t,
                        'create_to_folder' => true));
            }
        }
        return $t;
    }

    private static function isValidCategory($p)
    {
        $f = false;
        $s=false;
        $sb = false;
        foreach ($p as $w)
            if($w[0]=='s')
                $s=true;
        else
            if($w[0]=='f')
                $f=true;
        else
            if($w[0]=='sbf')
            $sb = true;

        return ($f==true && $s==true && $sb==true)||($s==true && $f==true) ||($f==true && $sb==true);
    }

    private static function getCategory($articulo,EntityManager $em,EntityManager $rest,$controller,&$cantt)
    {
        $p =array();
       if($articulo->idSeccion!=null)
           $p[]=array('s',$articulo->idSeccion);
        if($articulo->idFamilia ==null)
            return null;
        $p[]=array('f',$articulo->idFamilia);
       if($articulo->idSubfamilia!=null)
           $p[]=array('sbf',$articulo->idSubfamilia);

        if(!ProductoController::isValidCategory($p))
            return null;

        $w='';
        $data = "";
      foreach ($p as $s)
        {

            if($s[0]=='s')
            {
                $w.=$rest->getRepository('StoreRestBundle:Secciones')->find($s[1])->getDescripcion();
                $data.=$s[1].'-i-1';
            }

            else
                if($s[0]=='f'){
                    $w.=$rest->getRepository('StoreRestBundle:Familias')->find($s[1])->getDescripcion();
            $data.=$s[1].'-i-2';
        }
            else
                if($s[0]=='sbf'){
                    $w.=$rest->getRepository('StoreRestBundle:SubFamilias')->find($s[1])->getDescripcion();
                    $data.=$s[1].'-i-3';
                }
            if($w!='')
             $w.='\\';
            if($data!='')
                $data.='\\';
        }


       $f= explode('\\',$w);
        $df= explode('\\',$data);
        $last = null;
        for ($i=0;$i<count($f);$i++)
            if($f[$i]!=='')
        {

          $t = $em->getRepository('StoreStoreBundle:Category')->setData(ProductoController::getData($controller))->findByLength(array('name'=>$f[$i]),$i);
            if($t==null)
            {
                $category = new Category();
                $category ->setName($f[$i]);
                $t = explode('-i-',$df[$i]);
                $category->setIdSrc($t[0]);
                $category->setTypeSrc($t[1]);
                $category->setIdparent($last);
                $category->setSessionid(ProductoController::GetEditId($controller,$category->getId()));

                $em->persist($category);
                $em->flush();
                $cantt[]=$category->getName();
                $last=$category;
            }
            else
            {

                $last=$t[0];
                if($last!=null)
                {  $t = explode('-i-',$df[$i]);
                    $last->setIdSrc($t[0]);
                    $last->setTypeSrc($t[1]);
                }

            }


        }
        return $last;




    }

    private  static function Log($string,$progress)
    {
	
        $s ='<script type="text/javascript">';
        $s.='window.parent.addLog("'.$string.'","'.$progress.'");';
		/*$s.='console.log("'.$string.'");';*/
      $s.='</script>';
		
     echo  $s;
		 echo str_pad('',4096)."\n";    
		try
		{
		if(ob_get_level()!=0)
			ob_flush(); 
    flush();
			
		}
		catch(Excepcion $e)
		{
		}
    /*    sleep(1);
        $response = array(  'message' =>$string ,
            'progress' => $progress);

        echo json_encode($response);
		 ob_flush();*/
    }
    public static function checkCategories(EntityManager $em)
    {
      $r = 0;
        $t = $em->getRepository('StoreStoreBundle:Category')->findBy(array('idparent' => null));

      foreach ($t as $s)
          if ($s->checkValid($em) == false) {
      {
        /*
        */
          $w = new ArrayCollection();
          $s->getAllProductos($w);
          $child = $em->getRepository('StoreStoreBundle:Category')->findBy(array('idparent' => $s->getId()));
 if($w->count()==0 && count($child)==0)
 {
     $em->remove($s);
     $em->flush();
 }
        }
      }


        return $r;
    }
    private static function hasId($prods,$id)
    {
     foreach ($prods as $p)
         if($p->id==$id)
             return true;
        return false;
    }
    public static function checkVisibleProds($prods,EntityManager $em)
    {
        $prds = $em->getRepository('StoreStoreBundle:Producto')->findAll();
        foreach ($prds as $p)
            if (ProductoController::hasId($prods, $p->getIdproducto()) == false) {
                $em->remove($p);
                $em->flush();
            }

    }
    public  static function Syncronize(Controller $controller)
    {
		
	header( 'Content-type: text/html; charset=utf-8' );
		header( 'Content-Encoding: none; ' );
		     set_time_limit(0);
        ob_implicit_flush(true);
		ob_end_flush();
        ob_start();


        $productos = \Store\RestBundle\Controller\DefaultController::GetRest($controller, "/articulos?web=true&baja=false", false, 'GET');

        $trans = $controller->get('translator');


        ProductoController::Log($trans->trans('product.sync.found', array('%count%' => count($productos))), 0);
        ProductoController::Log($trans->trans('product.sync.init'), 0);
  $resultp = new ArrayCollection();

        $em = $controller->getDoctrine()->getManager();
        $rest = $controller->getDoctrine()->getManager('rest');
        $cantcatt = 0;
        $cantprod = 0;
  //      $start = time();
   //     $vstart = $start;
    //    $s = 1000;
   //     echo "cantidad" . ($s * count($productos)) . '-----';
   //     for ($i = 0; $i < $s; $i++) {
           foreach ($productos as $producto)
      ///  $producto=$productos[0];
           {


                $p = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($controller))->findByEmpty(array('idproducto' => $producto->id));

                //  if(count($p)==0)
                // {
                $cantcat = array();
                $c = ProductoController::getCategory($producto, $em, $rest, $controller, $cantcat);

                $cantcatt += count($cantcat);
             //   if (count($cantcat) > 0)
             //       foreach ($cantcat as $cat)
             //          ProductoController::Log($trans->trans('product.sync.category', array('%count%' => $cat)), ($cantprod * 100) / count($productos));
                if ($c != null) {
                    if (count($p) == 0) {
                        $prod = new Producto();
                        $prod->setIdproducto($producto->id);
                        $prod->setSessionid(ProductoController::GetEditId($controller, $producto->id));

                    } else
                        $prod = $p[0];
                    $em->persist($c);
                    if($prod->getIdcategory()!=null)
                    if($prod->getIdcategory()->getId()!=$c->getId())
                    {
                        $prod->getIdcategory()->removeProducto($prod);

                    }
                    $c->addProducto($prod);
                    $prod->setIdcategory($c);

                    $em->persist($prod);
                    $cantprod += 1;
                    $resultp->add($producto);

                }

                ProductoController::Log($trans->trans('product.sync.products', array('%count%' => $producto->nombre)), ($cantprod * 100) / count($productos));

                // }



            }

        $em->flush();
      //      $end = time();
       //     echo '<div>' . $i . '-' . date("h:i:s", $end - $start) . '</div>';
      //      $start = $end;

     //   }*/
     //   $end = time();
		 ob_end_flush();
       ProductoController::checkVisibleProds($resultp,$em);



        $cantcatt+= ProductoController::checkCategories($em);

        $s = count($productos);
        if($s==0)
            $s=1;
        ProductoController::Log($trans->trans('product.sync.end', array('%prods%' => $cantprod, '%cat%' => $cantcatt)), ($cantprod * 100) /$s );
      //  echo '<div>' . date("h:i:s", $end - $vstart) . '</div>';

        echo '<script>window.parent.OnComplete();</script>';
      /*  set_time_limit(0);
        ob_implicit_flush(true);
        ob_end_flush();


        $productos =\Store\RestBundle\Controller\DefaultController::GetRest($controller,"/articulos?web=true&baja=false",false,'GET');

        $trans = $controller->get('translator');


        ProductoController::Log($trans->trans('product.sync.found',array('%count%'=> count($productos))),0);
        ProductoController::Log($trans->trans('product.sync.init'),0);


        $em = $controller->getDoctrine()->getManager();
        $rest = $controller->getDoctrine()->getManager('rest');
        $cantcatt = 0;
        $cantprod = 0;

        foreach($productos as $producto)
        {

            $p =  $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($controller))->findBy(array('idproducto'=>$producto->id));
            if(count($p)==0)
            {
                $cantcat =array();
                $c = ProductoController::getCategory($producto,$em,$rest,$controller,$cantcat);
                $cantcatt+=count($cantcat);
                if(count($cantcat>0))
                   foreach($cantcat as $cat)
                        ProductoController::Log( $trans->trans('product.sync.category',array('%count%'=> $cat))  ,($cantprod*100)/count($productos));
                   if($c!=null)
                {
                    $prod=  new Producto();
                    $prod-> setIdproducto($producto->id);
                    $prod->setIdcategory($c);

                    $prod->setSessionid(ProductoController::GetEditId($controller,$producto->id));
                    $em->persist($prod);}

                ProductoController::Log($trans->trans('product.sync.products',array('%count%'=>$producto->nombre)) ,($cantprod*100)/count($productos));

            }
            $cantprod+=1;
            $em->flush();

        }


        ProductoController::Log($trans->trans('product.sync.end',array('%prods%'=>$cantprod,'%cat%'=>$cantcatt))  ,($cantprod*100)/count($productos));
  echo '<script>window.parent.OnComplete();</script>';

*/

    }

    public function syncAction()
    {

    return new JsonResponse(  $this->Syncronize($this));
     // return $this->redirect($this->generateUrl('producto_list'));
    }
    public  function searchAction(Request $request)
    {

        $array = array('nombre'=>$request->get('nombre'),'range'=>$request->get('range'));


       $data = $this->getFilter($array,false);


        $w =$this->get('translator')->trans('product.search');

        return $this->render('StoreStoreBundle:Producto:view.html.twig',array('category'=>null,'products'=>$data,'isAdmin'=>true,'base_dir'=>$this->container->getParameter('upload_images_web'),'tree'=>$w,'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this)));
    }

    public function getImageIdAction($path)
    {
        $em = $this->getDoctrine()->getManager();
        $img= $em->getRepository('StoreStoreBundle:ImagesProducto')->findBy(array('path'=>$path));
        $array=array();
        if(count($img)>0)
            $array=array('id'=>$img[0]->getId());

        return new JsonResponse($array);
    }
    public function relatedAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('StoreStoreBundle:Producto');
        $entity = $rep->setData(ProductoController::getData($this))->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }
        $prod = $em->getRepository('CommonAdminBaseBundle:Options')->findOneBy(array('name'=>'Producto'));
        $cantmax = $prod->getValueData('default');

        $related=$entity->getRelated($cantmax);
        $rep->getArticulos($related);

        return $this->render('StoreStoreBundle:Producto:_product_list.html.twig', array(
            'related'=>true,'tarifa'=>\Common\SeguridadBundle\Controller\DefaultController::getTarifa($this),
            'products' => $related,'base_dir'=>$this->container->getParameter('upload_images_web')));

    }
    public  function max_priceAction()
    {
        if($this->getUser()->getidcliente()==null)
           $max=-1;
        else
        {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->findAll();
        $max = 0;
        $tarifa = \Common\SeguridadBundle\Controller\DefaultController::getTarifa($this);
        foreach($entities as $entity) {

            $p = $entity->getProducto()->getPrice($tarifa, 1);

            if ($p > $max ) {

                $max = $p;
            }

        }
           if($max== 99999999)
               $max= 0;
        }
        return $this->render('@StoreStore/Producto/_max_price.html.twig',array('max_price'=>round($max)));
    }
    public function frameAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity  = $em->getRepository('StoreStoreBundle:Producto')->setData(ProductoController::getData($this))->frame();

      return   $this->render('StoreStoreBundle:Producto:ext.html.twig',array('entities'=>$entity,'related'=>false,'base_dir'=>$this->container->getParameter('upload_images_web'),'tarifa'=>1));
    }
}