
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Model{
    //public $variable;
    function __construct(){
        parent::__construct();

    }
    function login($correo,$password)
    {

        $this->load->library('encryption');
        $this->key = bin2hex($this->encryption->create_key(16));
        $this ->db->select('*');
        $this ->db->from('Usuario');
        $this ->db->where('nickname', $correo);
        $this ->db->where('status', 1);

        $query=$this->db->get();
        if($query->num_rows()>= 1)
        {
            $datos = $query->row_array();
            $passDecrypt=$this->encryption->decrypt($datos['password']);
            if($passDecrypt)
            {
                if ($passDecrypt==$password) {
                    return $query->row();
                }
                else{
                    return false;
                }
            }
            else return false;

        }
        else
        {
            return false;
        }
    }


    function getDatos()
    {

        return $this->db->query("SELECT Usuario.idUsuario, Usuario.nombreUsuario, Usuario.nickname, Usuario.password, Usuario.idTipoUsuario, Usuario.correoUsuario, Usuario.status, TipoUsuario.nombreTipoUsuario FROM Usuario JOIN TipoUsuario ON TipoUsuario.idTipoUsuario=Usuario.idTipoUsuario  LEFT JOIN UsuarioSucursal ON UsuarioSucursal.idUsuario=Usuario.idUsuario GROUP BY Usuario.idUsuario")->result_array();
    }

    function getTipo()
    {
        return $this->db->query("SELECT * from TipoUsuario")->result_array();
    }

    function getSucursales()
    {
        return $this->db->get("Sucursal")->result_array();
    }

    function insertaDatos($data)
    {
        $this->db->insert('Usuario', $data);

    }

    function modificaDatos($data,$idUsuario)
    {
        $this->db->where('idUsuario', $idUsuario);
        $this->db->update('Usuario', $data);
    }

    function updateSucursal($idSucursal, $data)
    {
        $this->db->where("idSucursal", $idSucursal);
        $this->db->update("Sucursal", $data);
    }

    function borrarDatos($idUsuario)
    {
        $this->db->where('idUsuario', $idUsuario);
        $this->db->delete('Usuario');
    }

    function cargarSucursal($idUsuario)
    {
        return $this->db->get_where("UsuarioSucursal", array('idUsuario' => $idUsuario))->result_array();
    }

    function asignarSucursalUsuario($data)
    {
        $this->db->insert("UsuarioSucursal", $data);
    }

    function borrarSucursalUsuario($idSucursal, $idUsuario)
    {
        $this->db->where("idSucursal", $idSucursal);
        $this->db->where("idUsuario", $idUsuario);
        $this->db->delete("UsuarioSucursal");
    }

    function statusUsuario($nickname, $data)
    {
        $this->db->where('nickname', $nickname);
        $this->db->update('Usuario', $data);

    }

    function actualizarPassword($correo, $data)
    {
        $this->db->where('correoUsuario',$correo);
        $this->db->update('Usuario', $data);
    }

}