<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudCaja extends CI_Controller
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
        $this->load->model("Caja");
    }
    function index()
    {
        $this->load->model("Permisos");
        $data['cajas']=$this->Caja->getCajas();

        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 2);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoCajas", $data, TRUE);

    }
    function borrarCaja()
    {
        $this->Caja->deleteCaja($this->input->post("idCaja"));
    }
    function altaCaja()
    {
        print $this->load->view("formAltaCaja", null, TRUE);
    }
    function nuevaCaja()
    {
        $nombreCaja=$this->input->post("nombre");
        $especificaciones=$this->input->post("especificaciones");
		$nombreCaja = $this->security->xss_clean($nombreCaja);
		$especificaciones=$this->security->xss_clean($especificaciones);
        $this->Caja->insertarCaja(array('nombreCaja' => $nombreCaja, 'especificaciones' => $especificaciones));
    }
    function editarCaja()
    {
        $idCaja=$this->input->post("idCaja");
        $especificaciones=$this->input->post("especificaciones");
        $nombreCaja=$this->input->post("nombreCaja");
        if(!empty($especificaciones))
        {
            $this->Caja->updateCaja($idCaja, array('especificaciones' => $especificaciones));
        }
        if(!empty($nombreCaja))
        {
            $this->Caja->updateCaja($idCaja, array('nombreCaja' => $nombreCaja));
        }

    }
}