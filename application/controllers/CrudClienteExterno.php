<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrudClienteExterno extends CI_Controller
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

        $this->load->model("ClienteExterno");
    }

    function index()
    {
        $this->load->model("Permisos");

        $data['permisos'] = $this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 6);
        $data['permisosDocumentos'] = $this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 7);
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoClienteExterno", $data, TRUE);
    }

    function formAltaCliente()
    {
        $data['estados']=$this->ClienteExterno->getListadoEstados();
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaCliente", $data, TRUE);
    }
    // Esta función sirve para dar de alta un cliente desde el formulario de contratos
    function formAltaClienteModal($esTitular=1)
    {
        $data['esTitular']=$esTitular;
        $data['estados']=$this->ClienteExterno->getListadoEstados();
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaClienteModal", $data, TRUE);
    }

    function getClientesFisicos()
    {
		$data = $this->ClienteExterno->getClientesFisicos();
		$data = $this->security->xss_clean($data);
        echo json_encode($data);
    }

    function getClientesMorales()
    {
        $data = $this->ClienteExterno->getClientesMorales();
		$data = $this->security->xss_clean($data);
		echo json_encode($data);
    }

    function getClientes($tipoCliente)
    {
        if ($tipoCliente == 1)
            $this->getClientesFisicos();
        else
            $this->getClientesMorales();
    }

    function insertCliente($numeroDocumentosExtras)
    {
        $this->load->library('encryption');

        $key = bin2hex($this->encryption->create_key(16));

        /*Inserta el usuario y contraseña encriptada*/
        $usuario = $this->input->post("usuario");
        $password = $this->input->post("password");
        $password = $this->encryption->encrypt($password);
        $idCliente = $this->ClienteExterno->crearCliente(array('usuario' => $usuario, 'password' => $password));
        $idTipoCliente = $this->input->post("idTipoCliente");
        for ($i = 0; $i < $numeroDocumentosExtras; $i++) {
            $nombreArchivo=$this->subirDocumento("otroDocumento" . $i);
            $titulo=$this->input->post("nombreOtroDocumento" . $i);
            if(!empty($titulo)&&!empty($nombreArchivo))
                $this->insertDocumentoCliente($idCliente, $this->input->post("nombreOtroDocumento" . $i), $nombreArchivo, $this->input->post("observacionOtroDocumento" . $i));
        }
        //Cliente fisico:
        if ($idTipoCliente == 1)
        {

            $rfc=$this->input->post("rfc");
            $razonSocial=$this->input->post("razonSocial");

            $calleParticular=$this->input->post("calle1");
            $numeroParticular=$this->input->post("numero1");
            $numeroInteriorParticular=$this->input->post("numeroInterior1");
            $regionParticular=$this->input->post("colonia1");
            if(empty($regionParticular))
                $regionParticular=null;
            $calleFiscal=$this->input->post("calle2");
            $numeroFiscal=$this->input->post("numero2");
            $numeroInteriorFiscal=$this->input->post("numeroInterior2");
            $regionFiscal=$this->input->post("colonia2");
            if(empty($regionFiscal))
                $regionFiscal=null;
            $telefonoLocal=$this->input->post("telefonoLocal");
            $celular=$this->input->post("telefonoCelular");
            $referencia1=$this->input->post("referencia1");
            $referencia2=$this->input->post("referencia2");

            //recuperar los documentos requeridos del cliente físico:
            $this->insertDocumentoCliente($idCliente, "Identificación oficial", $this->subirDocumento("identificacionOficial"), "");
            $this->insertDocumentoCliente($idCliente, "Extranjero", $this->subirDocumento("extranjero"), "");
            $this->insertDocumentoCliente($idCliente, "Comprobante de domicilio", $this->subirDocumento("comprobanteDomicilio"), "");
            $this->insertDocumentoCliente($idCliente, "Referencia personal", $this->subirDocumento("referencia1"), "");
            $this->insertDocumentoCliente($idCliente, "Referencia personal", $this->subirDocumento("referencia2"), "");
            $this->ClienteExterno->insertarClienteFisico
            (array('idUsuario' => $idCliente,
                'nombreClienteFisico' => $this->input->post("nombre"),
                'rfc' => $rfc,
                'razonSocial' => $razonSocial,
                'calleParticular' => $calleParticular,
                'numeroParticular' => $numeroParticular,
                'numeroInteriorParticular' => $numeroInteriorParticular,
                'idRegionParticular' => $regionParticular,
                'calleFiscal' => $calleFiscal,
                'numeroFiscal' => $numeroFiscal,
                'numeroInteriorFiscal' => $numeroInteriorFiscal,
                'idRegionFiscal' => $regionFiscal,
                'telefonoLocal' =>$telefonoLocal,
                'telefonoCelular' => $celular,
                'referencia1' => $referencia1,
                'referencia2' => $referencia2

            ));
        } //Cliente moral:
        else if ($idTipoCliente == 2) {

            $rfc=$this->input->post("rfc");
            $razonSocial=$this->input->post("razonSocial");
            $nombreRepresentanteLegal=$this->input->post("nombreRepresentante");
            $calleParticular=$this->input->post("calle1");
            $numeroParticular=$this->input->post("numero1");
            $numeroInteriorParticular=$this->input->post("numeroInterior1");
            $regionParticular=$this->input->post("colonia1");
            if(empty($regionParticular))
                $regionParticular=null;
            $calleFiscal=$this->input->post("calle2");
            $numeroFiscal=$this->input->post("numero2");
            $numeroInteriorFiscal=$this->input->post("numeroInterior2");
            $regionFiscal=$this->input->post("colonia2");
            if(empty($regionFiscal))
                $regionFiscal=null;
            $telefonoLocal=$this->input->post("telefonoLocal");
            $celular=$this->input->post("telefonoCelular");
            $referencia1=$this->input->post("referencia1");
            $referencia2=$this->input->post("referencia2");
            //recuperar los documentos requeridos del cliente moral:
            $this->insertDocumentoCliente($idCliente, "Acta constitutiva", $this->subirDocumento("actaConstutiva"), "");
            $this->insertDocumentoCliente($idCliente, "Poder notarial", $this->subirDocumento("poderNotarial"), "");
            $this->insertDocumentoCliente($idCliente, "Identificación oficial", $this->subirDocumento("identificacionOficial"), "");
            $this->insertDocumentoCliente($idCliente, "RFC", $this->subirDocumento("rfc"), "");
            $this->insertDocumentoCliente($idCliente, "Comprobante de domicilio", $this->subirDocumento("comprobanteDomicilio"), "");
            $this->insertDocumentoCliente($idCliente, "Referencia comercial", $this->subirDocumento("referencia1"), "");
            $this->insertDocumentoCliente($idCliente, "Referencia comercial", $this->subirDocumento("referencia2"), "");
            $this->ClienteExterno->insertarClienteMoral(
                array('idUsuario' => $idCliente,
                    'nombreClienteMoral' => $this->input->post("nombre"),
                    'rfc' => $rfc,
                    'razonSocial' => $razonSocial,
                    'nombreRepresentanteLegal' => $nombreRepresentanteLegal,
                    'calleRepresentanteLegal' => $calleParticular,
                    'numeroRepresentanteLegal' => $numeroParticular,
                    'numeroInteriorRepresentanteLegal' => $numeroInteriorParticular,
                    'idRegionRepresentanteLegal' => $regionParticular,
                    'calleFiscal' => $calleFiscal,
                    'numeroFiscal' => $numeroFiscal,
                    'numeroInteriorFiscal' => $numeroInteriorFiscal,
                    'idRegionFiscal' => $regionFiscal,
                    'telefonoLocal' =>$telefonoLocal,
                    'telefonoCelular' => $celular,
                    'referencia1' => $referencia1,
                    'referencia2' => $referencia2
                ));
        }
        echo "$idCliente";
    }

    function subirDocumentoOpcional($idCliente, $numeroDocumentosExtras)
    {
        for ($i = 0; $i < $numeroDocumentosExtras; $i++) {
            $nombreArchivo=$this->subirDocumento("otroDocumento" . $i);
            $titulo=$this->input->post("nombreOtroDocumento" . $i);
            if(!empty($titulo)&&!empty($nombreArchivo))
            $this->insertDocumentoCliente($idCliente, $this->input->post("nombreOtroDocumento" . $i), $nombreArchivo, $this->input->post("observacionOtroDocumento" . $i));
        }
    }

    function insertDocumentoCliente($idCliente, $titulo, $archivo, $observaciones)
    {
        $this->ClienteExterno->insertDocumento(array('idCliente' => $idCliente, 'nombreDocumentoCliente' => $titulo, 'archivo' => $archivo, 'observaciones' => $observaciones));
    }

    function subirDocumento($nombrePOST)
    {
        $ruta = "assets/fileUpload/documentosClientes";
        if (!file_exists($ruta) && !is_dir($ruta)) {
            mkdir($ruta);
        }
        if (!empty($_FILES[$nombrePOST])) {
            $images = $_FILES[$nombrePOST];
            $filenames = $images['name'];
        } else
            return null;
        $ext = explode('.', basename($filenames));
        $nombre = DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
        $target = $ruta . $nombre;
        if (move_uploaded_file($images['tmp_name'], $target)) {
            //mueve el archivo a la carpeta y retorna el nuevo nombre del archivo
            return $nombre;
        } else {
            //echo "no se pudo mover el archivo a " . $target;
            return null;
        }


    }

    function comprobarExistenciaUsuario($nombreUser)
    {
        echo $this->ClienteExterno->comprobarExistenciaUsuario(rawurldecode($nombreUser));
    }

    function comprobarExistenciaUsuarioEditar($viejoNombre, $nuevoNombre)
    {
        echo $this->ClienteExterno->comprobarExistenciaUsuarioEditar(rawurldecode($viejoNombre), rawurldecode($nuevoNombre));
    }

    function eliminarCliente()
    {
        $rutaDocumentos = "assets/fileUpload/documentosClientes/";
        $idCliente = $this->input->post("idClienteExterno");
        /*buscar y borrar los documentos del cliente*/
        $allDocumentos = $this->ClienteExterno->obtenerListaDocumentos($idCliente);

        foreach ($allDocumentos as $documento) {
            unlink($rutaDocumentos . $documento['archivo']);

        }
        /*elimina al cliente*/
        $this->ClienteExterno->eliminarCliente($idCliente);
        echo "1";
    }

    function obtenerListaDocumentos($idCliente)
    {
        echo json_encode($this->ClienteExterno->obtenerListaDocumentos($idCliente));
    }

    function borrarArchivo($archivo)
    {
        $rutaDocumentos = "assets/fileUpload/documentosClientes/";
        $this->ClienteExterno->borrarArchivo($archivo);
        unlink($rutaDocumentos . $archivo);
    }

    function detallesClienteExterno($idUsuario, $idTipo)
    {
        $data['idTipo'] = $idTipo;

        if ($idTipo == 1)
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteFisico($idUsuario);

            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionParticular']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);

            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);
        }

        else
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteMoral($idUsuario);

            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionRepresentanteLegal']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);

            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);

        }
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewDetallesClienteExterno", $data, TRUE);
    }

    function editarClienteExterno($idUsuario, $idTipo)
    {
        $data['idUsuario'] = $idUsuario;
        $data['idTipo'] = $idTipo;
        $data['estados']=$this->ClienteExterno->getListadoEstados();
        if ($idTipo == 1)
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteFisico($idUsuario);
            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionParticular']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);
            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);
            $data['municipiosEstado1']=$this->ClienteExterno->getMunicipios($data['estado1']['idEstado']);
            $data['municipiosEstado2']=$this->ClienteExterno->getMunicipios($data['estado2']['idEstado']);
            $data['coloniasMunicipio1']=$this->ClienteExterno->getColonias($data['municipio1']['idMunicipio']);
            $data['coloniasMunicipio2']=$this->ClienteExterno->getColonias($data['municipio2']['idMunicipio']);


        }
        else
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteMoral($idUsuario);
            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionRepresentanteLegal']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);
            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);
            $data['municipiosEstado1']=$this->ClienteExterno->getMunicipios($data['estado1']['idEstado']);
            $data['municipiosEstado2']=$this->ClienteExterno->getMunicipios($data['estado2']['idEstado']);
            $data['coloniasMunicipio1']=$this->ClienteExterno->getColonias($data['municipio1']['idMunicipio']);
            $data['coloniasMunicipio2']=$this->ClienteExterno->getColonias($data['municipio2']['idMunicipio']);
        }
		$data = $this->security->xss_clean($data);
        print $this->load->view("gridEditarClienteExterno", $data, TRUE);
    }


    // Esta función sirve para editar un cliente desde el formulario de contratos
    function editarClienteExternoModal($idUsuario, $idTipo=null)
    {
        $data['idTipo'] = $idTipo;
        if(empty($idTipo))
        {

        }
        $data['idUsuario'] = $idUsuario;

        $data['estados']=$this->ClienteExterno->getListadoEstados();
        if ($idTipo == 1)
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteFisico($idUsuario);
            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionParticular']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);
            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);
            $data['municipiosEstado1']=$this->ClienteExterno->getMunicipios($data['estado1']['idEstado']);
            $data['municipiosEstado2']=$this->ClienteExterno->getMunicipios($data['estado2']['idEstado']);
            $data['coloniasMunicipio1']=$this->ClienteExterno->getColonias($data['municipio1']['idMunicipio']);
            $data['coloniasMunicipio2']=$this->ClienteExterno->getColonias($data['municipio2']['idMunicipio']);

        }
        else
        {
            $data['detalles'] = $this->ClienteExterno->getDetalleClienteMoral($idUsuario);
            $data['colonia1']=$this->ClienteExterno->getRegion($data['detalles']['idRegionRepresentanteLegal']);
            $data['municipio1']=$this->ClienteExterno->getMunicipio($data['colonia1']['idMunicipio']);
            $data['estado1']=$this->ClienteExterno->getEstado($data['municipio1']['idEstado']);
            $data['colonia2']=$this->ClienteExterno->getRegion($data['detalles']['idRegionFiscal']);
            $data['municipio2']=$this->ClienteExterno->getMunicipio($data['colonia2']['idMunicipio']);
            $data['estado2']=$this->ClienteExterno->getEstado($data['municipio2']['idEstado']);
            $data['municipiosEstado1']=$this->ClienteExterno->getMunicipios($data['estado1']['idEstado']);
            $data['municipiosEstado2']=$this->ClienteExterno->getMunicipios($data['estado2']['idEstado']);
            $data['coloniasMunicipio1']=$this->ClienteExterno->getColonias($data['municipio1']['idMunicipio']);
            $data['coloniasMunicipio2']=$this->ClienteExterno->getColonias($data['municipio2']['idMunicipio']);
        }
		$data = $this->security->xss_clean($data);
        print $this->load->view("gridEditarClienteExternoModal", $data, TRUE);
    }

    function updateCliente($idUsuario, $idTipoCliente)
    {
        $nombre = $this->input->post("nombre");
        $usuario = $this->input->post("usuario");
        if ($idTipoCliente == 1)
        {
            $rfc=$this->input->post("rfc");
            $razonSocial=$this->input->post("razonSocial");
            $calleParticular=$this->input->post("calle1");
            $numeroParticular=$this->input->post("numero1");
            $numeroInteriorParticular=$this->input->post("numeroInterior1");
            $regionParticular=$this->input->post("colonia1");
            if(empty($regionParticular))
                $regionParticular=null;
            $calleFiscal=$this->input->post("calle2");
            $numeroFiscal=$this->input->post("numero2");
            $numeroInteriorFiscal=$this->input->post("numeroInterior2");
            $regionFiscal=$this->input->post("colonia2");
            if(empty($regionFiscal))
                $regionFiscal=null;
            $telefonoLocal=$this->input->post("telefonoLocal");
            $celular=$this->input->post("telefonoCelular");
            $referencia1=$this->input->post("referencia1");
            $referencia2=$this->input->post("referencia2");
            $this->ClienteExterno->updateClienteFisico($idUsuario, array(
                'nombreClienteFisico' => $nombre,
                'rfc' => $rfc,
                'razonSocial' => $razonSocial,
                'calleParticular' => $calleParticular,
                'numeroParticular' => $numeroParticular,
                'numeroInteriorParticular' => $numeroInteriorParticular,
                'idRegionParticular' => $regionParticular,
                'calleFiscal' => $calleFiscal,
                'numeroFiscal' => $numeroFiscal,
                'numeroInteriorFiscal' => $numeroInteriorFiscal,
                'idRegionFiscal' => $regionFiscal,
                'telefonoLocal' => $telefonoLocal,
                'telefonoCelular' => $celular,
                'referencia1' => $referencia1,
                'referencia2' => $referencia2
                ));
        }
        else
        {
            $rfc=$this->input->post("rfc");
            $razonSocial=$this->input->post("razonSocial");
            $nombreRepresentanteLegal=$this->input->post("nombreRepresentante");
            $calleParticular=$this->input->post("calle1");
            $numeroParticular=$this->input->post("numero1");
            $numeroInteriorParticular=$this->input->post("numeroInterior1");
            $regionParticular=$this->input->post("colonia1");
            if(empty($regionParticular))
                $regionParticular=null;
            $calleFiscal=$this->input->post("calle2");
            $numeroFiscal=$this->input->post("numero2");
            $numeroInteriorFiscal=$this->input->post("numeroInterior2");
            $regionFiscal=$this->input->post("colonia2");
            if(empty($regionFiscal))
                $regionFiscal=null;
            $telefonoLocal=$this->input->post("telefonoLocal");
            $celular=$this->input->post("telefonoCelular");
            $referencia1=$this->input->post("referencia1");
            $referencia2=$this->input->post("referencia2");
            $this->ClienteExterno->updateClienteMoral($idUsuario, array(
                'nombreClienteMoral' => $nombre,
                'rfc' => $rfc,
                'razonSocial' => $razonSocial,
                'nombreRepresentanteLegal' => $nombreRepresentanteLegal,
                'calleRepresentanteLegal' => $calleParticular,
                'numeroRepresentanteLegal' => $numeroParticular,
                'numeroInteriorRepresentanteLegal' => $numeroInteriorParticular,
                'idRegionRepresentanteLegal' => $regionParticular,
                'calleFiscal' => $calleFiscal,
                'numeroFiscal' => $numeroFiscal,
                'numeroInteriorFiscal' => $numeroInteriorFiscal,
                'idRegionFiscal' => $regionFiscal,
                'telefonoLocal' => $telefonoLocal,
                'telefonoCelular' => $celular,
                'referencia1' => $referencia1,
                'referencia2' => $referencia2
            ));
        }

        $this->ClienteExterno->updateCliente($idUsuario, array('usuario' => $usuario));
    }

    function verificarContrasena()
    {   
        
        $pass = $this->ClienteExterno->verificarPassword($this->input->post("password"));
        echo $pass;
    }

    function cambiarContrasena($idUsuario)
    {
        $this->load->library('encryption');
        $key = bin2hex($this->encryption->create_key(16));
        $password = $this->input->post("password");
        $password = $this->encryption->encrypt($password);
        $this->ClienteExterno->updateCliente($idUsuario, array('password' => $password));
        echo 1;
    }
    function getMunicipios($idEstado=0)
    {
        echo json_encode($this->ClienteExterno->getMunicipios($idEstado));
    }
    function getColonias($idMunicipio=0)
    {
        echo json_encode($this->ClienteExterno->getColonias($idMunicipio));
    }
}