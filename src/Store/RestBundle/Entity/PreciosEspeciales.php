<?php

namespace Store\RestBundle\Entity;

/**
 * @ORM\Table(name="PreciosEspeciales")
 * @ORM\Entity(repositoryClass="\Store\RestBundle\Repository\PreciosEspecialesRepository")
 */
class PreciosEspeciales
{
    /**
     * @var string
     */
    private $idTipoCliente;

    /**
     * @var string
     */
    private $idZona;

    /**
     * @var string
     */
    private $idObra;

    /**
     * @var string
     */
    private $idCliente;

    /**
     * @var string
     */
    private $idCentro;

    /**
     * @var string
     */
    private $idProveedor;

    /**
     * @var string
     */
    private $idSeccion;

    /**
     * @var string
     */
    private $idFamilia;

    /**
     * @var string
     */
    private $idSubfamilia;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $precioFijo;

    /**
     * @var string
     */
    private $dto1;

    /**
     * @var string
     */
    private $dto2;

    /**
     * @var string
     */
    private $dto3;

    /**
     * @var string
     */
    private $desglosar;

    /**
     * @var \DateTime
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     */
    private $fechaFin;

    /**
     * @var \stdClass
     */
    private $regalo;

    /**
     * @var string
     */
    private $comision;

    /**
     * @var string
     */
    private $tarifa;

    /**
     * @var string
     */
    private $ordenBusqueda;

    /**
     * @var string
     */
    private $escalado;

    /**
     * @var array
     */
    private $datosEscalado;

    /**
     * @var string
     */
    private $largo;

    /**
     * @var string
     */
    private $ancho;

    /**
     * @var array
     */
    private $idMatrizPropiedades;

    /**
     * @var string
     */
    private $alto;

    /**
     * @var string
     */
    private $patronArticulos;

    /**
     * @var string
     */
    private $tipoPrecioEmbalajes;

    /**
     * @var string
     */
    private $idPromocion;

    /**
     * @var string
     */
    private $marca;

    /**
     * @var string
     */
    private $id;


    /**
     * Set idTipoCliente
     *
     * @param string $idTipoCliente
     *
     * @return PreciosEspeciales
     */
    public function setIdTipoCliente($idTipoCliente)
    {
        $this->idTipoCliente = $idTipoCliente;

        return $this;
    }

    /**
     * Get idTipoCliente
     *
     * @return string
     */
    public function getIdTipoCliente()
    {
        return $this->idTipoCliente;
    }

    /**
     * Set idZona
     *
     * @param string $idZona
     *
     * @return PreciosEspeciales
     */
    public function setIdZona($idZona)
    {
        $this->idZona = $idZona;

        return $this;
    }

    /**
     * Get idZona
     *
     * @return string
     */
    public function getIdZona()
    {
        return $this->idZona;
    }

    /**
     * Set idObra
     *
     * @param string $idObra
     *
     * @return PreciosEspeciales
     */
    public function setIdObra($idObra)
    {
        $this->idObra = $idObra;

        return $this;
    }

    /**
     * Get idObra
     *
     * @return string
     */
    public function getIdObra()
    {
        return $this->idObra;
    }

    /**
     * Set idCliente
     *
     * @param string $idCliente
     *
     * @return PreciosEspeciales
     */
    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    /**
     * Get idCliente
     *
     * @return string
     */
    public function getIdCliente()
    {
        return $this->idCliente;
    }

    /**
     * Set idCentro
     *
     * @param string $idCentro
     *
     * @return PreciosEspeciales
     */
    public function setIdCentro($idCentro)
    {
        $this->idCentro = $idCentro;

        return $this;
    }

    /**
     * Get idCentro
     *
     * @return string
     */
    public function getIdCentro()
    {
        return $this->idCentro;
    }

    /**
     * Set idProveedor
     *
     * @param string $idProveedor
     *
     * @return PreciosEspeciales
     */
    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;

        return $this;
    }

    /**
     * Get idProveedor
     *
     * @return string
     */
    public function getIdProveedor()
    {
        return $this->idProveedor;
    }

    /**
     * Set idSeccion
     *
     * @param string $idSeccion
     *
     * @return PreciosEspeciales
     */
    public function setIdSeccion($idSeccion)
    {
        $this->idSeccion = $idSeccion;

        return $this;
    }

    /**
     * Get idSeccion
     *
     * @return string
     */
    public function getIdSeccion()
    {
        return $this->idSeccion;
    }

    /**
     * Set idFamilia
     *
     * @param string $idFamilia
     *
     * @return PreciosEspeciales
     */
    public function setIdFamilia($idFamilia)
    {
        $this->idFamilia = $idFamilia;

        return $this;
    }

    /**
     * Get idFamilia
     *
     * @return string
     */
    public function getIdFamilia()
    {
        return $this->idFamilia;
    }

    /**
     * Set idSubfamilia
     *
     * @param string $idSubfamilia
     *
     * @return PreciosEspeciales
     */
    public function setIdSubfamilia($idSubfamilia)
    {
        $this->idSubfamilia = $idSubfamilia;

        return $this;
    }

    /**
     * Get idSubfamilia
     *
     * @return string
     */
    public function getIdSubfamilia()
    {
        return $this->idSubfamilia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return PreciosEspeciales
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set precioFijo
     *
     * @param string $precioFijo
     *
     * @return PreciosEspeciales
     */
    public function setPrecioFijo($precioFijo)
    {
        $this->precioFijo = $precioFijo;

        return $this;
    }

    /**
     * Get precioFijo
     *
     * @return string
     */
    public function getPrecioFijo()
    {
        return $this->precioFijo;
    }

    /**
     * Set dto1
     *
     * @param string $dto1
     *
     * @return PreciosEspeciales
     */
    public function setDto1($dto1)
    {
        $this->dto1 = $dto1;

        return $this;
    }

    /**
     * Get dto1
     *
     * @return string
     */
    public function getDto1()
    {
        return $this->dto1;
    }

    /**
     * Set dto2
     *
     * @param string $dto2
     *
     * @return PreciosEspeciales
     */
    public function setDto2($dto2)
    {
        $this->dto2 = $dto2;

        return $this;
    }

    /**
     * Get dto2
     *
     * @return string
     */
    public function getDto2()
    {
        return $this->dto2;
    }

    /**
     * Set dto3
     *
     * @param string $dto3
     *
     * @return PreciosEspeciales
     */
    public function setDto3($dto3)
    {
        $this->dto3 = $dto3;

        return $this;
    }

    /**
     * Get dto3
     *
     * @return string
     */
    public function getDto3()
    {
        return $this->dto3;
    }

    /**
     * Set desglosar
     *
     * @param string $desglosar
     *
     * @return PreciosEspeciales
     */
    public function setDesglosar($desglosar)
    {
        $this->desglosar = $desglosar;

        return $this;
    }

    /**
     * Get desglosar
     *
     * @return string
     */
    public function getDesglosar()
    {
        return $this->desglosar;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return PreciosEspeciales
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return PreciosEspeciales
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set regalo
     *
     * @param \stdClass $regalo
     *
     * @return PreciosEspeciales
     */
    public function setRegalo($regalo)
    {
        $this->regalo = $regalo;

        return $this;
    }

    /**
     * Get regalo
     *
     * @return \stdClass
     */
    public function getRegalo()
    {
        return $this->regalo;
    }

    /**
     * Set comision
     *
     * @param string $comision
     *
     * @return PreciosEspeciales
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }

    /**
     * Set tarifa
     *
     * @param string $tarifa
     *
     * @return PreciosEspeciales
     */
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;

        return $this;
    }

    /**
     * Get tarifa
     *
     * @return string
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * Set ordenBusqueda
     *
     * @param string $ordenBusqueda
     *
     * @return PreciosEspeciales
     */
    public function setOrdenBusqueda($ordenBusqueda)
    {
        $this->ordenBusqueda = $ordenBusqueda;

        return $this;
    }

    /**
     * Get ordenBusqueda
     *
     * @return string
     */
    public function getOrdenBusqueda()
    {
        return $this->ordenBusqueda;
    }

    /**
     * Set escalado
     *
     * @param string $escalado
     *
     * @return PreciosEspeciales
     */
    public function setEscalado($escalado)
    {
        $this->escalado = $escalado;

        return $this;
    }

    /**
     * Get escalado
     *
     * @return string
     */
    public function getEscalado()
    {
        return $this->escalado;
    }

    /**
     * Set datosEscalado
     *
     * @param array $datosEscalado
     *
     * @return PreciosEspeciales
     */
    public function setDatosEscalado($datosEscalado)
    {
        $this->datosEscalado = $datosEscalado;

        return $this;
    }

    /**
     * Get datosEscalado
     *
     * @return array
     */
    public function getDatosEscalado()
    {
        return $this->datosEscalado;
    }

    /**
     * Set largo
     *
     * @param string $largo
     *
     * @return PreciosEspeciales
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;

        return $this;
    }

    /**
     * Get largo
     *
     * @return string
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param string $ancho
     *
     * @return PreciosEspeciales
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return string
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set idMatrizPropiedades
     *
     * @param array $idMatrizPropiedades
     *
     * @return PreciosEspeciales
     */
    public function setIdMatrizPropiedades($idMatrizPropiedades)
    {
        $this->idMatrizPropiedades = $idMatrizPropiedades;

        return $this;
    }

    /**
     * Get idMatrizPropiedades
     *
     * @return array
     */
    public function getIdMatrizPropiedades()
    {
        return $this->idMatrizPropiedades;
    }

    /**
     * Set alto
     *
     * @param string $alto
     *
     * @return PreciosEspeciales
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return string
     */
    public function getAlto()
    {
        return $this->alto;
    }

    /**
     * Set patronArticulos
     *
     * @param string $patronArticulos
     *
     * @return PreciosEspeciales
     */
    public function setPatronArticulos($patronArticulos)
    {
        $this->patronArticulos = $patronArticulos;

        return $this;
    }

    /**
     * Get patronArticulos
     *
     * @return string
     */
    public function getPatronArticulos()
    {
        return $this->patronArticulos;
    }

    /**
     * Set tipoPrecioEmbalajes
     *
     * @param string $tipoPrecioEmbalajes
     *
     * @return PreciosEspeciales
     */
    public function setTipoPrecioEmbalajes($tipoPrecioEmbalajes)
    {
        $this->tipoPrecioEmbalajes = $tipoPrecioEmbalajes;

        return $this;
    }

    /**
     * Get tipoPrecioEmbalajes
     *
     * @return string
     */
    public function getTipoPrecioEmbalajes()
    {
        return $this->tipoPrecioEmbalajes;
    }

    /**
     * Set idPromocion
     *
     * @param string $idPromocion
     *
     * @return PreciosEspeciales
     */
    public function setIdPromocion($idPromocion)
    {
        $this->idPromocion = $idPromocion;

        return $this;
    }

    /**
     * Get idPromocion
     *
     * @return string
     */
    public function getIdPromocion()
    {
        return $this->idPromocion;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return PreciosEspeciales
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return PreciosEspeciales
     */
    public function setId( $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var string
     */
    private $idArticulo;


    /**
     * Set idArticulo
     *
     * @param string
     *
     * @return PreciosEspeciales
     */
    public function setIdArticulo( $idArticulo)
    {
        $this->idArticulo = $idArticulo;

        return $this;
    }

    /**
     * Get idArticulo
     *
     * @return string
     */
    public function getIdArticulo()
    {
        return $this->idArticulo;
    }
    public function getEscaleDiscount($cant)
    {

        foreach($this->getDatosEscaladoObject() as $escala)
            if($cant>=$escala->desde && $cant<=$escala->hasta)
                return  $escala->descuento ;
        return $this->dto1;
    }

    public function getRegaloCant($cant)
    {

       if($this->getRegalo()!=null)
        {
$c= $this->getRegaloObject()->cantidadMinima;
            $t = 0;
            if($c>0)
            $t = $cant /$c ;
            return floor($t);

        }
        return 0;
    }
    public function getScriptCalc()
    {
      $t= 'var escalado=[';
        foreach($this->getDatosEscaladoObject() as $escala)
        $t.='['.$escala->desde.','.$escala->hasta.','.$escala->descuento.'],';
        $t.=']';

        $t.='
   if(escalado.length>0)
   {
         for(var i=0; i<escalado.length;i++)
          if(cant>=escalado[i][0] && cant<=escalado[i][1] )
          {
          descuento= escalado[i][2];
          break;
          }
          else
           descuento= '.$this->dto1.';
    }
        else
        descuento = '.$this->dto1.';';
        return $t;

    }
    public function  getRegaloScript($id)
    {
        $t = 'function getRegalo_' . $id. 'Cantidad(cant){';
        $t .= 'var cantm =' . $this->getRegaloObject()->cantidadMinima . ';';
        $t .= 'var aregalar=' . $this->getRegaloObject()->cantidadRegalada . ';';
        $t .= ' return Math.floor(cant/cantm * aregalar); } ';
        return $t;

    }
    private $regaloObject;
    public function getRegaloObject()
    {

        if($this->regaloObject==null)
            $this->regaloObject = json_decode($this->getRegalo());
        return $this->regaloObject;
    }
    private $DatosEscalado;
    public  function getDatosEscaladoObject()
    {
        if ($this->DatosEscalado == null) {
            $t = json_decode($this->getDatosEscalado());
            $desde = null;
            $result = array();
            foreach ($t as $row)
                if ($desde == null)
                    $desde = $row->unidades;
                else {
                    $res = new \stdClass();
                    $res->desde = $desde;
                    $res->hasta = $row->unidades;
                    $res->descuento = $row->descuento;
                    $desde = $row->unidades+0.001;
                    $result[] = $res;
                }

            $this->DatosEscalado = $result;

        }

        return $this->DatosEscalado;
    }
    private $ArticuloRegaloObject;
    public  function getArticuloRegaloObject()
    {

       return $this->ArticuloRegaloObject;
    }
    public  function setArticuloRegaloObject($ArticuloRegaloObject)
    {
     
       $this->ArticuloRegaloObject =$ArticuloRegaloObject;
    }
}
