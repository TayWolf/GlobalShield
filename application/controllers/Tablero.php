
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Tablero extends CI_Controller
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

    }
    public function index()
    {
        $sesion=$this->session->userdata("idUser");
        if(!empty($sesion))
        {
            $this->load->model("Permisos");
            $data['permisos']=$this->Permisos->getPermisosUsuario($this->session->userdata('idTipo'));
            $this->load->view('header');
            $this->load->view('sidebar', $data);
            $this->load->view('rightSidebar');
            $this->load->view('tableroPrincipal');
            $this->load->view('footer');
        }
        else
            redirect(base_url());
    }
    function envioCorreos()
    {
        $this->load->library('email');
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->load->library('encryption');
        $this->key = bin2hex($this->encryption->create_key(16));

        $idUsuario=$this->session->userdata("idUser");
        if(!empty($idUsuario))
        {
            //Si se necesita enviar otro tipo de correo, crear otra función y mandarla a llamar desde aca
            $this->enviarCorreosContratosPorVencer();

        }
    }
    function enviarCorreosContratosPorVencer()
    {
        $this->load->model("Contrato");

        $contratos=$this->Contrato->getContratosPorVencer(15, date("Y-m-d")); //15 dias

        foreach ($contratos as $contrato)
        {
            $this->email->clear();
            //quienEnvia es null porque lo envia el sistema
            $idCorreo=$this->insertCorreoEnviado($contrato['idContrato'], null);

            $contrato['idCorreoEncriptado']=strtr($this->encryption->encrypt($idCorreo), array('+' => '.', '=' => '-', '/' => '~'));
            $contrato['urlCliente']=$this->config->item("base_url_cliente");
            $vista = $this->load->view('viewEmailContratoPorVencer', $contrato, TRUE);
            //print $vista;
            $this->email->from('sistemaGlobalshield@gmail.com', utf8_decode("GLOBAL SHIELD"));
            $this->email->to($contrato['usuario']);
            $this->email->subject(('Tu contrato esta por vencer'));
            $this->email->message(($vista));
            if(!$this->email->send())
            {
                print "Error al enviar correo";
                show_error($this->email->print_debugger());
            }
            else
                print "Correo enviado";

        }

    }
    function insertCorreoEnviado($idContrato, $quienEnvia)
    {
        return $this->Contrato->insertCorreoEnviado(array(
            'idContrato' => $idContrato,
            'fechaEnvio' => date("Y-m-d"),
            'fechaLectura' => null,
            'status' => 0,
            'idUsuario' => $quienEnvia
        ));
    }

}