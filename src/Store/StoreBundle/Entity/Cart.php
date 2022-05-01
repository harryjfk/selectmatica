<?php

namespace Store\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Store\RestBundle\Entity\Clientes;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity
 */
class Cart
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
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordered", type="integer", nullable=false)
     */
    private $ordered;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", nullable=false)
     */
    private $clave;
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Lines;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Lines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Cart
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set ordered
     *
     * @param integer $ordered
     *
     * @return Cart
     */
    public function setOrdered($ordered)
    {
        $this->ordered = $ordered;

        return $this;
    }

    /**
     * Get ordered
     *
     * @return integer
     */
    public function getOrdered()
    {
        return $this->ordered;
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
     * Add line
     *
     * @param \Store\StoreBundle\Entity\Cartline $line
     *
     * @return Cart
     */
    public function addLine(\Store\StoreBundle\Entity\Cartline $line)
    {
        $this->Lines[] = $line;

        return $this;
    }

    /**
     * Remove line
     *
     * @param \Store\StoreBundle\Entity\Cartline $line
     */
    public function removeLine(\Store\StoreBundle\Entity\Cartline $line)
    {
        $this->Lines->removeElement($line);
    }

    /**
     * Get lines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLines()
    {
        return $this->Lines;
    }
    public function getNo()
    {
        $s=explode('_',$this->clave);
        if(count($s)<3)
            return "";
        return $s[2];
    }
    public function getTotalPrice()
    {
    $cant=0;
      foreach  ($this->getLines() as $line)
          $cant+=$line->getFinalPrice($this->getTarifa());
        return $cant;
    }
    public function getTotalAmount()
    {
      $c = 0;
        foreach ($this->getLines() as $line)
        $c+=$line->getCantidad();
        return $c;
    }
    public function getTotalGift    ()
    {
        $c = 0;
        foreach ($this->getLines() as $line)
        {
            $precios = $line->getIdproducto()->getProducto()->getPrecioEspecial();
        if ($precios != null )


            $c+=$precios->getRegaloCant($line->getcantidad());
       }

        return $c;

    }
    private $user;
    public function setUserObject($user)
    {
        $this->user =$user;
    }
    public function getUser()
    {
        return $this->user;
    }

     public function getAgente($vendedor)
     {
       //  $clientes->getAgente()
       if($this->getUser()->getImpersonateUser()==null)
           return $vendedor;
         else
        return $this->getUser()->getImpersonateUser()->getIdComercial();
     }
    public function getDescuentos(Clientes $clientes)
    {
     $r = 0;
        foreach($this->getLines() as $line)
            $r+=$line->getDiscount($clientes->getTarifa());
        return $r;
    }
    public function getAsPedido($vendedor,$serie)
    {

        $clientes= $this->getUser()->getCliente();
        $now = new \DateTime();
     //   $this->setDate($now);
        $pedido = new \stdClass();
        $fecha = $now->format('Y-m-d');
        $hora  = $now->format('H:i:s');


        $pedido->cliente = $this->getUser()->getidcliente();
        $pedido->fecha = $fecha;
        $pedido->hora = $hora;
        $pedido->fechaEntrega = null;
        $pedido->suReferencia = $this->getNocliente();
        $pedido->observaciones = $this->getObservaciones();
        $pedido->formaPago = $clientes->getIdFormaPago();
        $pedido->clase = '';
        $pedido->descuento1 = 0;
        $pedido->descuento2 = 0;
        $pedido->descuento3 = 0;

        $pedido->agente =$this->getAgente($vendedor) ;
        $pedido->confirmado = true;
        $pedido->potencial = false;
        $pedido->estadoOferta= 'CUR'; // EN CURSO
        $pedido->fechaRechazado = null;
        $pedido->firma = $clientes->getNombre();
  //      $pedido->clavePrevento = $this->getId();
//
        $pedido->lineas = array();
        foreach($this->getLines() as $lines)
        {
         $productos = $lines->getAsPedidoLinea($clientes);
            foreach($productos as $prod)

            array_push( $pedido->lineas, $prod);

        }

   //  /   echo json_encode($pedido);

        return $pedido;
    }


    public function __toString()
    {
        return "";
    }
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $observaciones;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Cart
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Cart
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
    /**
     * Set ordered
     *
     * @param string $clave
     *
     * @return Cart
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get ordered
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }
    public function getDeliverAprox()
    {
        $t =$this->getDate();
     $t->setDate($t->format('Y'),$t->format('m'),$t->format('d')+7);
        return $t;
    }
    public function getIVA()
    {
        $r = 0;
         foreach($this->getLines() as $Line)
             $r+=$Line->getidproducto()->getproducto()->getTipoIvaObject()->getporcentajeIVA();

        $t = $this->getLines()->count();
        if($t==0)
            $t=1;
        return $r/$t;
    }
    public function getIVAValue()
    {

       $t =$this->getIVA()*$this->getTotalPrice() ;

        return $t/100;
    }
    public function getPP()
    {
        return 0;
    }
    public function getPPValue()
    {

        return $this->getPP()*$this->getTotalPrice($this->getTarifa())/100;
    }
    private function getTarifa()
    {


        return $this->getUser()->getCliente()->getTarifa();
    }


    public function getBaseImporte()
    {
        return $this->getTotalPrice($this->getTarifa())+ $this->getPPValue($this->getTarifa());
    }

    public function getRE()
    {

        if($this->getUser()->getCliente()->getRecargoEquivalencia()==true)
        return $this->getUser()->getCliente()->gett_re();
     return 0;
    }
    public function getREValue()
    {
        return $this->getRE()*$this->getTotalPrice($this->getTarifa())/100;
    }
    public function ImpuestoPrice()
    {
       return $this->getBaseImporte()+$this->getIVAValue($this->getTarifa())+$this->getREValue();
    }
    public function IVAPrice()
    {
        $r = 0;
        foreach ($this->getLines() as $line)
            $r+=$line->getFinalPriceIVA($this->getTarifa());
        return $r;
    }
    /**
     * @var string
     */
    private $nocliente;


    /**
     * Set nocliente
     *
     * @param string $nocliente
     *
     * @return Cart
     */
    public function setNocliente($nocliente)
    {
        $this->nocliente = $nocliente;

        return $this;
    }

    /**
     * Get nocliente
     *
     * @return string
     */
    public function getNocliente()
    {
        return $this->nocliente;
    }
}
