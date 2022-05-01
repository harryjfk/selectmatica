<?php

namespace Store\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idproducto", type="integer", nullable=false)
     */
    private $idproducto;

    /**
     * @var integer
     *
     * @ORM\Column(name="sessionid", type="integer", nullable=false)
     */
    private $sessionid;



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
     * @ORM\OneToMany(targetEntity="ImagesProducto", mappedBy="Producto",)
     */
    private $imagesproductos;
    public function __construct()
    {
        $this->imagesproductos= new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Set addImageProductos
     *
     * @param \Store\AdminBundle\Entity\ImagesProducto $imagesProducto
     *
     * @return ImagesProducto
     */
    public function addImageProductos(\Store\AdminBundle\Entity\ImagesProducto $imagesProducto)
    {
        $this->imagesproductos[] = $imagesProducto;
    }
    /**
     * get ImageProductos
     *

     *
     * @return ArrayCollection
     */
    public function getImageProductos(EntityManager $em=null)

    {
//$t= new ArrayCollection();
        if($em!=null)
        {

            $t=  $em->getRepository('StoreAdminBundle:ImagesProducto')->findBy(array('idproducto'=>$this->getId()));
            $this->imagesproductos =$t;

        }
        return $this->imagesproductos;
    }
    public  function UploadImages($id,$path,EntityManager $em)
    {
     $files = array();
            $d = 'C:\xampp\htdocs\store\web\uploads\images\\';
         $t = $path . "\\" . $id . '\\originals\\';
         $dir = dir($t);
         $i = 0;
         while ($entry = $dir->read())
             if (is_file($t . $entry)) {
                 //$file = $d . $id .'-'. $i;
                 $file = $t . $entry;
                 copy($t . $entry, $file);
                 //aqui ver como borrarlo.
                 $img = $em->getRepository('StoreAdminBundle:Images')->findOneBy(array('pathimage'=>$file));
                 if($img==null)
                 {
                 $img = new Images();
                 $img->setPathimage($file);
                 $em->persist($img);
                 array_push($files, $img);
                 }
                 $i++;
             }
         return $files;

    }



    //--------Serializer


    /**
     * @var \Store\AdminBundle\Entity\Category
     */
    private $idcategory;


    /**
     * Set idcategory
     *
     * @param \Store\AdminBundle\Entity\Category $idcategory
     *
     * @return Producto
     */
    public function setIdcategory(\Store\AdminBundle\Entity\Category $idcategory = null)
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * Get idcategory
     *
     * @return \Store\AdminBundle\Entity\Category
     */
    public function getIdcategory()
    {
        return $this->idcategory;
    }
    public function getRelated()
    {
        return new ArrayCollection();
    }
}
