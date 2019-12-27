<?php
class Contrato extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getContratos()
    {
        $idUsuario=$this->session->userdata("idUser");
        $this->db->select("Contrato.idContrato, Membresia.nombreMembresia, CONCAT(MundoCaja.pasillo,'-',MundoCaja.numeroCaja) as caja, Caja.nombreCaja, Contrato.fechaTermino, Contrato.fechaRegistro, ClienteExterno.usuario, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"), COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente, ClienteFisico.idClienteFisico, ClienteMoral.idClienteMoral, Contrato.statusContrato, Sucursal.idSucursal, Contrato.archivoFirmado,UsuarioSucursal.idUsuario, Contrato.formaPago, MundoCaja.pasillo, MundoCaja.numeroCaja");
        $this->db->from("Contrato");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->join("ClienteExterno", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=Contrato.idMundoCaja");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("Sucursal","Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->join("UsuarioSucursal","UsuarioSucursal.idSucursal=Sucursal.idSucursal");
        $this->db->join("Usuario","Usuario.idUsuario=UsuarioSucursal.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("((Contrato.statusFinalizado!= 1  AND Contrato.statusFinalizado!=2) OR Contrato.statusFinalizado IS NULL)");

        $this->db->order_by("Contrato.idContrato", "DESC");
        return $this->db->get()->result_array();
    }
    function getContratosTerminados()
    {
        $idUsuario=$this->session->userdata("idUser");
        $this->db->select("Contrato.idContrato, Membresia.nombreMembresia, CONCAT(MundoCaja.pasillo,'-',MundoCaja.numeroCaja) as caja, Caja.nombreCaja, Contrato.fechaTermino, ClienteExterno.usuario, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"), COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente, ClienteFisico.idClienteFisico, ClienteMoral.idClienteMoral, Contrato.statusContrato, Contrato.archivoFirmado, , Contrato.formaPago, MundoCaja.pasillo, MundoCaja.numeroCaja");
        $this->db->from("Contrato");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->join("ClienteExterno", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=Contrato.idMundoCaja");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("Sucursal","Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->join("UsuarioSucursal","UsuarioSucursal.idSucursal=Sucursal.idSucursal");
        $this->db->join("Usuario","Usuario.idUsuario=UsuarioSucursal.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("Contrato.statusFinalizado", "2");

        $this->db->order_by("Contrato.idContrato", "DESC");
        return $this->db->get()->result_array();
    }
    function getMorosos()
    {
        $idUsuario=$this->session->userdata("idUser");
        $this->db->select("Contrato.idContrato, Membresia.nombreMembresia, CONCAT(MundoCaja.pasillo,'-',MundoCaja.numeroCaja) as caja, Caja.nombreCaja, Contrato.fechaTermino, ClienteExterno.usuario, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"), COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente, ClienteFisico.idClienteFisico, ClienteMoral.idClienteMoral, Contrato.statusContrato, Contrato.archivoFirmado, , Contrato.formaPago, MundoCaja.pasillo, MundoCaja.numeroCaja");
        $this->db->from("Contrato");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->join("ClienteExterno", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=Contrato.idMundoCaja");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("Sucursal","Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->join("UsuarioSucursal","UsuarioSucursal.idSucursal=Sucursal.idSucursal");
        $this->db->join("Usuario","Usuario.idUsuario=UsuarioSucursal.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("Contrato.statusFinalizado", "1");

        $this->db->order_by("Contrato.idContrato", "DESC");
        return $this->db->get()->result_array();
    }

    function getMembresias()
    {
        return $this->db->get("Membresia")->result_array();
    }

    function getClientes()
    {
        $this->db->select("ClienteExterno.idClienteExterno, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"),COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");

        return $this->db->get()->result_array();
    }
    function getClienteContrato($idContrato)
    {
        $this->db->select("ClienteExterno.idClienteExterno, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"),COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("Contrato", "ClienteExterno.idClienteExterno=Contrato.idTitular");
        $this->db->where("Contrato.idContrato", $idContrato);

        return $this->db->get()->row_array();
    }

    function getTipoCliente($idClienteExterno)
    {
        $this->db->select("ClienteMoral.idClienteMoral");
        $this->db->from('ClienteMoral');
        $this->db->where('idUsuario', $idClienteExterno);
        $clienteMoral = $this->db->get()->row_array();
        //Cliente moral es 2
        if (!empty($clienteMoral)) {
            return 2;

        } else {
            return 1;
        }
    }

    function getSucursales()
    {
        $idUsuario = $this->session->userdata("idUser");
        $this->db->select("Sucursal.*");
        $this->db->from("Sucursal");
        $this->db->join("UsuarioSucursal", "Sucursal.idSucursal = UsuarioSucursal.idSucursal");
        $this->db->join("Usuario", "UsuarioSucursal.idUsuario = Usuario.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        return $this->db->get()->result_array();
    }

    function getCajaMembresia($idMembresia)
    {
        $idUsuario = $this->session->userdata("idUser");
        $this->db->select("Costo.idCaja, Caja.nombreCaja");
        $this->db->from("Costo");
        $this->db->join("Membresia", "Costo.idMembresia = Membresia.idMembresia");
        $this->db->join("Caja", "Caja.idCaja = Costo.idCaja");
        $this->db->join("MundoCaja", "Caja.idCaja = MundoCaja.idTipoCaja");
        $this->db->join("Sucursal", "MundoCaja.idSucursal = Sucursal.idSucursal");
        $this->db->join("UsuarioSucursal", "Sucursal.idSucursal = UsuarioSucursal.idSucursal");
        $this->db->join("Usuario", "UsuarioSucursal.idUsuario = Usuario.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("Membresia.idMembresia", $idMembresia);
        $this->db->group_by("Costo.idCaja");
        return $this->db->get()->result_array();
    }

    function getPeriodos($idMembresia, $idTipoCaja)
    {
        $idUsuario = $this->session->userdata("idUser");
        $this->db->select("Costo.*");
        $this->db->from("Costo");
        $this->db->join("Membresia", "Costo.idMembresia = Membresia.idMembresia");
        $this->db->join("Caja", "Caja.idCaja = Costo.idCaja");
        $this->db->join("MundoCaja", "Caja.idCaja = MundoCaja.idTipoCaja");
        $this->db->join("Sucursal", "MundoCaja.idSucursal = Sucursal.idSucursal");
        $this->db->join("UsuarioSucursal", "Sucursal.idSucursal = UsuarioSucursal.idSucursal");
        $this->db->join("Usuario", "UsuarioSucursal.idUsuario = Usuario.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("Membresia.idMembresia", $idMembresia);
        $this->db->where("Caja.idCaja", $idTipoCaja);
        $this->db->group_by("Costo.idCosto");
        return $this->db->get()->result_array();
    }

    function getCosto($idCosto)
    {
        return $this->db->get_where("Costo", array('idCosto' => $idCosto))->row_array();
    }

    function getSeguros()
    {
        return $this->db->get("Seguro")->result_array();
    }

    function getPasillos($idSucursal, $idTipoCaja)
    {

        $this->db->select("MundoCaja.pasillo");
        $this->db->from("MundoCaja");
        $this->db->join("Caja", "Caja.idCaja = MundoCaja.idTipoCaja");
        $this->db->join("Sucursal", "MundoCaja.idSucursal = Sucursal.idSucursal");
        $this->db->where("Sucursal.idSucursal", $idSucursal);
        $this->db->where("Caja.idCaja", $idTipoCaja);
        $this->db->group_by("MundoCaja.pasillo");
        return $this->db->get()->result_array();
    }

    function getMundoCajas($idSucursal, $idTipoCaja, $idPasillo)
    {
        $this->db->select("MundoCaja.*");
        $this->db->from("MundoCaja");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("Sucursal", "Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->where("MundoCaja.pasillo", $idPasillo);
        $this->db->where("Sucursal.idSucursal", $idSucursal);
        $this->db->where("MundoCaja.idTipoCaja", $idTipoCaja);
        return $this->db->get()->result_array();
    }

    function insertContrato($data)
    {
        $this->db->insert("Contrato", $data);
        return $this->db->insert_id();
    }

    function actualizarStatusCaja($idMundoCaja, $data)
    {
        $this->db->where("idMundoCaja", $idMundoCaja);
        $this->db->update("MundoCaja", $data);
    }
    function insertCotitular($data)
    {
        $this->db->insert("Cotitular", $data);
    }
    function insertBeneficiario($data)
    {
        $this->db->insert("Beneficiario", $data);
    }
    function insertTarjetaContratos($data)
    {
        $this->db->insert("TarjetasContrato", $data);
    }
    function getCotitularesContrato($idContrato)
    {
        $this->db->select("ClienteExterno.idClienteExterno, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"),COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("Cotitular", "Cotitular.idCliente=ClienteExterno.idClienteExterno");
        $this->db->join("Contrato", "Contrato.idContrato=Cotitular.idContrato");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->result_array();

    }
    function getBeneficiariosContrato($idContrato)
    {
        $this->db->select("Beneficiario.*");
        $this->db->from("Beneficiario");
        $this->db->join("Contrato", "Contrato.idContrato=Beneficiario.idContrato");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->result_array();

    }
    function getTarjeta($idContrato)
    {
        $this->db->select("TarjetasContrato.*");
        $this->db->from("TarjetasContrato");
        $this->db->join("Contrato", "Contrato.idContrato=TarjetasContrato.idContrato");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->result_array();

    }
    function getContrato($idContrato)
    {
        $this->db->select("ClienteExterno.idClienteExterno, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"),COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente,
        ClienteExterno.usuario,
        Sucursal.idSucursal, Sucursal.nombreSucursal, 
        Membresia.idMembresia, Membresia.nombreMembresia, Caja.nombreCaja, 
        Contrato.*, Costo.*, Seguro.*, MundoCaja.idTipoCaja, MundoCaja.pasillo, MundoCaja.numeroCaja, Membresia.nombreMembresia, Contrato.formaPago");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("Contrato", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->join("Seguro", "Contrato.idSeguro=Seguro.idSeguro", "Left");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=Contrato.idMundoCaja");
        $this->db->join("Costo", "Costo.idCosto=Contrato.idCosto");
        $this->db->join("Sucursal", "MundoCaja.idSucursal=Sucursal.idSucursal");
        $this->db->join("Caja", "MundoCaja.idTipoCaja=Caja.idCaja");

        $this->db->where("Contrato.idContrato", $idContrato);

        return $this->db->get()->row_array();
    }
    function getArchivoFirmado($idContrato)
    {
        $this->db->select("Contrato.archivoFirmado");
        $this->db->from("Contrato");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->row_array();
    }
    function getDatosCliente($idContrato)
    {
        //Verificar si es un cliente fisico o un cliente moral
        $this->db->select("ClienteFisico.*");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario");
        $this->db->join("Contrato", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->where("Contrato.idContrato", $idContrato);
        $clienteFisico=$this->db->get()->row_array();
        //si se trata de un cliente fisico, retornar la consulta para obtener su domicilio particular
        if(!empty($clienteFisico))
        {
            $this->db->select("
        ClienteExterno.idClienteExterno, ClienteFisico.nombreClienteFisico as nombreCliente,
        ClienteExterno.idClienteExterno, ClienteFisico.calleParticular as calle,
        ClienteExterno.idClienteExterno, ClienteFisico.numeroParticular as numero,
        ClienteExterno.idClienteExterno, ClienteFisico.numeroInteriorParticular as numeroInterior,
        ClienteExterno.idClienteExterno, ClienteFisico.idRegionParticular as regionF,
        Region.idRegion, Region.nombreRegion, Region.idMunicipio, LPAD(Region.codigoPostal, 5, '0') as codigoPostal, Municipio.*, Estado.*         
        ");
            $this->db->from("ClienteExterno");
            $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario");
            $this->db->join("Region", "Region.idRegion=ClienteFisico.idRegionParticular");
        }
        //si se trata de un cliente moral, retornar la consulta de su domicilio fiscal
        else
        {
            $this->db->select("
        ClienteExterno.idClienteExterno, ClienteMoral.nombreClienteMoral as nombreCliente,
        ClienteExterno.idClienteExterno, ClienteMoral.calleFiscal as calle,
        ClienteExterno.idClienteExterno, ClienteMoral.numeroFiscal as numero,
        ClienteExterno.idClienteExterno, ClienteMoral.numeroInteriorFiscal as numeroInterior,
        ClienteExterno.idClienteExterno, ClienteMoral.idRegionFiscal as regionF,
        Region.idRegion, Region.nombreRegion, Region.idMunicipio, LPAD(Region.codigoPostal, 5, '0') as codigoPostal, Municipio.*, Estado.*         
        ");
            $this->db->from("ClienteExterno");
            $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario");
            $this->db->join("Region", "Region.idRegion=ClienteMoral.idRegionFiscal");
        }
        $this->db->join("Municipio", "Municipio.idMunicipio=Region.idMunicipio");
        $this->db->join("Estado", "Estado.idEstado=Municipio.idEstado");
        $this->db->join("Contrato", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->row_array();
    }
    function getDatosSucursal($idContrato)
    {
        $this->db->select("
        Sucursal.*,
        Region.idRegion, Region.nombreRegion, Region.idMunicipio, LPAD(Region.codigoPostal, 5, '0') as codigoPostal, Municipio.*, Estado.*         
        ");
        $this->db->from("Sucursal");
        $this->db->join("Region", "Sucursal.idRegion=Region.idRegion");
        $this->db->join("Municipio", "Municipio.idMunicipio=Region.idMunicipio");
        $this->db->join("Estado", "Estado.idEstado=Municipio.idEstado");
        $this->db->join("MundoCaja", "MundoCaja.idSucursal=Sucursal.idSucursal");
        $this->db->join("Contrato", "Contrato.idMundoCaja=MundoCaja.idMundoCaja");

        $this->db->where("Contrato.idContrato", $idContrato);

        return $this->db->get()->row_array();
    }
    function eliminarContrato($idContrato)
    {
        $this->db->where("Contrato.idContrato", $idContrato);
        $this->db->delete("Contrato");
    }
    function getMundoCaja($idContrato)
    {
        $this->db->select("MundoCaja.*");
        $this->db->from("MundoCaja");
        $this->db->join("Contrato", "Contrato.idMundoCaja=MundoCaja.idMundoCaja");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->row_array();
    }
    function desocuparCaja($idMundoCaja)
    {
        $this->db->where("MundoCaja.idMundoCaja", $idMundoCaja);
        $this->db->update("MundoCaja", array('status' => 0));
    }
    function ocuparCaja($idMundoCaja)
    {
        $this->db->where("MundoCaja.idMundoCaja", $idMundoCaja);
        $this->db->update("MundoCaja", array('status' => 1));
    }
    function updateContrato($idContrato, $data)
    {
        $this->db->where("Contrato.idContrato", $idContrato);
        $this->db->update("Contrato", $data);
    }
    function deleteCotitulares($idContrato)
    {
        $this->db->where("Cotitular.idContrato", $idContrato);
        $this->db->delete("Cotitular");
    }
    function deleteBeneficiarios($idContrato)
    {
        $this->db->where("Beneficiario.idContrato", $idContrato);
        $this->db->delete("Beneficiario");
    }
    function deleteTarjetas($idContrato)
    {
        $this->db->where("TarjetasContrato.idContrato", $idContrato);
        $this->db->delete("TarjetasContrato");
    }

    function deleteTarjetaContrato($idContrato, $folioTarjetaAnterior)
    {
        $this->db->where("TarjetasContrato.idContrato", $idContrato);
        $this->db->where("TarjetasContrato.FolioTarjeta", $folioTarjetaAnterior);
        $this->db->delete("TarjetasContrato");
    }

    function recuperarCajaContrato($idMundoCaja)
    {
        $this->db->select("Contrato.*");
        $this->db->from("Contrato");
        $this->db->where("Contrato.idMundoCaja", $idMundoCaja);
        $this->db->where("(Contrato.statusFinalizado IS NULL OR (Contrato.statusFinalizado!=1 AND Contrato.statusFinalizado!=2))");
        return $this->db->get()->result_array();
    }
    function getContratosPorVencer($dias, $fechaInicio)
    {
        //2019-05-02
        $date = $fechaInicio;
        $newdate = strtotime ("+$dias day",strtotime($date)) ;
        //2019-05-17
        $newdate = date ('Y-m-d', $newdate);

        $idUsuario=$this->session->userdata("idUser");
        $this->db->select("Contrato.idContrato, Membresia.nombreMembresia, CONCAT(MundoCaja.pasillo,'-',MundoCaja.numeroCaja) as caja, Caja.nombreCaja, Contrato.fechaTermino, ClienteExterno.usuario, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"), COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente, ClienteFisico.idClienteFisico, ClienteMoral.idClienteMoral, Contrato.statusContrato, Contrato.archivoFirmado,  Contrato.formaPago, MundoCaja.pasillo, MundoCaja.numeroCaja");
        $this->db->from("Contrato");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->join("ClienteExterno", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=Contrato.idMundoCaja");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("Sucursal","Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->join("UsuarioSucursal","UsuarioSucursal.idSucursal=Sucursal.idSucursal");
        $this->db->join("Usuario","Usuario.idUsuario=UsuarioSucursal.idUsuario");
        $this->db->where("Usuario.idUsuario", $idUsuario);
        $this->db->where("Contrato.fechaTermino <=", $newdate);
        $this->db->where("Contrato.fechaTermino >=", $date);
        $this->db->where("Contrato.idContrato NOT IN (SELECT CorreoEnviado.idContrato FROM CorreoEnviado)");
        $this->db->order_by("Contrato.idContrato", "DESC");
        return $this->db->get()->result_array();
    }
    function insertCorreoEnviado($data)
    {
        $this->db->insert("CorreoEnviado", $data);
        return $this->db->insert_id();
    }
    function getCorreosEnviados($idContrato)
    {
        $this->db->select("CorreoEnviado.*, Usuario.idUsuario, Usuario.nombreUsuario, Usuario.nickname, Usuario.correoUsuario");
        $this->db->from("CorreoEnviado");
        $this->db->join("Usuario", "Usuario.idUsuario=CorreoEnviado.idUsuario", "LEFT");
        $this->db->where("CorreoEnviado.idContrato", $idContrato);
        return $this->db->get()->result_array();
    }
    function getHistorial($idHistorial)
    {
        $this->db->select("HistorialRenovacion.*");
        $this->db->from("HistorialRenovacion");
        $this->db->where("HistorialRenovacion.idHistorial", $idHistorial);
        return $this->db->get()->row_array();
    }
    function insertHistorialRenovacion($data)
    {
        $this->db->insert("HistorialRenovacion", $data);
    }
    function updateHistorialRenovacion($idHistorial, $data)
    {
        $this->db->where("idHistorial", $idHistorial);
        $this->db->update("HistorialRenovacion", $data);
    }
    function getComprobantesPago($idContrato)
    {
        $this->db->select("HistorialRenovacion.*");
        $this->db->from("HistorialRenovacion");
        $this->db->where("HistorialRenovacion.idContrato", $idContrato);
        $this->db->order_by("HistorialRenovacion.idHistorial", "ASC");
        return $this->db->get()->result_array();
    }
    function getTipoPersona($idContrato)
    {

    }
    function verificarExistenciaTarjeta($idFolio)
    {
        return $this->db->get_where("TarjetasContrato", array('FolioTarjeta' => $idFolio))->num_rows();
    }
    function deleteTarjeta($folio)
    {
        $this->db->where("FolioTarjeta", $folio);
        $this->db->delete("TarjetasContrato");
    }


}