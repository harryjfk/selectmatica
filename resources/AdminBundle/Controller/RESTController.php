<?php
namespace Store\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\Serializer;

class RESTController
{
    public static  function GetData(Controller $controller,$dir, $index=null,$object=null)
    {
        $realdir = $dir;
        if($index!=null)
            $realdir.='/'.$index;
        $s = $controller->get('store.client');
        $request = $s->get($realdir.'.json');
        $response = $request->send();
$json =$response->getBody(true);

   if($index==null)
return json_decode($json);
        else
            if($object!=null)
            {
                $serializer = Serializer\SerializerBuilder::create()->build();
                $object = $serializer->deserialize($json, 'Store\AdminBundle\Entity\Producto', 'json');

               return $object;
            }
    }
}