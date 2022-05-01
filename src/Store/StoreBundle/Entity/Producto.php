<?php

namespace Store\StoreBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
/**
 * Producto
 * @ORM\Entity(repositoryClass="Store\StoreBundle\Repository\ProductoRepository")
 */
class Producto
{
    /**
     * @var integer
     */
    private $idproducto;

    /**
     * @var integer
     */
    private $sessionid;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Images;

    /**
     * @var \Store\StoreBundle\Entity\Category
     */
    private $idcategory;

    /**
     * @var \Store\StoreBundle\Entity\ImagesProducto
     */
    private $headimg;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set idproducto
     *
     * @param integer $idproducto
     *
     * @return Producto
     */
    public function setIdproducto($idproducto)
    {
        $this->idproducto = $idproducto;

        return $this;
    }

    /**
     * Get idproducto
     *
     * @return integer
     */
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * Set sessionid
     *
     * @param integer $sessionid
     *
     * @return Producto
     */
    public function setSessionid($sessionid)
    {
        $this->sessionid = $sessionid;

        return $this;
    }

    /**
     * Get sessionid
     *
     * @return integer
     */
    public function getSessionid()
    {
        return $this->sessionid;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add image
     *
     * @param \Store\StoreBundle\Entity\ImagesProducto $image
     *
     * @return Producto
     */
    public function addImage(\Store\StoreBundle\Entity\ImagesProducto $image)
    {
        $this->Images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Store\StoreBundle\Entity\ImagesProducto $image
     */
    public function removeImage(\Store\StoreBundle\Entity\ImagesProducto $image)
    {
        $this->Images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->Images;
    }

    /**
     * Set idcategory
     *
     * @param \Store\StoreBundle\Entity\Category $idcategory
     *
     * @return Producto
     */
    public function setIdcategory(\Store\StoreBundle\Entity\Category $idcategory = null)
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * Get idcategory
     *
     * @return \Store\StoreBundle\Entity\Category
     */
    public function getIdcategory()
    {
        return $this->idcategory;
    }

    /**
     * Set headimg
     *
     * @param \Store\StoreBundle\Entity\ImagesProducto $headimg
     *
     * @return Producto
     */
    public function setHeadimg(\Store\StoreBundle\Entity\ImagesProducto $headimg = null)
    {
        $this->headimg = $headimg;

        return $this;
    }

    /**
     * Get headimg
     *
     * @return \Store\StoreBundle\Entity\ImagesProducto
     */
    public function getHeadimg()
    {
        return $this->headimg;
    }
    private function HasPath($path,$em)
    {
      $t=  $em->getRepository('StoreStoreBundle:ImagesProducto')->findBy(array('idproducto'=>$this->getId()));
        foreach($t as $w)
        {
            $q = substr($w->getPath(),0,strpos($w->getPath(),'.'));
            if(is_file($path))
            {
                $path = basename($path);
                $path = substr($path,0,strpos($path,'.'));
            }

            if($q==$path)
                return $w;

        }
        return null;

    }
    public function getImageCounter(EntityManager $em,$ext) {
        $i=0;
        $t= $this->HasPath($this->getIdproducto(),$em);

        while ($t!=null)
        {
            $i++;
            $t= $this->HasPath($this->getIdproducto().'_'.$i,$em);
        }

        return $i;
    }
    private  function  registerImage($file,$dest,$ext,$path,$entry,$em)
    {

          if(strpos($file,$this->getIdproducto())===false)
        {
            $count= $this->getImageCounter($em,$ext);
            $text = "";

            if($count!=0)
                $text="_".$count;
            $s = $this->getIdproducto().$text;
        }

        else
            $s = $file;
       $img = $this->HasPath($s,$em);
      if($img==null)
            $img = new ImagesProducto();
        if(strpos($file,$this->getIdproducto())===false)
        {
            $s.=".". $ext;
            $img->setPath($s);



              if (!file_exists($dest)) {
                  mkdir($dest, 0777, true);
              }

              copy($file, $dest.$img->getPath());


           /*   if (!file_exists($dest.'/small')) {
                  mkdir($dest.'/small', 0777, true);
              }*/
              if (!file_exists($dest.'/medium')) {
                  mkdir($dest.'/medium', 0777, true);
              }
             /* $medium = array(800,600);
              $small = array(200,100);*/


           /*   SimpleImage::Resizes($file,$dest.'/small/'.$img->getPath(),$small);*/
              SimpleImage::ResizesToHeight($file,$dest.'/medium/'.$img->getPath(),800);
              $img->setIdproducto($this);
              $em->persist($img);

            $em->flush();
            if($this->gettHeadimg()==basename($file))
                $this->setHeadimg($img);
            else
            if($this->getImages()->count()==0)
                $this->setHeadimg($img);
            }
        $em->flush();
         return $s;
    }
    private function  isPrincipal($filename)
    {
        $ext =( new \SplFileInfo($filename))->getExtension();
        $f = str_replace('.'.$ext,'',  (new \SplFileInfo($filename))->getFilename());

      return ($f==$this->getIdproducto());
    }
    public  function UploadImages($path,$dest, $em)
    {
     $principal =null;
   
        $id = $this->getSessionid();
        $t = $path . "/" . $id . '/originals/';
         $dir = dir($t);
        $i = 0;

       foreach($this->getImages() as $image)
                if(!is_file($t.$image->getpath()))
                {
                    $em->remove($image);
               /*     unlink($dest.'/small/'.$image->getPath());*/
                    unlink($dest.'/medium/'.$image->getPath());
                    unlink($dest.'/'.$image->getPath());
                }
                 //

   $i=0;
        while ($entry = $dir->read())
            if (is_file($t . $entry)) {
                $file = $t . $entry;

                $ext = strtolower( (new \SplFileInfo($file))->getExtension());
            if($ext=="jpg"|| $ext=="png")
            {
              $q=  $this->registerImage(    $file,$dest,$ext,$path,$entry,$em);


            }

              else
                  if($ext=='zip')
                  {
                      $enzipado = new \ZipArchive();

                      $enzipado->open($file);

                      $extraido = $enzipado->extractTo($path . "/" . $id."/zip/");

                             if($extraido == TRUE){
                          for ($x = 0; $x < $enzipado->numFiles; $x++) {
                              $archivo = $enzipado->statIndex($x);
                              $ext = strtolower( (new \SplFileInfo($archivo['name']))->getExtension());
                              $file=$path . "/" . $id."/zip/".$archivo['name'];
                           $q=  $this->registerImage($file,$dest,$ext,$path . "/" . $id."/zip/",$archivo['name'],$em);

                          }
                  }}

                $i++;
            }



     //  $this->DeleteFolder($path);

        return $principal;

    }
   private static function get_filelist_as_array($dir, $recursive = true, $basedir = '') {
        if ($dir == '') {return array();} else {$results = array(); $subresults = array();}
        if (!is_dir($dir)) {$dir = dirname($dir);} // so a files path can be sent
        if ($basedir == '') {$basedir = realpath($dir).DIRECTORY_SEPARATOR;}

        $files = scandir($dir);
        foreach ($files as $key => $value){
            if ( ($value != '.') && ($value != '..') ) {
                $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
                if (is_dir($path)) { // do not combine with the next line or..
                    if ($recursive) { // ..non-recursive list will include subdirs
                        $subdirresults = Producto::get_filelist_as_array($path,$recursive,$basedir);
                        $results = array_merge($results,$subdirresults);
                    }
                } else { // strip basedir and add to subarray to separate file list
                    $subresults[] = str_replace($basedir,'',$path);
                }
            }
        }
        // merge the subarray to give the list of files then subdirectory files
        if (count($subresults) > 0) {$results = array_merge($subresults,$results);}
        return $results;
    }

    public static function  DeleteFolder($path)
    {
        $t = Producto::get_filelist_as_array($path,true,$path);
        foreach($t as $f)
            unlink($f);

    }
   public function  PrepareTempFolder($temp,$src)
   {
       Producto::DeleteFolder($temp);
       $id = $this->getSessionid();
       $to = $temp . "/" . $id . '/originals/';

       if (!file_exists($to)) {
           mkdir($to, 0777, true);
       }
       $tn = $temp . "/" . $id . '/thumbnails/';

       if (!file_exists($tn)) {
           mkdir($tn, 0777, true);
       }
      foreach($this->getImages() as $image)
      {
          try
          {
              copy($src.$image->getPath(), $to.$image->getPath());
            //  copy($src.'/small/'.$image->getPath(), $tn.$image->getPath());
          }catch(\Exception $e)
          {

          }

      }
   }
    public static function NombreFileRandom( &$prefijo = '')
    {
        $prefijo = md5(rand(1, 999999999999999999999)*microtime());
        $fullFilePath = $prefijo;
        if(file_exists($fullFilePath))
       return     Producto::NombreFileRandom( $prefijo);
        return $fullFilePath;
    }
    public function getPrincipalImage()
    {
        if($this->getHeadimg()!=null)
            return $this->getHeadimg();

        if($this->getImages()->count()>0)
            return $this->getImages()[0];
   $t = new ImagesProducto();
        $t->setPath('no-img.png');

        return $t;
    }
    private $producto;
    public function setProducto($value)
    {
        $this->producto = $value;
    }
    /**
     * Get headimg
     *
     * @return \Store\RestBundle\Entity\Articulos
     */
    public function getProducto()
    {
        return $this->producto;
    }

    public  function  basePrice($tarifa,$cant)
    {
      return $this->getProducto()->getPrice($tarifa,$cant);

    }
    public  function  basePriceIVA($tarifa,$cant)
    {
        return $this->getProducto()->getPriceIVA($tarifa,$cant);

    }
    public function __toString()
    {
        return $this->getProducto()->getNombre();
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
 //   private $Precios;


    /**
     * Add precio
     *
     * @param \Store\StoreBundle\Entity\ProductPrecio $precio
     *
     * @return Producto
     */
  /*  public function addPrecio(\Store\StoreBundle\Entity\ProductPrecio $precio)
    {
        $precio->setIdproducto($this);
        $this->Precios[] = $precio;
       * return $this;
  }  */

    /**
     * Remove precio
     *
     * @param \Store\StoreBundle\Entity\ProductPrecio $precio
     */
   /* public function removePrecio(\Store\StoreBundle\Entity\ProductPrecio $precio)
    {
        $this->Precios->removeElement($precio);
    }
*/
    /**
     * Get precios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
 /*   public function getPrecios()
    {
        return $this->Precios;
    }*/
    public function getRelated($max=0)
    {
        $result = new ArrayCollection();
       $top=$this->getIdcategory()->getTopCategory();
        $top->getAllProductos($result,$this,$max);

    return $result;
    }
    /**
     * @var integer
     */
    private $destacado;
    /**
     * Set destacado
     *
     * @param integer $destacado
     *
     * @return Producto
     */
    public function setDestacado($destacado)
    {
        $this->destacado = $destacado;

        return $this;
    }

    /**
     * Get destacado
     *
     * @return integer
     */
    public function getDestacado()
    {
        return $this->destacado;
    }
    /**
     * @var integer
     */
    private $tHeadimg;
    /**
     * Set tHeadimg
     *
     * @param string $tHeadimg
     *
     * @return Producto
     */
    public function settHeadimg($tHeadimg)
    {
        $this->tHeadimg = $tHeadimg;

        return $this;
    }

    /**
     * Get tHeadimg
     *
     * @return integer
     */
    public function gettHeadimg()
    {
        return $this->tHeadimg;
    }
}
