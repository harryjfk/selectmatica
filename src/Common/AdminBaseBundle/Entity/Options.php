<?php

namespace Common\AdminBaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Store\RestBundle\StoreRestBundle;

/**
 * Options
 *
 * @ORM\Table(name="options")
 * @ORM\Entity
 */
class Options
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
     * @var string
     *
     * @ORM\Column(name="columns", type="text", length=65535, nullable=false)
     */
    private $columns;

    /**
     * @var string
     *
     * @ORM\Column(name="valores", type="text", length=65535, nullable=false)
     */
    private $valores;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return Options
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
     * Set columns
     *
     * @param string $columns
     *
     * @return Options
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get columns
     *
     * @return string
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set valores
     *
     * @param string $valores
     *
     * @return Options
     */
    public function setValores($valores)
    {
        $this->valores = $valores;

        return $this;
    }

    /**
     * Get valores
     *
     * @return string
     */
    public function getValores()
    {
        return $this->valores;
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


    public  function getFormDeclare()
    {
        return '<form id="'.$this->getFormName().'" name="'.$this->getFormName().'" >';
    }
    public  function  getColumnData($name)
    {

        $t = json_decode($this->getColumns());

        return $t->$name;

    }
    public  function  setColumnData($name,$value)
    {

        $t = json_decode($this->getColumns());
        $t->$name = $value;

        $v=json_encode($t) ;
        $this->setValores( $v );

    }
    private  $keys=null;
    function getKeys()
    {
        if($this->keys==null)
        {
            $t =  json_decode($this->getColumns());

            $v=  get_object_vars($t);
            $this->keys= array_keys($v);
        }
        return $this->keys;
    }
    public  function  getColumnsName()
    {
       return $this->getKeys();


    }
    public  function  getValueData($name)
    {
        $t = json_decode($this->getValores());

        return $t->$name;

    }
    public  function  getFormName()
    {
        return  $this->getName().'_options';
    }
    public  function handleRequest(Request $request)
    {
        $cols = $this->getColumnsName();
        $value= array();
     foreach($cols as $col)
        {
            $c = $this->getColumnData($col);
            $n = $this->getControlName($col);
            $v= $this->getValueData($col);
            if($c->type=='file')
            {
              $file =  $request->files->get($n);
                if($file!=null)
                {
                    $this->setFile($file,$col);
                    $v=   $this->preUpload($n);
                    $this->upload();
                }

             //   $v= "aaa.jpg";
            }
            else
                if($c->type=="checkbox")
                {
                    $v = $request->get($n);
                    if($v==null)
                        $v='off';
                }
            else
            {

                //echo $n;
                $v = $request->get($n);
            }

            if($v!=null)
                $value=array_merge($value, array($col=>$v)) ;
        }
        $v=json_encode($value) ;


             $this->setValores( $v );
    }
    private  function getControlName($name)
    {
        return $this->getFormName().'_'.$name;
    }
    public function getConvertedData($name,Controller $controller)
    {
        $col =$this->getColumnData($name);
        if($col->type=="entity")
        {
            $class=$col->class;
            $em= $controller->getDoctrine()->getManager();
            $data =   $em->getRepository($class)->findAll();
            $v = $this->getValueData($name);
            foreach($data as $da)
                if($da->getId()==$v)
                    return $da->__toString();

        }else
        if($col->type=="entity1") {
            $class=$col->class;
            $manager = $col->manager;
            if($manager=="")
                $em= $controller->getDoctrine()->getManager();
            else
                $em= $controller->getDoctrine()->getManager($manager);

            $where="";
            try{

                $where= $col->where;
            }
            catch(Exception $e){}

            $v = $this->getValueData($name);
            if($where=="")
                $data =   $em->getRepository($class)->findAll();
            else
                $data =   $em->getRepository($class)->Where($where);
            foreach($data as $da)
                if($da->getId()==$v)
                    return $da->__toString();
        }

            return $this->getValueData($name);
    }
    public function isFile()
    {

        foreach($this->getKeys() as $col)
        {
            $data = $this->getColumnData($col);

            if(strtolower($data->type)=="file")
                return true;
        }
        return false;
    }
   private function getBaseControl($col,$itemname,$name)
   {
       $s='';
       $s.=  '<input type="'.$col->type.'" name="'.$itemname.'"';
       $class=$col->class;
       if($class!=null)
           $s.=' class="'.$class.'"';
       $v = $this->getValueData($name);



       if($v!=null)
           if($col->type=="checkbox")
           {
               if($v=="on")
                   $s.=" checked='true' ";
               else
                   $s.="    ";
           }
       else
           $s.=' value="'.$v.'"';
       $s.='/>';
       return $s;
   }
    public  function getRow($name, $trans,Controller $controller,$dir)
    {

        $col =$this->getColumnData($name);

        $itemname = $this->getControlName($name);
        $s= '<div><label for="'.$itemname.'">'.   $trans->trans($col->label).'</label>';


        if($col->type=="entity")
        {
            $class=$col->class;
          $em= $controller->getDoctrine()->getManager();
         $data =   $em->getRepository($class)->findAll();
            $v = $this->getValueData($name);
            $s.= '<select id="'.$itemname.'" name="'.$itemname.'" class="form-control input-sm" >';
            foreach($data as $da)
            {
                $s.=' <option value="'.$da->getId().'"';
                if($da->getId()==$v)
                    $s.=' active="active" ';
                $s.='>'.$da->__toString().'</option>';
            }
            $s.='</select> <script>'.$itemname. '.value="'.$v.'"</script>';

        }
        else
            if($col->type=="entity1")
            {
                $class=$col->class;
                $manager = $col->manager;
                if($manager=="")
                    $em= $controller->getDoctrine()->getManager();
                else
                $em= $controller->getDoctrine()->getManager($manager);

                 $where="";
                try{

                    $where= $col->where;
                }
                catch(Exception $e){}


              if($where=="")
               $data =   $em->getRepository($class)->findAll();
              else
                $data =   $em->getRepository($class)->Where($where);
                $v = $this->getValueData($name);

                $s.='<input id="id_'.$itemname.'" name="name_'.$itemname.'" class="form-control input-sm" />';
                $s.= '<select id="'.$itemname.'" name="'.$itemname.'" class="form-control input-sm js-example-basic-single" >';
                foreach($data as $da)
                {
                    $s.=' <option value="'.$da->getId().'"';
                    if($da->getId()==$v)
                        $s.=' active="active" ';
                    $s.='>'.$da->__toString().'</option>';
                }
                $s.="</select> <script>
  var control = null;
          $(function() {
              control=  $('.js-example-basic-single').select2();
              $('#id_".$itemname."').keydown(function(event){
                  if(event.keyCode == 13) {

                      event.preventDefault();
                      control.val(id_".$itemname.".value).trigger('change');

                      return false;
                  }
              });
              $('select').on('select2:select', function (evt) {
                  id_".$itemname.".value=  control[0].value;

              });

              control.val('".$v."').trigger('change');
            id_".$itemname.".value= '".$v."';
          });



                </script>";
            }
            else
                if($col->type=="year")
                {
                  $d = (new \DateTime())->format('Y');
                    $data = array();
                    $c= $col->cant_before;
                    for($i=$d-$c;$i<$d;$i++)
                        $data[]=$i;
                    $data[]=$d;
                    $c= $col->cant_after;
                    for($i=$d+1;$i<$d+$c;$i++)
                        $data[]=$i;
                    $v = $this->getValueData($name);
                    $s.= '<select id="'.$itemname.'" name="'.$itemname.'" class="form-control input-sm" >';
                    foreach($data as $da)
                    {
                        $s.=' <option value="'.$da.'"';
                        if($da==$v)
                            $s.=' active="active" ';
                        $s.='>'.$da.'</option>';
                    }
                    $s.='</select> <script>'.$itemname. '.value="'.$v.'"</script>';
                } else

                if($col->type =="file")
                {
                   $s.='<div class="row"> <div class="col-xs-2"><img src="'.$dir.$this->getValueData($name).'" width="100%" /></div> <div class="col-xs-10">'.$this->getBaseControl($col,$itemname,$name).'</div></div> ';

                }
        else
        {
        $s.=$this->getBaseControl($col,$itemname,$name);
        }
        $s.= '</div>';
        return $s;
    }
    public function getRows($trans,Controller $controller,$dir)
    {
     $vars = $this->getColumnsName();

        $r ='';
      foreach($vars as $var)
          $r.=$this->getRow($var,$trans,$controller,$dir);
      return $r;
    }

    // upload controller
    private $file;

    private $temp;
    private $img;
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null,$col)
    {

        $this->file = $file;

        if (isset($this->img)||$this->img!='') {
            // store the old name to delete after the update
            $this->temp = $this->img;
            $this->img = $this->getFileName($col);
        } else {
            $this->img = $this->getFileName($col);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {

        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->img
            ? null
            : $this->getUploadRootDirPath().'/'.$this->img;
    }

    public function getWebPath()
    {
        return null === $this->img
            ? null
            : $this->getUploadDirPath().'/'.$this->img;
    }

    protected function getUploadRootDirPath()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDirPath();

    }

    protected function getUploadDirPath()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/options/';
    }
    public function getFileName($name)
    {
        return $this->name;
    }
    public function preUpload($name)
    {

        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
           // $filename = basename($this->getFile()->getClientOriginalName(),'.'.$this->getFile()->getClientOriginalExtension());
         $filename=$name;
            $this->img = $filename.'.'.$this->getFile()->getClientOriginalExtension();
           /* if(file_exists($this->getUploadRootDirPath().'/'.$this->img)==1)
            {
                $date = date('-d_M_Y_H:i');
                $this->img = $filename.$date.'.'.$this->getFile()->getClientOriginalExtension();
            }*/
return $this->img;
        }
    }

    public function upload()
    {

        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDirPath(), $this->img);

        if (isset($this->temp)&& $this->temp!='') {
            // delete the old image

            if(file_exists($this->getUploadRootDirPath().'/'.$this->temp))
                unlink($this->getUploadRootDirPath().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }


    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

}
