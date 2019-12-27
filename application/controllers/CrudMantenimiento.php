<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudMantenimiento extends CI_Controller {

    public function __construct()
    {

        parent::__construct();
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }

        $this->load->model('Mantenimiento');
    }

    function index()
    {

        $data['infoTipo']=$this->Mantenimiento->getDatos();
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 0);
        $data['permisosPermisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoMantenimiento', $data, TRUE);

    }

    function altaTecnico()

    {

        print $this->load->view('formTecnico', '', TRUE);

    }

    function nuevoTec()

    {
    	$nombreTecnico=$this->input->post('nombreTecnico');
		$correoTecnico = $this->input->post('correoTecnico');
        $datos    = array(
            'nombreTecnico' => $nombreTecnico,
            'correoTecnico' => $correoTecnico

        );
        $this->Mantenimiento->nuevoTecnico($datos);
    }

    function editarTec()

    {
    	$idTecnico = $this->input->post('idTecnico');
        $nombreTecnico   = $this->input->post('nombreTecnico');
        $correoTecnico    = $this->input->post('correoTecnico');

        if (!empty($nombreTecnico)) {
            $data = array(
                'nombreTecnico' => $nombreTecnico
            );
            $this->Mantenimiento->editarTecnico($data, $idTecnico);
        }
        if (!empty($correoTecnico)) {
            $data = array(
                'correoTecnico' => $correoTecnico
            );
            $this->Mantenimiento->editarTecnico($data, $idTecnico);
        }


    }

    function borrarTecnico()

    {
        $idTecnico=$this->input->post('idTecnico');
        $this->Mantenimiento->borrarTec($idTecnico);
        echo $idTecnico;
    }


}

/* End of file CrudMantenimiento.php */
/* Location: ./application/controllers/CrudMantenimiento.php */