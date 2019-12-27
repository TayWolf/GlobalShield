<?php


class Sucursal extends CI_Model
{

    function getSucursales()
    {
        return $this->db->get("Sucursal")->result_array();
    }
    function deleteSucursal($idSucursal)
    {
        $this->db->where("idSucursal", $idSucursal);
        $this->db->delete("Sucursal");
    }
    function getEstados()
    {
        return $this->db->get("Estado")->result_array();
    }
    function insertSucursal($data)
    {
        $this->db->insert("Sucursal", $data);
    }
    function getDatosSucursal($idSucursal)
    {
        return $this->db->get_where("Sucursal", array('idSucursal' => $idSucursal))->row_array();
    }
    function getListadoEstados()
    {
        return $this->db->get("Estado")->result_array();
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
    function updateSucursal($idSucursal, $data)
    {
        $this->db->where("idSucursal", $idSucursal);
        $this->db->update("Sucursal", $data);
    }
}