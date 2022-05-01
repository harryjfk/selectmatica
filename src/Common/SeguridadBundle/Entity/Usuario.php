<?php

namespace Common\SeguridadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="nick", columns={"nick"}), @ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={ @ORM\Index(name="idcliente", columns={"idcliente"})})
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="Common\SeguridadBundle\Repository\UsuarioRepository")
 * @ORM\HasLifecycleCallbacks
 * @Assert\Callback(methods={"validPass"})
 */
class Usuario implements AdvancedUserInterface {

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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primer_apellido", type="string", length=255, nullable=true)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundo_apellido", type="string", length=255, nullable=true)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasenya", type="string", length=255, nullable=false)       
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="esadmin", type="boolean", nullable=true)
     */
    private $esadmin = false;

 

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SeguridadGrupo", inversedBy="usuarioid")
     * @ORM\JoinTable(name="seguridad_usuario_grupo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="usuarioid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="grupoid", referencedColumnName="id")
     *   }
     * )
     * @Assert\Count(min = 1, minMessage="seleccionar_grupo")
     */
    private $grupoid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado", type="datetime", nullable=false)
     */
    private $creado;
    /**
     * @var \integer
     *
     * @ORM\Column(name="idcliente", type="integer", nullable=false)
     */
    private $idcliente;
    /**
     * @var \integer
     *
     * @ORM\Column(name="idcomercial", type="integer", nullable=false)
     */
    private $idcomercial;
    /**
     * @var \string
     *
     * @ORM\Column(name="path", type="string", nullable=false)
     */
    private $path;
    /**
     * @var \string
     *
     * @ORM\Column(name="company", type="string", nullable=false)
     */
    private $company;


    /**
     * Constructor
     */
    public function __construct() {
        $this->grupoid = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

     public function isComercial()
     {
       foreach  ($this->getGrupoid() as $grupo)
           if($grupo->getNombreGrupo()=="Comercial")
               return true;
         return false;
     }
    private $impersionate;
    /**
     * Get id
     *
     * @return Usuario
     */
    public function getImpersonateUser()
    {
        return $this->impersionate;
    }
    public function setImpersonateUser($value)
    {
        $this->impersionate= $value;
    }
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }
    /**
     * Set path
     *
     * @param string $path
     *
     * @return Usuario
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }
    /**
     * Set company
     *
     * @param string $company
     *
     * @return Usuario
     */
    public function setCompany($company) {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Company
     *
     * @return string
     */
    public function getCompany() {
        return $this->company;
    }


    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     *
     * @return Usuario
     */
    public function setPrimerApellido($primerApellido) {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string
     */
    public function getPrimerApellido() {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     *
     * @return Usuario
     */
    public function setSegundoApellido($segundoApellido) {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string
     */
    public function getSegundoApellido() {
        return $this->segundoApellido;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Usuario
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Usuario
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set esadmin
     *
     * @param boolean $esadmin
     *
     * @return Usuario
     */
    public function setEsadmin($esadmin) {
        $this->esadmin = $esadmin;

        return $this;
    }

    /**
     * Get esadmin
     *
     * @return boolean
     */
    public function getEsadmin() {
        return $this->esadmin;
    }

    

  
    /**
     * Set idcliente
     *
     * @param integer $idcliente
     *
     * @return Usuario
     */
    public function setIdcliente( $idcliente = null) {
        $this->idcliente = $idcliente;

        return $this;
    }

    /**
     * Get Idcliente
     *
     * @return integer
     */
    public function getIdcliente() {
        return $this->idcliente;
    }



    /**
     * Add grupoid
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid
     *
     * @return Usuario
     */
    public function addGrupoid(\Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid) {
        $this->grupoid[] = $grupoid;

        return $this;
    }

    /**
     * Remove grupoid
     *
     * @param \Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid
     */
    public function removeGrupoid(\Common\SeguridadBundle\Entity\SeguridadGrupo $grupoid) {
        $this->grupoid->removeElement($grupoid);
    }

    /**
     * Get grupoid
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupoid() {
        return $this->grupoid;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Usuario
     */
    public function setCreado(\DateTime $creado = null) {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado() {
        return $this->creado;
    }

    public function __toString() {
        return $this->username;
    }

    public function eraseCredentials() {
        
    }

    public function getNombreCompleto()
    {
        return $this->nombre.' '.$this->primerApellido.' '.$this->segundoApellido;
    }
    public function getRoles() {
        $roles[] = 'ROLE_USER';
        foreach ($this->grupoid as $grupo) {

            foreach ($grupo->getRol() as $rol) {
                $roles[] = $rol->getRol();
            }
        }
        return array_unique($roles);
    }

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isEnabled() {
        return true;
    }

    private  $clienteObject;
    public function setCliente($cliente)
    {
        $this->clienteObject = $cliente;
    }
    public  function  getCliente()
    {
        return $this->clienteObject;
    }

    /**
     * Set idcomercial
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setIdComercial($idcomercial) {
        $this->idcomercial = $idcomercial;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getIdComercial() {
        return $this->idcomercial;
    }

    /**
     * Validador para la contraseña
     */
    public function validPass(ExecutionContextInterface $context) {

        if ($this->username == $this->password) {
            $context->addViolationAt('password', 'usuario_pass_distintos');
        }

        if (!$this->id && !$this->password) {
            $context->addViolationAt('password', 'campo_requerido');
        }

        if ($this->password) {
            if (strlen($this->password) < 6) {
                $context->addViolationAt('password', 'pass_min_caracteres', array('%car%' => 6));
            }
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/users';
    }
    private $temp;
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = $this->id.'.'.$this->getFile()->getClientOriginalExtension();
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {

        if (null !== $this->getFile()) {
            // haz lo que quieras para generar un nombre único
            $filename = $this->id;
            $this->path = $filename.'.'.$this->getFile()->getClientOriginalExtension();

        }
    }
public function getFile()
{
    return $this->file;
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

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
        /*    unlink($this->getUploadRootDir().'/'.$this->temp);*/
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
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

}
