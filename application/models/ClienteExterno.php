<?php


class ClienteExterno extends CI_Model
{

    function getClientesFisicos()
    {
        return $this->db->query("SELECT ClienteExterno.idClienteExterno as idUsuario, ClienteFisico.nombreClienteFisico as usuario FROM ClienteExterno JOIN ClienteFisico ON ClienteExterno.idClienteExterno = ClienteFisico.idUsuario")->result_array();
    }
    function getClientesMorales()
    {
        return $this->db->query("SELECT ClienteExterno.idClienteExterno as idUsuario, ClienteMoral.nombreClienteMoral as usuario FROM ClienteExterno JOIN ClienteMoral ON ClienteExterno.idClienteExterno = ClienteMoral.idUsuario")->result_array();
    }
    function crearCliente($data)
    {
        $this->db->insert("ClienteExterno", $data);
        return $this->db->insert_id();
    }
    function insertDocumento($data)
    {
        $this->db->insert("DocumentoCliente", $data);

    }
    function insertarClienteMoral($data)
    {
        $this->db->insert("ClienteMoral", $data);
    }
    function insertarClienteFisico($data)
    {
        $this->db->insert("ClienteFisico", $data);
    }
    function comprobarExistenciaUsuario($nombreUsuario)
    {
        return $this->db->query("SELECT usuario FROM ClienteExterno WHERE usuario='$nombreUsuario'")->num_rows();
    }
    function comprobarExistenciaUsuarioEditar($nombreAnterior, $nombreNuevo)
    {
        return $this->db->query("SELECT usuario FROM ClienteExterno WHERE usuario='$nombreNuevo' AND usuario!='$nombreAnterior'")->num_rows();
    }
    function obtenerListaDocumentos($idCliente)
    {
        return $this->db->get_where("DocumentoCliente", array('idCliente' => $idCliente))->result_array();
    }
    function eliminarCliente($idCliente)
    {
        $this->db->where("idClienteExterno", $idCliente);
        $this->db->delete("ClienteExterno");
    }
    function borrarArchivo($nombreArchivo)
    {
        $this->db->like("archivo", $nombreArchivo);
        $this->db->delete("DocumentoCliente");

    }
    function getDetalleClienteMoral($idUsuario)
    {
        return $this->db->query("SELECT ClienteMoral.nombreClienteMoral as nombre, ClienteExterno.usuario,ClienteMoral.* FROM ClienteMoral JOIN ClienteExterno ON ClienteMoral.idUsuario = ClienteExterno.idClienteExterno WHERE ClienteExterno.idClienteExterno=$idUsuario")->row_array();
    }
    function getDetalleClienteFisico($idUsuario)
    {
        return $this->db->query("SELECT ClienteFisico.nombreClienteFisico as nombre, ClienteExterno.usuario, ClienteFisico.* FROM ClienteFisico JOIN ClienteExterno ON ClienteFisico.idUsuario = ClienteExterno.idClienteExterno WHERE ClienteExterno.idClienteExterno=$idUsuario")->row_array();
    }
    function updateClienteFisico($idUsuario, $data)
    {
        $this->db->where("idUsuario", $idUsuario);
        $this->db->update("ClienteFisico", $data);
    }
    function updateClienteMoral($idUsuario, $data)
    {
        $this->db->where("idUsuario", $idUsuario);
        $this->db->update("ClienteMoral", $data);
    }
    function updateCliente($idUsuario, $data)
    {
        $this->db->where("idClienteExterno", $idUsuario);
        $this->db->update("ClienteExterno", $data);
    }
    function verificarPassword($pass)
    {
        
        $this->db->select("Usuario.nickname, Usuario.password");
        $this->db->from("Usuario");
        $this->db->join("TipoUsuario", "Usuario.idTipoUsuario=TipoUsuario.idTipoUsuario");
        //$this->db->where("password", $pass);
        $this->db->where("TipoUsuario.idTipoUsuario", 1);
        $this->load->library('encryption');
        $key = bin2hex($this->encryption->create_key(16));
        $administradores = $this->db->get()->result_array();

        foreach ($administradores as $administrador) 
        {
           $passwordAdmin = $this->encryption->decrypt($administrador['password']);
           if($passwordAdmin)
           {
               if ($passwordAdmin == $pass) {
                   return 1;
               }
           }

        }
        return 0;

    }
    function getListadoEstados()
    {
        return $this->db->get("Estado")->result_array();
    }
    function getMunicipios($idEstado)
    {
        $this->db->select("idMunicipio, nombreMunicipio, idEstado");
        $this->db->from("Municipio");
        $this->db->where("idEstado", $idEstado);
        $this->db->order_by('nombreMunicipio', 'ASC');
        return $this->db->get()->result_array();
    }
    function getColonias($idMunicipio)
    {
        $this->db->select("idRegion, nombreRegion, codigoPostal, idMunicipio");
        $this->db->from("Region");
        $this->db->where("idMunicipio", $idMunicipio);
        $this->db->order_by('nombreRegion', 'ASC');
        return $this->db->get()->result_array();
    }
    function getRegion($idRegion)
    {
        $this->db->select("idRegion, nombreRegion, codigoPostal, idMunicipio");
        $this->db->from("Region");
        $this->db->where("idRegion", $idRegion);
        return $this->db->get()->row_array();
    }
    function getMunicipio($idMunicipio)
    {
        $this->db->select("idMunicipio, nombreMunicipio, idEstado");
        $this->db->from("Municipio");
        $this->db->where("idMunicipio", $idMunicipio);
        return $this->db->get()->row_array();
    }
    function getEstado($idEstado)
    {
        $this->db->select("idEstado, nombreEstado");
        $this->db->from("Estado");
        $this->db->where("idEstado", $idEstado);
        return $this->db->get()->row_array();
    }
}