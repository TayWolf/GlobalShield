<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mantenimiento extends CI_Model {

	function getDatos()

    {
        return $this->db->query("SELECT Tecnico.idTecnico, Tecnico.nombreTecnico, Tecnico.correoTecnico FROM Tecnico")->result_array();
    }

    function nuevoTecnico($data)

    {
        $this->db->insert('Tecnico', $data);
    }

    function editarTecnico($data, $idTecnico)

    {
        $this->db->where('idTecnico', $idTecnico);
        $this->db->update('Tecnico', $data);
    }

    function borrarTec($idTecnico)

    {
        $this->db->where('idTecnico', $idTecnico);
        $this->db->delete("Tecnico");
    }
}

/* End of file Mantenimiento.php */
/* Location: ./application/models/Mantenimiento.php */