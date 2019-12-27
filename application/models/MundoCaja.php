<?php


class MundoCaja extends CI_Model
{

    function getMundoCajas()
    {
        $idUsuario=$this->session->userdata("idUser");
        $this->db->select("Sucursal.nombreSucursal, MundoCaja.pasillo, MundoCaja.numeroCaja, Caja.nombreCaja as tipoCaja, MundoCaja.status, MundoCaja.idMundoCaja, MundoCaja.idSucursal, UsuarioSucursal.idSucursal, MundoCaja.statusReparacion");
        $this->db->from("MundoCaja");
        $this->db->join("Sucursal", "MundoCaja.idSucursal=Sucursal.idSucursal");
        $this->db->join("Caja", "MundoCaja.idTipoCaja=Caja.idcaja");
        $this->db->join("UsuarioSucursal", "UsuarioSucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->where("UsuarioSucursal.idUsuario", $idUsuario);
        return $this->db->get()->result_array();


    }

    function deleteCaja($idMundoCaja)
    {
        $this->db->where("idMundoCaja", $idMundoCaja);
        $this->db->delete("MundoCaja");
    }

    function getSucursales()
    {
        $idUsuario=$this->session->userdata("idUser");
        return $this->db->query("SELECT * FROM Sucursal JOIN UsuarioSucursal ON UsuarioSucursal.idSucursal=Sucursal.idSucursal where UsuarioSucursal.idUsuario=$idUsuario")->result_array();
        // $this->db->select("*");
        // $this->db->from("Sucursal");
        // return $this->db->get()->result_array();
    }

    function getTiposCaja()
    {
        $this->db->select("*");
        $this->db->from("Caja");
        return $this->db->get()->result_array();
    }

    function insertCaja($data)
    {
        $this->db->insert("MundoCaja", $data);
    }

    function verificarExistenciaCaja($idSucursal, $pasillo, $numeroCaja, $idMundoCaja=null)
    {
        $this->db->select("idMundoCaja");
        $this->db->from("MundoCaja");
        $this->db->where("idSucursal", $idSucursal);
        $this->db->where("pasillo", $pasillo);
        $this->db->where("numeroCaja", $numeroCaja);
        if(!empty($idMundoCaja))
        {
            $this->db->where("idMundoCaja!=", $idMundoCaja);
        }
        return $this->db->get()->row_array();

    }

    function getMundoCaja($idMundoCaja)
    {
        return $this->db->get_where("MundoCaja", array('idMundoCaja' => $idMundoCaja))->row_array();
    }

    function updateCaja($idMundoCaja, $data)
    {
        $this->db->where("idMundoCaja", $idMundoCaja);
        $this->db->update("MundoCaja", $data);
    }

    function getInformacionCajaOcupada($idMundoCaja)
    {
        $this->db->select("CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"),COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente, Membresia.nombreMembresia, Contrato.*");
        $this->db->from("MundoCaja");
        $this->db->join("Contrato", "Contrato.idMundoCaja=MundoCaja.idMundoCaja");
        $this->db->join("ClienteExterno", "ClienteExterno.idClienteExterno=Contrato.idTitular");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("Membresia", "Membresia.idMembresia=Contrato.idMembresia");
        $this->db->where("MundoCaja.idMundoCaja", $idMundoCaja);
        $this->db->where("(Contrato.statusFinalizado!= 1 OR Contrato.statusFinalizado IS NULL)");
        return $this->db->get()->row_array();
    }

    function insertSolicitudMantenimiento($data)
    {
        $this->db->insert("MantenimientoCaja", $data);
        return $this->db->insert_id();
    }
    function updateSolicitudMantenimiento($idMundoCaja,$data)
    {
        $this->db->where("idMundoCaja", $idMundoCaja);
        $this->db->update("MantenimientoCaja", $data);
    }
    function getTecnicos()
    {
        return $this->db->get("Tecnico")->result_array();
    }
    function getDatosCorreoMantenimiento($idTicketMantenimiento)
    {

        $this->db->select("Sucursal.nombreSucursal, MantenimientoCaja.motivo, MantenimientoCaja.fechaSolicitud, Usuario.nombreUsuario, CONCAT(MundoCaja.pasillo,'-',MundoCaja.numeroCaja) as caja ");
        $this->db->from("MantenimientoCaja");
        $this->db->join("Usuario", "Usuario.idUsuario=MantenimientoCaja.idUsuarioSolicitud");
        $this->db->join("MundoCaja", "MundoCaja.idMundoCaja=MantenimientoCaja.idMundoCaja");
        $this->db->join("Sucursal", "Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->where("MantenimientoCaja.idMantenimientoCaja", $idTicketMantenimiento);
        return $this->db->get()->row_array();

    }

    function getCajasMantenimiento()
    {
        $this->db->select("MundoCaja.idMundoCaja, MundoCaja.idSucursal, MundoCaja.pasillo, MundoCaja.numeroCaja, MundoCaja.idTipoCaja, MundoCaja.statusReparacion, Caja.nombreCaja, Sucursal.nombreSucursal, MantenimientoCaja.fechaSolicitud, MantenimientoCaja.motivo");
        $this->db->from("MundoCaja");
        $this->db->join("Sucursal", "Sucursal.idSucursal=MundoCaja.idSucursal");
        $this->db->join("Caja", "Caja.idCaja=MundoCaja.idTipoCaja");
        $this->db->join("MantenimientoCaja", "MantenimientoCaja.idMundocaja=MundoCaja.idMundoCaja");
        $this->db->where("MundoCaja.statusReparacion= 1");
        $this->db->where("MantenimientoCaja.fechaTermino IS NULL");

        return $this->db->get()->result_array();
    }
}