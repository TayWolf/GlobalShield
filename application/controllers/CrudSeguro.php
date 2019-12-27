<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CrudSeguro extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }

        $this->load->model('Seguro');
    }

    function index()
    {
        $data['infoSeguro']=$this->Seguro->getDatos();
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 12);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoSeguro', $data, TRUE);
    }

    function altaSeguro()
    {
        print $this->load->view('formSeguro', '', TRUE);
    }

    function nuevoSeg()
    {
        $costoAnual = $this->input->post('costoAnual');
        $proteccion = $this->input->post('proteccion');
        $datos = array(
            'costoAnual' => $costoAnual,
            'proteccion' => $proteccion,
        );
        $this->Seguro->nuevoSeguro($datos);
    }

    function editarSeguro()
    {
        $idSeguro = $this->input->post('idSeguro');
        $costoAnual = $this->input->post('costoAnual');
        $proteccion = $this->input->post('proteccion');
        if (!empty($costoAnual)) {
            $data = array(
                'costoAnual' => $costoAnual
            );
            $this->Seguro->modificaDatos($data, $idSeguro);
        } else {
        }
        if (!empty($proteccion)) {
            $data = array(
                'proteccion' => $proteccion
            );
            $this->Seguro->modificaDatos($data, $idSeguro);
        } else {
        }
    }

    function borrarSeguro()
    {
        $idSeguro=$this->input->post('idSeguro');
        $this->Seguro->borrartipoUser($idSeguro);
        echo $idSeguro;
    }
}