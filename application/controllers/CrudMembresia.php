<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudMembresia extends CI_Controller
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

        $this->load->model("Membresia");
    }
    function index()
    {
        $this->load->model("Permisos");
        $data['membresias']=$this->Membresia->getMembresias();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 3);
        $data['permisosCostos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 8);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoMembresia", $data, TRUE);
    }
    function editarMembresia()
    {
        $idMembresia=$this->input->post("idMembresia");
        $nombreMembresia=$this->input->post("nombreMembresia");
        if(!empty($nombreMembresia))
        {
            $this->Membresia->updateMembresia($idMembresia, array('nombreMembresia' => $nombreMembresia));
        }

    }
    function borrarMembresia()
    {
        $this->Membresia->deleteMembresia($this->input->post("idMembresia"));
    }
    function altaMembresia()
    {
        print $this->load->view("formAltaMembresia", null, TRUE);
    }
    function insertMembresia()
    {
        $this->Membresia->insertMembresia(array('nombreMembresia' => $this->input->post("nombreMembresia")));
    }
}