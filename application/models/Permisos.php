<?php
class Permisos extends CI_Model
{

    function validacionExistencia($idTipoUsuario, $idModulo)
    {
        $existencia=$this->db->query("SELECT * FROM Permiso WHERE idTipoUsuario=$idTipoUsuario AND idModulo=$idModulo")->row_array();
        if(empty($existencia))
        {

            $this->db->insert("Permiso", array('idTipoUsuario' => $idTipoUsuario, 'idModulo' => $idModulo));

        }

    }

    function actualizarPermiso($idTipoUsuario, $idModulo, $data)
    {
        $this->db->where("idTipoUsuario", $idTipoUsuario);
        $this->db->where("idModulo", $idModulo);
        $this->db->update("Permiso", $data);
    }

    function getPermisosUsuario($idTipoUsuario)
    {
        return $this->db->query("SELECT * FROM Permiso WHERE idTipoUsuario=$idTipoUsuario")->result_array();
    }
    // Saca permisos de un usuario en un modulo
    function getPermisosUsuarioModulo($idTipoUsuario, $idModulo){
        return $this->db->query("SELECT * FROM Permiso WHERE idTipoUsuario=$idTipoUsuario AND idModulo=$idModulo")->row_array();

    }
    function getNombreTipoUsuario($idTipoUsuario)
    {
        return $this->db->query("SELECT nombreTipoUsuario FROM TipoUsuario WHERE idTipoUsuario=$idTipoUsuario")->row_array()['nombreTipoUsuario'];
    }

}