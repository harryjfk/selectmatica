<?php

namespace Store\RestBundle\Entity;

/**
 * Articulos
 * @ORM\Entity()
 * @ORM\Table("articulos") // or "http://www.your-url.com/api/addresses"
 */
class Articulos
{
    /**
     * @var integer
     */
    private $id2;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $idProveedor;

    /**
     * @var string
     */
    private $idSubfamilia;

    /**
     * @var string
     */
    private $marca;

    /**
     * @var boolean
     */
    private $baja;

    /**
     * @var float
     */
    private $unidadesCaja;

    /**
     * @var string
     */
    private $imagen;

    /**
     * @var string
     */
    private $tarifas;

    /**
     * @var float
     */
    private $precioCosto;

    /**
     * @var float
     */
    private $ultimoCosto;

    /**
     * @var float
     */
    private $costoMedio;

    /**
     * @var float
     */
    private $ajuste;

    /**
     * @var float
     */
    private $stock;

    /**
     * @var float
     */
    private $pendienteRecibir;

    /**
     * @var \DateTime
     */
    private $fechaPendienteRecibir;

    /**
     * @var float
     */
    private $precioMinimoVenta;

    /**
     * @var float
     */
    private $unidadDeMedida;

    /**
     * @var boolean
     */
    private $controlaLotes;

    /**
     * @var float
     */
    private $valorImpuesto;

    /**
     * @var string
     */
    private $codigoImpuesto;

    /**
     * @var string
     */
    private $envase;

    /**
     * @var boolean
     */
    private $envaseBultosUnidades;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Store\RestBundle\Entity\Secciones
     */
    private $idSeccion;

    /**
     * @var \Store\RestBundle\Entity\Familias
     */
    private $idFamilia;

    /**
     * @var integer
     */
    private $idTipoIVA;


    /**
     * Set id2
     *
     * @param integer $id2
     *
     * @return Articulos
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;

        return $this;
    }

    /**
     * Get id2
     *
     * @return integer
     */
    public function getId2()
    {
        return $this->id2;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Articulos
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Articulos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set idProveedor
     *
     * @param integer $idProveedor
     *
     * @return Articulos
     */
    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;

        return $this;
    }

    /**
     * Get idProveedor
     *
     * @return integer
     */
    public function getIdProveedor()
    {
        return $this->idProveedor;
    }

    /**
     * Set idSubfamilia
     *
     * @param string $idSubfamilia
     *
     * @return Articulos
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
     * Set marca
     *
     * @param string $marca
     *
     * @return Articulos
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
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Articulos
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;

        return $this;
    }

    /**
     * Get baja
     *
     * @return boolean
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set unidadesCaja
     *
     * @param float $unidadesCaja
     *
     * @return Articulos
     */
    public function setUnidadesCaja($unidadesCaja)
    {
        $this->unidadesCaja = $unidadesCaja;

        return $this;
    }

    /**
     * Get unidadesCaja
     *
     * @return float
     */
    public function getUnidadesCaja()
    {
        return $this->unidadesCaja;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Articulos
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set tarifas
     *
     * @param string $tarifas
     *
     * @return Articulos
     */
    public function setTarifas($tarifas)
    {
        $this->tarifas = $tarifas;

        return $this;
    }

    /**
     * Get tarifas
     *
     * @return string
     */
    public function getTarifas()
    {
        return $this->tarifas;
    }

    /**
     * Set precioCosto
     *
     * @param float $precioCosto
     *
     * @return Articulos
     */
    public function setPrecioCosto($precioCosto)
    {
        $this->precioCosto = $precioCosto;

        return $this;
    }

    /**
     * Get precioCosto
     *
     * @return float
     */
    public function getPrecioCosto()
    {
        return $this->precioCosto;
    }

    /**
     * Set ultimoCosto
     *
     * @param float $ultimoCosto
     *
     * @return Articulos
     */
    public function setUltimoCosto($ultimoCosto)
    {
        $this->ultimoCosto = $ultimoCosto;

        return $this;
    }

    /**
     * Get ultimoCosto
     *
     * @return float
     */
    public function getUltimoCosto()
    {
        return $this->ultimoCosto;
    }

    /**
     * Set costoMedio
     *
     * @param float $costoMedio
     *
     * @return Articulos
     */
    public function setCostoMedio($costoMedio)
    {
        $this->costoMedio = $costoMedio;

        return $this;
    }

    /**
     * Get costoMedio
     *
     * @return float
     */
    public function getCostoMedio()
    {
        return $this->costoMedio;
    }

    /**
     * Set ajuste
     *
     * @param float $ajuste
     *
     * @return Articulos
     */
    public function setAjuste($ajuste)
    {
        $this->ajuste = $ajuste;

        return $this;
    }

    /**
     * Get ajuste
     *
     * @return float
     */
    public function getAjuste()
    {
        return $this->ajuste;
    }

    /**
     * Set stock
     *
     * @param float $stock
     *
     * @return Articulos
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set pendienteRecibir
     *
     * @param float $pendienteRecibir
     *
     * @return Articulos
     */
    public function setPendienteRecibir($pendienteRecibir)
    {
        $this->pendienteRecibir = $pendienteRecibir;

        return $this;
    }

    /**
     * Get pendienteRecibir
     *
     * @return float
     */
    public function getPendienteRecibir()
    {
        return $this->pendienteRecibir;
    }

    /**
     * Set fechaPendienteRecibir
     *
     * @param \DateTime $fechaPendienteRecibir
     *
     * @return Articulos
     */
    public function setFechaPendienteRecibir($fechaPendienteRecibir)
    {
        $this->fechaPendienteRecibir = $fechaPendienteRecibir;

        return $this;
    }

    /**
     * Get fechaPendienteRecibir
     *
     * @return \DateTime
     */
    public function getFechaPendienteRecibir()
    {
        return $this->fechaPendienteRecibir;
    }

    /**
     * Set precioMinimoVenta
     *
     * @param float $precioMinimoVenta
     *
     * @return Articulos
     */
    public function setPrecioMinimoVenta($precioMinimoVenta)
    {
        $this->precioMinimoVenta = $precioMinimoVenta;

        return $this;
    }

    /**
     * Get precioMinimoVenta
     *
     * @return float
     */
    public function getPrecioMinimoVenta()
    {
        return $this->precioMinimoVenta;
    }

    /**
     * Set unidadDeMedida
     *
     * @param float $unidadDeMedida
     *
     * @return Articulos
     */
    public function setUnidadDeMedida($unidadDeMedida)
    {
        $this->unidadDeMedida = $unidadDeMedida;

        return $this;
    }

    /**
     * Get unidadDeMedida
     *
     * @return float
     */
    public function getUnidadDeMedida()
    {
        return $this->unidadDeMedida;
    }

    /**
     * Set controlaLotes
     *
     * @param boolean $controlaLotes
     *
     * @return Articulos
     */
    public function setControlaLotes($controlaLotes)
    {
        $this->controlaLotes = $controlaLotes;

        return $this;
    }

    /**
     * Get controlaLotes
     *
     * @return boolean
     */
    public function getControlaLotes()
    {
        return $this->controlaLotes;
    }

    /**
     * Set valorImpuesto
     *
     * @param float $valorImpuesto
     *
     * @return Articulos
     */
    public function setValorImpuesto($valorImpuesto)
    {
        $this->valorImpuesto = $valorImpuesto;

        return $this;
    }

    /**
     * Get valorImpuesto
     *
     * @return float
     */
    public function getValorImpuesto()
    {
        return $this->valorImpuesto;
    }

    /**
     * Set codigoImpuesto
     *
     * @param string $codigoImpuesto
     *
     * @return Articulos
     */
    public function setCodigoImpuesto($codigoImpuesto)
    {
        $this->codigoImpuesto = $codigoImpuesto;

        return $this;
    }

    /**
     * Get codigoImpuesto
     *
     * @return string
     */
    public function getCodigoImpuesto()
    {
        return $this->codigoImpuesto;
    }

    /**
     * Set envase
     *
     * @param string $envase
     *
     * @return Articulos
     */
    public function setEnvase($envase)
    {
        $this->envase = $envase;

        return $this;
    }

    /**
     * Get envase
     *
     * @return string
     */
    public function getEnvase()
    {
        return $this->envase;
    }

    /**
     * Set envaseBultosUnidades
     *
     * @param boolean $envaseBultosUnidades
     *
     * @return Articulos
     */
    public function setEnvaseBultosUnidades($envaseBultosUnidades)
    {
        $this->envaseBultosUnidades = $envaseBultosUnidades;

        return $this;
    }

    /**
     * Get envaseBultosUnidades
     *
     * @return boolean
     */
    public function getEnvaseBultosUnidades()
    {
        return $this->envaseBultosUnidades;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Articulos
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
     * Set id
     *
     * @param integer $id
     *
     * @return Articulos
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set idSeccion
     *
     * @param \Store\RestBundle\Entity\Secciones $idSeccion
     *
     * @return Articulos
     */
    public function setIdSeccion(\Store\RestBundle\Entity\Secciones $idSeccion = null)
    {
        $this->idSeccion = $idSeccion;

        return $this;
    }

    /**
     * Get idSeccion
     *
     * @return \Store\RestBundle\Entity\Secciones
     */
    public function getIdSeccion()
    {
        return $this->idSeccion;
    }

    /**
     * Set idFamilia
     *
     * @param \Store\RestBundle\Entity\Familias $idFamilia
     *
     * @return Articulos
     */
    public function setIdFamilia(\Store\RestBundle\Entity\Familias $idFamilia = null)
    {
        $this->idFamilia = $idFamilia;

        return $this;
    }

    /**
     * Get idFamilia
     *
     * @return \Store\RestBundle\Entity\Familias
     */
    public function getIdFamilia()
    {
        return $this->idFamilia;
    }

    /**
     * Set idTipoIVA
     *
     * @param integer $idTipoIVA
     *
     * @return Articulos
     */
    public function setIdTipoIVA($idTipoIVA = null)
    {
        $this->idTipoIVA = $idTipoIVA;

        return $this;
    }

    /**
     * Get idTipoIVA
     *
     * @return integer
     */
    public function getIdTipoIVA()
    {
        return $this->idTipoIVA;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $PreciosEspeciales;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->PreciosEspeciales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add preciosEspeciale
     *
     * @param \Store\RestBundle\Entity\PreciosEspeciales $preciosEspeciale
     *
     * @return Articulos
     */
    public function addPreciosEspeciale(\Store\RestBundle\Entity\PreciosEspeciales $preciosEspeciale)
    {
        $this->PreciosEspeciales[] = $preciosEspeciale;

        return $this;
    }

    /**
     * Remove preciosEspeciale
     *
     * @param \Store\RestBundle\Entity\PreciosEspeciales $preciosEspeciale
     */
    public function removePreciosEspeciale(\Store\RestBundle\Entity\PreciosEspeciales $preciosEspeciale)
    {
        $this->PreciosEspeciales->removeElement($preciosEspeciale);
    }

    /**
     * Get preciosEspeciales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreciosEspeciales()
    {
        return $this->PreciosEspeciales;
    }

    public function  getTarifaValue($tarifa)
    {

        $temp = json_decode($this->getTarifas());

        return $temp[$tarifa - 1];
    }

    public function getPrecioEspecial()
    {

   /*     foreach ($this->getPreciosEspeciales() as $t)
            if ($t->getIdCliente() != null && $t->getIdArticulo() == null)
                return $t;*/

        return $this->getPreciosEspeciales()[0];
    }

    public function getPromocionType($tarifa)
    {
        $pv = $this->getPrecioEspecial();
        if ($pv != null)
            if ($pv->getEscalado())
                return 2;
            else
                return 1;
        else {
            $tarifabase = $this->getTarifaValue($tarifa);
            $descuento = $this->getDiscount($tarifabase, 1);
            if ($descuento != 0)
                return 1;
        }
        return 0;
    }

    public function getDiscount($tarifa, $cant)
    {

        $descuento = $tarifa->descuento;


        if ($this->getPreciosEspeciales()->count() != 0) {
            $prv = $this->getPrecioEspecial();

            if ($prv->getEscalado() == 'true') {
                $descuento = $prv->getEscaleDiscount($cant);
            } else
                $descuento = $prv->getdto1();
        }
        return $descuento;
    }

    public function  getDiscountValue($tarifa, $cant, $iva)

    {
        $tarifabase = $this->getTarifaValue($tarifa);
        $descuento = $this->getDiscount($tarifabase, $cant);
        if ($iva == true)
            return $descuento * $tarifabase->pvpIva / 100;
        else
            return $descuento * $tarifabase->pvp / 100;
    }

    public function  getPrice($tarifa, $cant)
    {
        $tarifabase = $this->getTarifaValue($tarifa);

        /*
               $descuento = $tarifabase->descuento;*/
        $nprice = $tarifabase->pvp - $this->getDiscountValue($tarifa, $cant, false);
        return $nprice;
    }

    public function  getPriceIVA($tarifa, $cant)
    {
        $tarifabase = $this->getTarifaValue($tarifa);

        /*
               $descuento = $tarifabase->descuento;*/
        $nprice = $tarifabase->pvpIva - $this->getDiscountValue($tarifa, $cant, true);

        return $nprice;
    }

    private function  getDescCalc($tarifa)
    {

        $t = 'function getDesc_' . $this->getId() . '(iva,cant){';

        $t .= ' if (iva==true)';
        $t .= ' var pvp =' . $tarifa->pvpIva . ';';
        $t .= 'else ';
        $t .= 'var pvp =' . $tarifa->pvp . ';';
        $t .= 'var descuento = ' . $tarifa->descuento . ';';

        if ($this->getPreciosEspeciales()->count() != 0) {
            $prv = $this->getPrecioEspecial();
            if ($prv->getEscalado() == 'true') {
                $t .= $prv->getScriptCalc();
            } else
                $t .= 'descuento =' . $prv->getdto1() . ';';
        }

        $t .= ' return (descuento*pvp/100);}';
        return $t;
    }

    public function getScriptCalc($tarifa)
    {

        $tarifabase = $this->getTarifaValue($tarifa);

        $t = $this->getDescCalc($tarifabase);
        $t .= 'function getPrice_' . $this->getId() . '(cant){';
        $t .= 'var pvp =' . $tarifabase->pvp . ';';


        $t .= 'var p = pvp- getDesc_' . $this->getId() . '(false,cant);';
        $t .= 'return p;';


        $t .= '}';
       /* $t .= 'function getPriceTotalIVA_' . $this->getId() . '(cant){';
        $t .= 'var pvp =' . $tarifabase->pvpIva . ';';


        $t .= 'var p = pvp- getDesc_' . $this->getId() . '(true,cant);';

        $t .= 'return p;';


        $t .= '}';*/
        $t .= 'function getPriceIVA_' . $this->getId() . '(cant){';

        $t .= 'var pvp =' . $tarifabase->pvpIva . ';';


        $t .= 'var p = '.$this->getTipoIvaObject()->getporcentajeIVA().';';

        $t .= 'return p;';


        $t .= '}';
        return $t;

    }


    private $producto = null;

    public function  setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function getProducto()
    {
        if ($this->producto == null)
            $this->producto = new \Store\StoreBundle\Entity\Producto();
        return $this->producto;
    }

    private $tipoIva;

    public function setTipoIvaObject($tipoiva)
    {
        $this->tipoIva = $tipoiva;

    }

    public function getTipoIvaObject()
    {
        return $this->tipoIva;
    }


}
