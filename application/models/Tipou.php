
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TipoU extends CI_Model

{
    function getDatos()

    {
        return $this->db->query("SELECT TipoUsuario.idTipoUsuario, TipoUsuario.nombreTipoUsuario FROM TipoUsuario")->result_array();
    }

    function nuevotipoUser($data)

    {

        $this->db->insert('TipoUsuario', $data);

    }

    function editartipoUser($data, $idTipoUsuario)

    {

        $this->db->where('idTipoUsuario', $idTipoUsuario);

        $this->db->update('TipoUsuario', $data);

    }

    function borrartipoUser($idTipoUsuario)

    {

        $this->db->where('idTipoUsuario', $idTipoUsuario);

        $this->db->delete("TipoUsuario");

    }


}