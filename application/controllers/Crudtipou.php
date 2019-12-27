<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crudtipou extends CI_Controller
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

        $this->load->model('tipou');
    }

    function index()
    {
        $data['infoTipo']=$this->tipou->getDatos();
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 0);
        $data['permisosPermisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata('idTipo'), 5);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoTipou', $data, TRUE);
    }

    function altaTipo()
    {
        print $this->load->view('formTipo', '', TRUE);
    }

    function nuevoTipp()
    {
        $nombre=$this->input->post('nombre');
        $this->tipou->nuevotipoUser(array('nombreTipoUsuario' => $nombre));
    }

    function editarTipo()
    {
        $idTipoUsuario=$this->input->post('idTipoUsuario');
        if ($this->input->post('action') == 'edit')
        {
            $nombre=$this->input->post('nombreTipoUsuario');
            $this->tipou->editartipoUser(array('nombreTipoUsuario' => $nombre), $idTipoUsuario);
        }
    }

    function borrarTipo()
    {
        $idTipoUsuario=$this->input->post('idTipoUsuario');
        $this->tipou->borrartipoUser($idTipoUsuario);
        echo $idTipoUsuario;
    }
}