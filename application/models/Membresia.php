<?php
class Membresia extends CI_Model
{
    function getMembresias()
    {
        return $this->db->get("Membresia")->result_array();
    }
    function updateMembresia($idMembresia, $data)
    {
        $this->db->where("idMembresia", $idMembresia);
        $this->db->update("Membresia", $data);
    }
    function deleteMembresia($idMembresia)
    {
        $this->db->where("idMembresia", $idMembresia);
        $this->db->delete("Membresia");
    }
    function insertMembresia($data)
    {
        $this->db->insert("Membresia", $data);
    }
}