<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudSucursal extends CI_Controller
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

        $this->load->model("Sucursal");
    }
    function index()
    {
        $this->load->model("Permisos");
        $data['sucursales']=$this->Sucursal->getSucursales();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 9);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoSucursal", $data, True);
    }
    function verDetalleSucursal($idSucursal)
    {
        $data['sucursal']=$this->Sucursal->getDatosSucursal($idSucursal);
        $data['region']=$this->Sucursal->getRegion($data['sucursal']['idRegion']);
        $data['municipio']=$this->Sucursal->getMunicipio($data['region']['idMunicipio']);
        $data['estado']=$this->Sucursal->getEstado($data['municipio']['idEstado']);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewDetalleSucursal", $data, TRUE);

    }
    function editarSucursal($idSucursal)
    {
        $data['estados']=$this->Sucursal->getListadoEstados();

        $data['sucursal']=$this->Sucursal->getDatosSucursal($idSucursal);
        $data['region']=$this->Sucursal->getRegion($data['sucursal']['idRegion']);
        $data['municipio']=$this->Sucursal->getMunicipio($data['region']['idMunicipio']);
        $data['estado']=$this->Sucursal->getEstado($data['municipio']['idEstado']);
        //los municipios del estado de la sucursal
        $data['municipiosEstado']=$this->Sucursal->getMunicipios($data['estado']['idEstado']);
        //las colonias del municipio de la sucursal
        $data['coloniasMunicipio']=$this->Sucursal->getColonias($data['municipio']['idMunicipio']);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewEdicionSucursal", $data, TRUE);
    }
    function eliminarSucursal()
    {
        $idSucursal=$this->input->post("idSucursal");
        $this->Sucursal->deleteSucursal($idSucursal);
    }
    function altaSucursal()
    {
        $data['estados']=$this->Sucursal->getEstados();
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaSucursal", $data, true);
    }
    function insertSucursal()
    {
        $nombreSucursal=$this->input->post("nombreSucursal");
        $calleSucursal=$this->input->post("calleSucursal");
        $numeroSucursal=$this->input->post("numeroSucursal");
        $numeroInterior=$this->input->post("numeroInterior");
        $telefono1=$this->input->post("telefono1");
        $telefono2=$this->input->post("telefono2");
        $RazonSocial=$this->input->post("RazonSocial");
        $RFC=$this->input->post("RFC");
        $idRegion=$this->input->post("colonia");

        $primaryKey=$this->input->post("primaryKey");
        $idCuenta=$this->input->post("idCuenta");
		$publicKey=$this->input->post("publicKey");

        $this->Sucursal->insertSucursal(array(
            'nombreSucursal' => $nombreSucursal,
            'calle' => $calleSucursal,
            'numero' => $numeroSucursal,
            'numeroInterior' => $numeroInterior,
            'idRegion' => $idRegion,
            'RazonSocial' => $RazonSocial,
            'RFC' => $RFC,
            'telefono1' => $telefono1,
            'telefono2' => $telefono2,
            'keyPrivada' => $primaryKey,
			'keyPublica' => $publicKey,
            'idCuenta' => $idCuenta
        ));
        echo "1";
    }
    function updateSucursal($idSucursal)
    {
        $nombreSucursal=$this->input->post("nombreSucursal");
        $calleSucursal=$this->input->post("calleSucursal");
        $numeroSucursal=$this->input->post("numeroSucursal");
        $numeroInterior=$this->input->post("numeroInterior");
        $telefono1=$this->input->post("telefono1");
        $telefono2=$this->input->post("telefono2");
        $RazonSocial=$this->input->post("RazonSocial");
        $RFC=$this->input->post("RFC");
        $idRegion=$this->input->post("colonia");

        $primaryKey=$this->input->post("primaryKey");
        $idCuenta=$this->input->post("idCuenta");
		$publicKey=$this->input->post("publicKey");

        $this->Sucursal->updateSucursal($idSucursal,array(
            'nombreSucursal' => $nombreSucursal,
            'calle' => $calleSucursal,
            'numero' => $numeroSucursal,
            'numeroInterior' => $numeroInterior,
            'idRegion' => $idRegion,
            'RazonSocial' => $RazonSocial,
            'RFC' => $RFC,
            'telefono1' => $telefono1,
            'telefono2' => $telefono2,
            'keyPrivada' => $primaryKey,
			'keyPublica' => $publicKey,
            'idCuenta' => $idCuenta
        ));
    }
}