<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudCosto extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }
        $this->load->model("Costo");
    }
    function verCostos($idMembresia)
    {
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 8);
        $data['costos']=$this->Costo->getCostosMembresia($idMembresia);
        $data['idMembresia']=$idMembresia;
        $data['cajas']=$this->Costo->getAllCajas();
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoCostosMembresia", $data, TRUE);
    }
    function formAltaCosto($idMembresia)
    {
        $data['idMembresia']=$idMembresia;
        $data['nombreMembresia']=$this->Costo->getNombreMembresia($idMembresia);
        $data['cajas']=$this->Costo->getAllCajas();
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaCosto", $data, TRUE);
    }
    function insertCosto($idMembresia)
    {
        $costo=$this->input->post("costo");
        $dia=$this->input->post("dia");
        $anio=$this->input->post("anio");
        $mes=$this->input->post("mes");
        $caja=$this->input->post("caja");

        $this->Costo->insertarCosto(array('idCaja' => $caja, 'idMembresia' => $idMembresia, 'numeroAnios' => $anio, 'numeroMeses' => $mes,'numeroDias' => $dia, 'costo' => $costo ));
        echo json_encode(1);
    }
    function eliminarCosto()
    {
        $idCosto=$this->input->post("idCosto");
        $this->Costo->eliminarCosto($idCosto);
    }
    function editarCosto()
    {
        $idCosto=$this->input->post("idCosto");
        for($i=0; $i<sizeof($_POST); $i++)
        {
            $actual=current($_POST);

            if(key($_POST)!="action")
            {

                $this->Costo->updateCosto($idCosto, array(key($_POST) => $actual));
            }
            next($_POST);
        }

    }

}