<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crudusuarios extends CI_Controller
{
    private $key;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuarios');
        $this->load->library('email');
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->load->library('encryption');
        $this->key = bin2hex($this->encryption->create_key(16));
    }

    public function index()
    {
        $this->load->model("Permisos");
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }
        $data['Usuario'] = $this->Usuarios->getDatos();
        $data['sucursal']=$this->Usuarios->getSucursales();
        $data['TipoU'] = $this->Usuarios->getTipo();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 1);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoUsuarios', $data, TRUE);
    }

    function editaDatos()
    {
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }
        $idUsuario = $this->input->post('idUsuario');
        $nombrUs   = $this->input->post('nombreUsuario');
        $nickN     = $this->input->post('nickname');
        $idTip     = $this->input->post('idTipoUsuario');
        $correo    = $this->input->post('correoUsuario');

        if (!empty($nombrUs)) {
            $data = array(
                'nombreUsuario' => $nombrUs
            );
            $this->Usuarios->modificaDatos($data, $idUsuario);
        }
        if (!empty($nickN)) {
            $data = array(
                'nickname' => $nickN
            );
            $this->Usuarios->modificaDatos($data, $idUsuario);
        }
        if (!empty($idTip)) {
            $data = array(
                'idTipoUsuario' => $idTip
            );
            $this->Usuarios->modificaDatos($data, $idUsuario);
        }
        if (!empty($correo)) {
            $data = array(
                'correoUsuario' => $correo
            );
            $this->Usuarios->modificaDatos($data, $idUsuario);
        }
    }

    function altaUsuarios()
    {
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }

        $data['TipoU']   = $this->Usuarios->getTipo();
        $data['Usuario'] = $this->Usuarios->getDatos();
		$data = $this->security->xss_clean($data);
        $this->load->view('formUsuarios', $data);
    }

    function nuevoUser()
    {
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }
        $nameUser      = $this->input->post('nameUser');
        $nickName      = $this->input->post('nickName');
        $passwordUs    = $this->encryption->encrypt ($this->input->post('passwordUs'));
        $idTipoUsuario = $this->input->post('idTipoUsuario');
        $correoU       = $this->input->post('correoUsuario');
        //Encripta un parametro
        $nickname = $this->encryption->encrypt($nickName);
        //Busca y reemplaza caracteres especiales para poder pasar el parametro por URL
        $nickname = strtr($nickname , array('+' => '.', '=' => '-', '/' => '~'));
        $datos    = array(
            'nombreUsuario' => $nameUser,
            'nickname'      => $nickName,
            'password'      => $passwordUs,
            'idTipoUsuario' => $idTipoUsuario,
            'correoUsuario' => $correoU,

        );
        $this->Usuarios->insertaDatos($datos);
        $datos = array(
            'nombreUsuario' => $nameUser,
            'nickname'      => $nickName,
            'encriptado'    => $nickname,
            'password'      => $passwordUs,
            'idTipoUsuario' => $idTipoUsuario,
            'correoUsuario' => $correoU
        );


        $this->sendEmail($datos);
    }

    public function sendEmail($datos)
    {
        $vista = $this->load->view('viewEmail', $datos, TRUE);
        $this->email->from('sistemaGlobalshield@gmail.com', utf8_decode("GLOBAL SHIELD"));
        $this->email->to($datos['correoUsuario']);
        $this->email->subject(utf8_encode('Verificación de correo'));
        $this->email->message(($vista));
        $this->email->set_alt_message('Este es el cuerpo del texto sin formato para clientes de correo que no admiten formato HTML');
        if(!$this->email->send())
        {
            print "error al enviar correo";
        }
        else
            print "Correo enviado";
    }

    function cambioPassword()
    {
        $this->load->view('viewTodoCambioPass');
    }

    function cambioContrasena()
    {
        $correoEncriptado = $this->input->post('encriptado');
        $password = $this->input->post('passwordUs');
        //Busca y reemplaza caracteres especiales para obtener el parametro encriptado
        $correoEncriptado = strtr($correoEncriptado, array('.' => '+', '-' => '=', '~' => '/'));
        //desencripta el parametro
        $correo=$this->encryption->decrypt($correoEncriptado);
        if($correo)
        {
            $this->Usuarios->actualizarPassword($correo, array('password' =>  $this->encryption->encrypt($password)));
        }

    }

    function confPassword()

    {
        $correoU = $this->input->post('correoU');
        $data = array(
            'correoUsuario' => $correoU,
            'encriptado' => strtr($this->encryption->encrypt($correoU) , array('+' => '.', '=' => '-', '/' => '~'))
        );
        $this->sendResetEmailPass($data);
    }

    function sendResetEmailPass($data)
    {
        $data = $this->security->xss_clean($data);
		$vista = $this->load->view('viewEmailPass', $data, TRUE);
        $this->email->from('sistemaGlobalshield@gmail.com', utf8_decode("GLOBAL SHIELD"));
        $this->email->to($data['correoUsuario']);
        $this->email->subject('Restablecer password');
        $this->email->message(($vista));
        $this->email->set_alt_message('Este es el cuerpo del texto sin formato para clientes de correo que no admiten formato HTML');
        if(!$this->email->send())
        {
            print "error al enviar correo";
        }
        else
            print "Correo enviado";
    }

    function confirmarPassword($encriptado)
    {
        $idUser=$this->session->userdata("idUser");
        if(empty($idUser))
        {
            header("Location: ".base_url());
            die();
        }

        $data['encriptado'] = $encriptado;
		$data = $this->security->xss_clean($data);
        $this->load->view('formCambioPass', $data);
    }

    function validarUsuario($encriptado)
    {

        //Busca y reemplaza caracteres especiales para obtener el parametro encriptado
        $encriptado = strtr($encriptado, array('.' => '+', '-' => '=', '~' => '/'));
        //desencripta el parametro
        $nickname=$this->encryption->decrypt($encriptado);
        if($nickname)
        {
            $this->Usuarios->statusUsuario($nickname, array('status' => 1));
            $this->load->view('Verificacion');
        }
        else
        {
            header("Location: ".base_url());
            die();
        }

    }

    function borrarUser()
    {
        $idUsuario = $this->input->post('idUsuario');
        $this->Usuarios->borrarDatos($idUsuario);
        echo $idUsuario;
    }

    function cargarSucusal($idUsuario)
    {
        echo json_encode($this->Usuarios->cargarSucursal($idUsuario));
    }


    function asignarSucursalUsuario($idSucursal, $idUsuario)
    {
        $this->Usuarios->asignarSucursalUsuario(array('idUsuario' => $idUsuario,'idSucursal' =>$idSucursal));
    }

    function eliminarSucursalUsuario($idSucursal, $idUsuario)
    {
        $this->Usuarios->borrarSucursalUsuario($idSucursal,$idUsuario);
    }

    function activarStatusUsuario($idUsuario)
    {
        $this->Usuarios->modificaDatos(array('status' => 1), $idUsuario);
    }

    function desactivarStatusUsuario($idUsuario)
    {
        $this->Usuarios->modificaDatos(array('status' => 0), $idUsuario);
    }

}
?>