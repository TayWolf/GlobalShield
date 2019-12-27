
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Seguro extends CI_Model

{
    function getDatos()

    {
        return $this->db->query("SELECT Seguro.idSeguro, Seguro.costoAnual, Seguro.proteccion FROM Seguro")->result_array();
    }

    function nuevoSeguro($data)

    {

        $this->db->insert('Seguro', $data);

    }

    function modificaDatos($data,$idSeguro)
    {
        $this->db->where('idSeguro', $idSeguro);
        $this->db->update('Seguro', $data);

    }

    function borrartipoUser($idSeguro)

    {

        $this->db->where('idSeguro', $idSeguro);

        $this->db->delete("Seguro");

    }


}