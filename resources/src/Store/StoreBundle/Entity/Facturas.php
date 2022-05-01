<?php

namespace Store\StoreBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Table("factura")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */

class Facturas
{
    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $idcliente;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $serie;

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    private $ano;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $importe;

    /**
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set idcliente
     *
     * @param integer $idcliente
     *
     * @return Facturas
     */
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;

        return $this;
    }

    /**
     * Get idcliente
     *
     * @return integer
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * Set serie
     *
     * @param string $serie
     *
     * @return Facturas
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set ano
     *
     * @param integer $ano
     *
     * @return Facturas
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get ano
     *
     * @return integer
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return Facturas
     */
    public function setImporte( $importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Facturas
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * @var string
     */
    private $numero;


    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Facturas
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }
    /**
     * @Assert\File(
     *
     * )
     */
    private $file;

    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {

        $this->file = $file;
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
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
        return null === $this->path
            ? null
            : $this->getUploadRootDirPath().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDirPath().'/'.$this->path;
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
        return 'uploads/facturas/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = basename($this->getFile()->getClientOriginalName(),'.'.$this->getFile()->getClientOriginalExtension());
            $this->path = $filename.'.'.$this->getFile()->getClientOriginalExtension();


            if(file_exists($this->getUploadRootDirPath().'/'.$this->path)==1)
            {
                $date = date('-d_M_Y_H:i');
                $this->path = $filename.$date.'.'.$this->getFile()->getClientOriginalExtension();
            }

        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {

        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDirPath(), $this->path);

        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDirPath().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }


    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }
}
