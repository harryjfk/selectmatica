<?php

namespace Store\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Store\RestBundle\Types;
class DefaultController extends Controller
{
    private static function getAuthorization($user,$pass){
        $consumer_key = $user;
        $consumer_secret = $pass;

        $authString = $consumer_key . ':' . $consumer_secret;
        $authStringEnc = 'Basic ' .base64_encode($authString);
        return $authStringEnc;
    }
	 private static function CallAPI($method, $url,$user,$pass, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":

                if ($data)
                {
                       curl_setopt($curl, CURLOPT_POST, count($data));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                else
                    curl_setopt($curl, CURLOPT_POST, 1);


                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        $headers = array('Content-Type: application/json',"Authorization: ".DefaultController::getAuthorization($user,$pass));

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        $r = $result;
 // echo $r;
        curl_close($curl);

        return $r;
    }

    public static  function GetRest($controller,$url,$data,$method)
    {$url =   $controller->container->getParameter('default_api_url').$url;

       $user=        $controller->container->getParameter('default_api_username');
        $pass=         $controller->container->getParameter('default_api_password');

	 if(strtolower ($method)=='post')
		 return DefaultController::CallAPI($method,$url,$user,$pass,$data);
	 else
		 
       return  json_decode(DefaultController::CallAPI($method,$url,$user,$pass,$data));

    }
    public function indexAction()
    {
        \Doctrine\DBAL\Types\Type::addType('ajson', 'Store\RestBundle\Types\AJsonType');

	//  echo json_encode( DefaultController::GetRest($this,"/articulos?web=true&baja=false",false,'GET'));

    //    echo json_encode(\Doctrine\DBAL\Types\Type::getTypesMap());
        $em  = $this->getDoctrine()->getManager('rest');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('string', 'ajson');

        $p = $em->getRepository('StoreRestBundle:Articulos')->find(1020);

        //echo $p->getPreciosEspeciales()->count();
		//echo $t->count;
        /*return $this->render('StoreRestBundle:Default:index.html.twig', array('name' => $name));*/
    }

}
