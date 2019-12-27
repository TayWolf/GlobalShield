<?php


class Costo extends CI_Model
{
    function getCostosMembresia($idMembresia)
    {
        $this->db->select("Costo.idCosto, Membresia.nombreMembresia, Caja.nombreCaja, Costo.numeroAnios, Costo.numeroMeses, Costo.numeroDias, Costo.costo");
        $this->db->from("Costo");
        $this->db->join("Membresia", "Membresia.idMembresia=Costo.idMembresia");
        $this->db->join("Caja", "Caja.idCaja=Costo.idCaja");
        $this->db->where("Costo.idMembresia", $idMembresia);
        return $this->db->get()->result_array();
    }
    function getAllCajas()
    {
        return $this->db->get("Caja")->result_array();
    }
    function getNombreMembresia($idMembresia)
    {
        $this->db->select("Membresia.nombreMembresia");
        $this->db->from("Membresia");
        $this->db->where("Membresia.idMembresia", $idMembresia);
        $array=$this->db->get()->row_array();
        return $array['nombreMembresia'];
    }
    function insertarCosto($array)
    {
        $this->db->insert("Costo", $array);
    }
    function eliminarCosto($idCosto)
    {
        $this->db->where("idCosto", $idCosto);
        $this->db->delete("Costo");
    }
    function updateCosto($idCosto, $data)
    {
        $this->db->where("idCosto", $idCosto);
        $this->db->update("Costo", $data);
    }
}