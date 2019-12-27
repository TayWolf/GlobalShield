<?php


class CrudFactura extends CI_Controller
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

        $this->load->model("Factura");
    }
    function index()
    {
        $this->load->model("Permisos");
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 15);
        $data['facturas']=$this->Factura->getFacturasClientes();
        $data['urlCliente']=$this->config->item('base_url_cliente');
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewFacturas", $data, true);
    }
    function facturar()
    {

        $folio = $this->input->post("folioFacturacion");
        if (empty($folio))
        {
            echo json_encode(array('Error', 'No has especificado un folio', 'error'));
            return;
        }
        if(strlen($folio)<8)
        {
            echo json_encode(array('Error', 'Folio no válido', 'warning'));
            return;
        }
        if(!is_numeric($folio))
        {
            echo json_encode(array('Error', 'El folio solo debe contener números', 'error'));
            return;
        }
        //METER Más Condiciones
        $fecha=substr($folio, 0, 8);
        $idContrato=substr($folio, 8, strlen($folio));
        //Checar que el contrato pertenezca al cliente que esta loggeado y que no haya sido facturado anteriormente

        //Si pasa la verificacion, entonces continua con la facturacion
        if(!$this->Factura->verificar($idContrato, $fecha))
        {
            echo json_encode(array('Error', 'Este folio ya no puede ser facturado', 'warning'));
            return;
        }


        $data['datosSucursal']=$this->Factura->getDatosSucursal($idContrato);

        $data['datosCliente']=$this->Factura->getDatosCliente($idContrato);
		$data = $this->security->xss_clean($data);

        $json=json_decode($this->load->view("JSONFactura", $data, true), true);

        $rest=new CurlRequest();


        $resultado=$rest->sendPost($json);
        $resultado=json_decode($resultado, true);
        //echo json_encode($resultado);
        //Para ingresar al PDF  usar: $resultado['CFDITimbrado']['Respuesta']['PDF']
        //Para ingresar al CFDIXML usar: $resultado['CFDITimbrado']['Respuesta']['CFDIXML']
        //Para ingresar al TimbreXML usar: $resultado['CFDITimbrado']['Respuesta']['TimbreXML']

        $id=uniqid();
        $carpetaCliente=$this->config->item('base_url_carpeta_cliente');
        $pdf_decodificado=base64_decode($resultado['CFDITimbrado']['Respuesta']['PDF']);
        $nombrePDF="../".$carpetaCliente.'/assets/Facturacion/Factura_'.$id.'.pdf';
        $pdf = fopen ($nombrePDF,'w');
        fwrite ($pdf,$pdf_decodificado);
        fclose ($pdf);

        $XML_decodificado=base64_decode($resultado['CFDITimbrado']['Respuesta']['CFDIXML']);
        $nombreXML="../".$carpetaCliente.'/assets/Facturacion/XML_'.$id.'.xml';
        $XML= fopen ($nombreXML,'w');
        fwrite ($XML,$XML_decodificado);
        fclose ($XML);


        $this->Factura->insertFactura(array(
            'folioFactura' => $folio,
            'idContrato' => $idContrato,
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i:s"),
            'archivoXML' =>'XML_'.$id.'.xml',
            'archivoPDF' =>'Factura_'.$id.'.pdf',
        ));

        echo json_encode(array('Bien!', 'Se ha generado la factura!', 'success'));
        // $this->load->helper("download");
        //   force_download($nombrePDF, null);
    }
    function enviarFacturaCorreo()
    {
        $correo=$this->input->post("emailFactura");
        $folio=$this->input->post("folioFacturaCorreo");
        //Verificar que el folio pertenezca al usuario
        if($this->Factura->verificarFolioUsuario($folio))
        {
            $factura=$this->Factura->getFactura($folio);
            $this->load->library("email");
            $vista = $this->load->view('viewEmailFactura', null, TRUE);
            $this->email->from('sistemaGlobalshield@gmail.com', ("GLOBAL SHIELD"));
            $this->email->to($correo);
            $this->email->subject(('Factura de global shield'));
            $this->email->message(($vista));

            $carpetaCliente=$this->config->item('base_url_carpeta_cliente');
            $this->email->attach('../'.$carpetaCliente.'/assets/Facturacion/'.$factura['archivoPDF']);
            if(!$this->email->send())
            {
                echo json_encode(array('Error', 'No se ha podido enviar esta factura. Intentalo más tarde', 'error'));

            }
            else
                echo json_encode(array('¡Exito!', 'Se ha enviado la factura al correo solicitado', 'success'));
            return;
        }
        else
        {
            echo json_encode(array('Error', 'No se puede enviar esta factura', 'error'));
        }


    }
}
class CurlRequest
{

    public function sendPost($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://wcfpruebas.facturoporti.com.mx/Timbrado/Servicios.svc/ApiTimbrarCFDI");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(($data)));
        $response = curl_exec($ch);
        curl_close($ch);
        if(!$response) {
            return false;
        }else{
            return $response;
        }
    }

}
