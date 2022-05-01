<?php

namespace Store\StoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category", indexes={@ORM\Index(name="fk_parent", columns={"idparent"})})
 * @ORM\Entity
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idparent", referencedColumnName="id")
     * })
     */
    private $idparent;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Childs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Productos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Childs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Add child
     *
     * @param \Store\StoreBundle\Entity\Category $child
     *
     * @return Category
     */
    public function addChild(\Store\StoreBundle\Entity\Category $child)
    {
        $this->Childs[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Store\StoreBundle\Entity\Category $child
     */
    public function removeChild(\Store\StoreBundle\Entity\Category $child)
    {
        $this->Childs->removeElement($child);
    }

    /**
     * Get childs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChilds()
    {
        return $this->Childs;
    }

    /**
     * Add producto
     *
     * @param \Store\StoreBundle\Entity\Producto $producto
     *
     * @return Category
     */
    public function addProducto(\Store\StoreBundle\Entity\Producto $producto)
    {
        $this->Productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \Store\StoreBundle\Entity\Producto $producto
     */
    public function removeProducto(\Store\StoreBundle\Entity\Producto $producto)
    {
        $this->Productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->Productos;
    }

    /**
     * Set idparent
     *
     * @param \Store\StoreBundle\Entity\Category $idparent
     *
     * @return Category
     */
    public function setIdparent(\Store\StoreBundle\Entity\Category $idparent = null)
    {
        $this->idparent = $idparent;

        return $this;
    }

    /**
     * Get idparent
     *
     * @return \Store\StoreBundle\Entity\Category
     */
    public function getIdparent()
    {
        return $this->idparent;
    }
    public function __toString()
    {
        $p = $this->getIdparent();
        $s = "";
        if($p!=null) {
            $s = '--';
            while ($p != null) {
                $p = $p->getIdparent();
                $s .= '  ';
            }
        }
        return $s.$this->getName();

    }
    public  function getAllProductos(ArrayCollection $e,$avoid=null,$cant=0)
    {
        foreach($this->getProductos() as $prod)
        {
            $add= $avoid==null;
            if($add==false)
                $add = $prod->getid()!= $avoid->getid();

            if($add==true &&($cant==0 || $cant>$e->count()))
                $e->add($prod);
        }


        foreach($this->getChilds() as $child)
            $child->getAllProductos($e,$avoid,$cant);


    }
    public function  getTopCategory()
    {
        $category = $this;
        while($category->getIdparent()!=null)
            $category = $category->getIdparent();
        return $category;
    }
    private  function  registerImage($file,$dest,$ext,$path,$entry,$em)
    {

            $s = Producto::NombreFileRandom();
            $s.=".". $ext;
            $this->setImage($s);
            if (!file_exists($dest)) {
                mkdir($dest, 0777, true);
            }

            copy($file, $dest.$s);

            if (!file_exists($dest.'/thumbs')) {
                mkdir($dest.'/thumbs', 0777, true);
            }

            if(file_exists( $path . "/" . $this->getSessionid() . '/thumbnails/'.$entry))
                copy($path . "/" . $this->getSessionid() . '/thumbnails/'.$entry, $dest.'/thumbs/'.$s);
            else

            {
                $imagick = new \Imagick(realpath($path . "/" . $this->getSessionid() . '/thumbnails/'.$entry));
                $imagick->scaleImage(80, 80, true);
                $imagick->writeImage($dest.'/thumbs/'.$s);
            }
        return null;
    }
    public  function UploadImages($path,$dest, $em)
    {
        $principal =null;

        $id = $this->getSessionid();
        $t = $path . "/" . $id . '/originals/';
           $dir = dir($t);
        $i = 0;
        while ($entry = $dir->read())
            if (is_file($t . $entry)) {
                 $file = $t . $entry;

                $ext = strtolower( (new \SplFileInfo($file))->getExtension());
                if($ext=="jpg"|| $ext=="png")
                   $this->registerImage(    $file,$dest,$ext,$path,$entry,$em);

                $i++;
            }
         return $principal;

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

            try
            {
                copy($src.$this->getImage(), $to.$this->getImage());
                copy($src.'/thumbs/'.$this->getImage(), $tn.$this->getImage());
            }catch(\Exception $e)
            {

            }


    }
    public function getAllParent()
    {
        $r=array();
        $category = $this;
        while($category!=null)
        {
            $r[] = $category;
            $category = $category->getIdparent();
        }

        $result= array();
       for($i=count($r)-1;$i>=0;$i--)
           $result[] =$r[$i];


        return $result;

    }

    /**
     * @var int
     */
    private $sessionid;

    /**
     * @var string
     */
    private $image;


    /**
     * Set sessionid
     *
     * @param integer $sessionid
     *
     * @return Category
     */
    public function setSessionid( $sessionid)
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
     * Set image
     *
     * @param string $image
     *
     * @return Category
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    public function checkValid(EntityManager $manager)
    {
        $w = new ArrayCollection();


           foreach ($this->getChilds() as $child)
                if($child->checkValid($manager)==false)
                {

                    // $this->getChilds()->removeElement($child);//

                       $manager->remove($child);
                        //$manager->persist($child);
                        $manager->flush();
                    }
        $this->getAllProductos($w);

        return  $w->count()!=0;


    }
  /*  private $extObject;

    public function setExternalObject($value)
    {
       $this->extObject=$value;
    }
    public function getExternalObject()
    {
        return $this->extObject;
    }*/
    public function getLength()
    {
        if($this->getIdparent()==null)
            return 0;
        else
            return $this->getIdparent()->getLength()+1;
    }
    /**
     * @var string
     */
    private $id_src;

    /**
     * @var integer
     */
    private $type_src;


    /**
     * Set idSrc
     *
     * @param string $idSrc
     *
     * @return Category
     */
    public function setIdSrc($idSrc)
    {
        $this->id_src = $idSrc;

        return $this;
    }

    /**
     * Get idSrc
     *
     * @return string
     */
    public function getIdSrc()
    {
        return $this->id_src;
    }

    /**
     * Set typeSrc
     *
     * @param integer $typeSrc
     *
     * @return Category
     */
    public function setTypeSrc($typeSrc)
    {
        $this->type_src = $typeSrc;

        return $this;
    }

    /**
     * Get typeSrc
     *
     * @return integer
     */
    public function getTypeSrc()
    {
        return $this->type_src;
    }
  function getTypeId($type,$string)
  {
      if($string==true)
          if($type>=$this->getTypeSrc())
              return $this->name;
          else
              if($type==1)
                  return $this->getIdparent()->getIdparent()->getName();
              else
                  return $this->getIdparent()->getName();

      else
      if($type>=$this->getTypeSrc())
          return $this->id;
      else
          if($type==1)
              return $this->getIdparent()->getIdparent()->getId();
      else
          return $this->getIdparent()->getId();

  }
    public function getParentByLength($length )
    {
        $p = $this;
      $t = $p->getTypeSrc();

        while($t!=$length)
        {
            $p = $p->getIdparent();
            $t = $p->getTypeSrc();
        }
        return $p;
    }

}
