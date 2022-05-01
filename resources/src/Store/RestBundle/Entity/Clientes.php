<?php

namespace Store\RestBundle\Entity;

/**
 * Clientes
 */
class Clientes
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $razon;

    /**
     * @var string
     */
    private $denominacion;

    /**
     * @var string
     */
    private $nif;

    /**
     * @var string
     */
    private $direccion;

    /**
     * @var string
     */
    private $poblacion;

    /**
     * @var string
     */
    private $codPostal;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var string
     */
    private $telefono1;

    /**
     * @var string
     */
    private $telefono2;

    /**
     * @var string
     */
    private $telefono3;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $idZona;

    /**
     * @var string
     */
    private $idTipo;

    /**
     * @var string
     */
    private $idRuta;

    /**
     * @var string
     */
    private $idActividad;

    /**
     * @var string
     */
    private $idFormaPago;

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
    private $dtoPP;

    /**
     * @var string
     */
    private $aviso;

    /**
     * @var string
     */
    private $notas;

    /**
     * @var string
     */
    private $riesgoConcedido;

    /**
     * @var string
     */
    private $recargoEquivalencia;

    /**
     * @var string
     */
    private $tarifa;

    /**
     * @var string
     */
    private $idTransportista;

    /**
     * @var string
     */
    private $agente;

    /**
     * @var string
     */
    private $cobrador;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $baja;

    /**
     * @var string
     */
    private $directo;

    /**
     * @var string
     */
    private $subcuenta;

    /**
     * @var string
     */
    private $tipoBloqueo;

    /**
     * @var string
     */
    private $periodoFacturacion;

    /**
     * @var string
     */
    private $tipoOperacion;

    /**
     * @var string
     */
    private $tipoIRPF;

    /**
     * @var string
     */
    private $diaPago1;

    /**
     * @var string
     */
    private $diaPago2;

    /**
     * @var string
     */
    private $diaPago3;

    /**
     * @var string
     */
    private $mesNoPagos;

    /**
     * @var string
     */
    private $tipoFacturacion;

    /**
     * @var string
     */
    private $pagaEnvase;

    /**
     * @var string
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Clientes
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set razon
     *
     * @param string $razon
     *
     * @return Clientes
     */
    public function setRazon($razon)
    {
        $this->razon = $razon;

        return $this;
    }

    /**
     * Get razon
     *
     * @return string
     */
    public function getRazon()
    {
        return $this->razon;
    }

    /**
     * Set denominacion
     *
     * @param string $denominacion
     *
     * @return Clientes
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set nif
     *
     * @param string $nif
     *
     * @return Clientes
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Clientes
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set poblacion
     *
     * @param string $poblacion
     *
     * @return Clientes
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get poblacion
     *
     * @return string
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * Set codPostal
     *
     * @param string $codPostal
     *
     * @return Clientes
     */
    public function setCodPostal($codPostal)
    {
        $this->codPostal = $codPostal;

        return $this;
    }

    /**
     * Get codPostal
     *
     * @return string
     */
    public function getCodPostal()
    {
        return $this->codPostal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Clientes
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set telefono1
     *
     * @param string $telefono1
     *
     * @return Clientes
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     *
     * @return Clientes
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set telefono3
     *
     * @param string $telefono3
     *
     * @return Clientes
     */
    public function setTelefono3($telefono3)
    {
        $this->telefono3 = $telefono3;

        return $this;
    }

    /**
     * Get telefono3
     *
     * @return string
     */
    public function getTelefono3()
    {
        return $this->telefono3;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Clientes
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set idZona
     *
     * @param string $idZona
     *
     * @return Clientes
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
     * Set idTipo
     *
     * @param string $idTipo
     *
     * @return Clientes
     */
    public function setIdTipo($idTipo)
    {
        $this->idTipo = $idTipo;

        return $this;
    }

    /**
     * Get idTipo
     *
     * @return string
     */
    public function getIdTipo()
    {
        return $this->idTipo;
    }

    /**
     * Set idRuta
     *
     * @param string $idRuta
     *
     * @return Clientes
     */
    public function setIdRuta($idRuta)
    {
        $this->idRuta = $idRuta;

        return $this;
    }

    /**
     * Get idRuta
     *
     * @return string
     */
    public function getIdRuta()
    {
        return $this->idRuta;
    }

    /**
     * Set idActividad
     *
     * @param string $idActividad
     *
     * @return Clientes
     */
    public function setIdActividad($idActividad)
    {
        $this->idActividad = $idActividad;

        return $this;
    }

    /**
     * Get idActividad
     *
     * @return string
     */
    public function getIdActividad()
    {
        return $this->idActividad;
    }

    /**
     * Set idFormaPago
     *
     * @param string $idFormaPago
     *
     * @return Clientes
     */
    public function setIdFormaPago($idFormaPago)
    {
        $this->idFormaPago = $idFormaPago;

        return $this;
    }

    /**
     * Get idFormaPago
     *
     * @return string
     */
    public function getIdFormaPago()
    {
        return $this->idFormaPago;
    }

    /**
     * Set dto1
     *
     * @param string $dto1
     *
     * @return Clientes
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
     * @return Clientes
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
     * Set dtoPP
     *
     * @param string $dtoPP
     *
     * @return Clientes
     */
    public function setDtoPP($dtoPP)
    {
        $this->dtoPP = $dtoPP;

        return $this;
    }

    /**
     * Get dtoPP
     *
     * @return string
     */
    public function getDtoPP()
    {
        return $this->dtoPP;
    }

    /**
     * Set aviso
     *
     * @param string $aviso
     *
     * @return Clientes
     */
    public function setAviso($aviso)
    {
        $this->aviso = $aviso;

        return $this;
    }

    /**
     * Get aviso
     *
     * @return string
     */
    public function getAviso()
    {
        return $this->aviso;
    }

    /**
     * Set notas
     *
     * @param string $notas
     *
     * @return Clientes
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * Set riesgoConcedido
     *
     * @param string $riesgoConcedido
     *
     * @return Clientes
     */
    public function setRiesgoConcedido($riesgoConcedido)
    {
        $this->riesgoConcedido = $riesgoConcedido;

        return $this;
    }

    /**
     * Get riesgoConcedido
     *
     * @return string
     */
    public function getRiesgoConcedido()
    {
        return $this->riesgoConcedido;
    }

    /**
     * Set recargoEquivalencia
     *
     * @param string $recargoEquivalencia
     *
     * @return Clientes
     */
    public function setRecargoEquivalencia($recargoEquivalencia)
    {
        $this->recargoEquivalencia = $recargoEquivalencia;

        return $this;
    }

    /**
     * Get recargoEquivalencia
     *
     * @return string
     */
    public function getRecargoEquivalencia()
    {
        return $this->recargoEquivalencia;
    }

    /**
     * Set tarifa
     *
     * @param string $tarifa
     *
     * @return Clientes
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
     * Set idTransportista
     *
     * @param string $idTransportista
     *
     * @return Clientes
     */
    public function setIdTransportista($idTransportista)
    {
        $this->idTransportista = $idTransportista;

        return $this;
    }

    /**
     * Get idTransportista
     *
     * @return string
     */
    public function getIdTransportista()
    {
        return $this->idTransportista;
    }

    /**
     * Set agente
     *
     * @param string $agente
     *
     * @return Clientes
     */
    public function setAgente($agente)
    {
        $this->agente = $agente;

        return $this;
    }

    /**
     * Get agente
     *
     * @return string
     */
    public function getAgente()
    {
        return $this->agente;
    }

    /**
     * Set cobrador
     *
     * @param string $cobrador
     *
     * @return Clientes
     */
    public function setCobrador($cobrador)
    {
        $this->cobrador = $cobrador;

        return $this;
    }

    /**
     * Get cobrador
     *
     * @return string
     */
    public function getCobrador()
    {
        return $this->cobrador;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Clientes
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set baja
     *
     * @param string $baja
     *
     * @return Clientes
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;

        return $this;
    }

    /**
     * Get baja
     *
     * @return string
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set directo
     *
     * @param string $directo
     *
     * @return Clientes
     */
    public function setDirecto($directo)
    {
        $this->directo = $directo;

        return $this;
    }

    /**
     * Get directo
     *
     * @return string
     */
    public function getDirecto()
    {
        return $this->directo;
    }

    /**
     * Set subcuenta
     *
     * @param string $subcuenta
     *
     * @return Clientes
     */
    public function setSubcuenta($subcuenta)
    {
        $this->subcuenta = $subcuenta;

        return $this;
    }

    /**
     * Get subcuenta
     *
     * @return string
     */
    public function getSubcuenta()
    {
        return $this->subcuenta;
    }

    /**
     * Set tipoBloqueo
     *
     * @param string $tipoBloqueo
     *
     * @return Clientes
     */
    public function setTipoBloqueo($tipoBloqueo)
    {
        $this->tipoBloqueo = $tipoBloqueo;

        return $this;
    }

    /**
     * Get tipoBloqueo
     *
     * @return string
     */
    public function getTipoBloqueo()
    {
        return $this->tipoBloqueo;
    }

    /**
     * Set periodoFacturacion
     *
     * @param string $periodoFacturacion
     *
     * @return Clientes
     */
    public function setPeriodoFacturacion($periodoFacturacion)
    {
        $this->periodoFacturacion = $periodoFacturacion;

        return $this;
    }

    /**
     * Get periodoFacturacion
     *
     * @return string
     */
    public function getPeriodoFacturacion()
    {
        return $this->periodoFacturacion;
    }

    /**
     * Set tipoOperacion
     *
     * @param string $tipoOperacion
     *
     * @return Clientes
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;

        return $this;
    }

    /**
     * Get tipoOperacion
     *
     * @return string
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * Set tipoIRPF
     *
     * @param string $tipoIRPF
     *
     * @return Clientes
     */
    public function setTipoIRPF($tipoIRPF)
    {
        $this->tipoIRPF = $tipoIRPF;

        return $this;
    }

    /**
     * Get tipoIRPF
     *
     * @return string
     */
    public function getTipoIRPF()
    {
        return $this->tipoIRPF;
    }

    /**
     * Set diaPago1
     *
     * @param string $diaPago1
     *
     * @return Clientes
     */
    public function setDiaPago1($diaPago1)
    {
        $this->diaPago1 = $diaPago1;

        return $this;
    }

    /**
     * Get diaPago1
     *
     * @return string
     */
    public function getDiaPago1()
    {
        return $this->diaPago1;
    }

    /**
     * Set diaPago2
     *
     * @param string $diaPago2
     *
     * @return Clientes
     */
    public function setDiaPago2($diaPago2)
    {
        $this->diaPago2 = $diaPago2;

        return $this;
    }

    /**
     * Get diaPago2
     *
     * @return string
     */
    public function getDiaPago2()
    {
        return $this->diaPago2;
    }

    /**
     * Set diaPago3
     *
     * @param string $diaPago3
     *
     * @return Clientes
     */
    public function setDiaPago3($diaPago3)
    {
        $this->diaPago3 = $diaPago3;

        return $this;
    }

    /**
     * Get diaPago3
     *
     * @return string
     */
    public function getDiaPago3()
    {
        return $this->diaPago3;
    }

    /**
     * Set mesNoPagos
     *
     * @param string $mesNoPagos
     *
     * @return Clientes
     */
    public function setMesNoPagos($mesNoPagos)
    {
        $this->mesNoPagos = $mesNoPagos;

        return $this;
    }

    /**
     * Get mesNoPagos
     *
     * @return string
     */
    public function getMesNoPagos()
    {
        return $this->mesNoPagos;
    }

    /**
     * Set tipoFacturacion
     *
     * @param string $tipoFacturacion
     *
     * @return Clientes
     */
    public function setTipoFacturacion($tipoFacturacion)
    {
        $this->tipoFacturacion = $tipoFacturacion;

        return $this;
    }

    /**
     * Get tipoFacturacion
     *
     * @return string
     */
    public function getTipoFacturacion()
    {
        return $this->tipoFacturacion;
    }

    /**
     * Set pagaEnvase
     *
     * @param string $pagaEnvase
     *
     * @return Clientes
     */
    public function setPagaEnvase($pagaEnvase)
    {
        $this->pagaEnvase = $pagaEnvase;

        return $this;
    }

    /**
     * Get pagaEnvase
     *
     * @return string
     */
    public function getPagaEnvase()
    {
        return $this->pagaEnvase;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return Clientes
     */
    public function setId($id)
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
    public function __toString()
    {
        return $this->nombre;
    }
    private $t_re;
    public function sett_re($re)
    {
        $this->t_re = $re;
    }
    public function gett_re()
    {
        return $this->t_re;
    }

     /**
     * Constructor
     */
    public function __construct()
    {
    }

   private $formapagoObject;
    public function  setFormaPagoObject($formapago)
    {
        $this->formapagoObject = $formapago;
    }
    public function getFormaPagoObject()
    {
        return $this->formapagoObject;
    }

}
