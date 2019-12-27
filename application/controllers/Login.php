<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    public function index()
	{
        $this->session->sess_destroy();

		if(isset($_POST['password'])) //si la variable contiene algún valor
		{
			$this->load->model("usuarios"); //cargamos el controlador de User
			$result=$this->usuarios->login($_POST['username'],$_POST['password']);
			if($result)//si es verdadero el dato ver el modelo User
			{	
				$name= $result->nickname;
				$tipo=$result->idTipoUsuario;
				$iduser=$result->idUsuario;
				$nombreUser=$result->nombreUsuario;

				$this->session->set_userdata("idUser",$iduser);
				$this->session->set_userdata("nickname",$name);//Generamos la variable de usuario
				$this->session->set_userdata("idTipo",$tipo);//Generamos la variable de tipo de usuario
				$this->session->set_userdata("nombreUser",$nombreUser);
                session_start();
				$_SESSION['idUser']=$iduser;
				$_SESSION['idTipo']=$tipo;
				$_SESSION['nickname']=$name;
				$_SESSION['nombreUser']=$nombreUser;
				redirect('Tablero');
			}
			else
			{	
				$this->session->set_flashdata('mensaje','true');
				echo "<script>
				var r =confirm('El usuario o Contraseña es incorrecta.');
                  if (r == true){
                    location.href='".base_url()."';
                     
                  }else{
                    location.href='".base_url()."';}</script>";

			}
		}
		else
		{
			$this->load->view('login_view');
		}
		
	}

}