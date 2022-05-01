<?php

namespace Common\AdminBaseBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Languages
 * @ORM\HasLifecycleCallbacks
 */
class Languages
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $img;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Languages
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
     * Set locale
     *
     * @param string $locale
     *
     * @return Languages
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Languages
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
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
     * @var boolean
     */
    private $enabled;



    /**
     * Set enabled
     *
     * @param Boolean $enabled
     *
     * @return Languages
     */
    public function setEnabled( $enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return Boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }


    public function __toString()
    {
        return $this->getName();
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

        if (isset($this->img)||$this->img!='') {
            // store the old name to delete after the update
            $this->temp = $this->img;
            $this->img = $this->getName();
        } else {
            $this->img = $this->getName();
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
        return 'uploads/languages/';
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
            $this->img = $filename.'.'.$this->getFile()->getClientOriginalExtension();
            if(file_exists($this->getUploadRootDirPath().'/'.$this->img)==1)
            {
                $date = date('-d_M_Y_H:i');
                $this->img = $filename.$date.'.'.$this->getFile()->getClientOriginalExtension();
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
