<?php


class Caja extends CI_Model
{

    function getCajas()
    {
        return $this->db->get("Caja")->result_array();
    }
    function deleteCaja($idCaja)
    {
        $this->db->where("idCaja", $idCaja);
        $this->db->delete("Caja");
    }
    function insertarCaja($data)
    {
        $this->db->insert("Caja", $data);
    }
    function updateCaja($idCaja, $data)
    {
        $this->db->where("idCaja", $idCaja);
        $this->db->update("Caja", $data);
    }
}