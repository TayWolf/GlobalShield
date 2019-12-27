<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use tcpdf\tcpdf;

class CrudMundoCaja extends CI_Controller
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

        $this->load->model("MundoCaja");
        $this->load->helper("download");
    }

    function index()
    {
        $this->load->model("Permisos");
        $data['permisos'] = $this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 10);
        $data['mundoCajas'] = $this->MundoCaja->getMundoCajas();
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewTodoMundoCaja", $data, TRUE);
    }

    function eliminarCaja()
    {
        $idMundoCaja = $this->input->post("idMundoCaja");
        $this->MundoCaja->deleteCaja($idMundoCaja);
    }

    function altaCaja()
    {
        $data['sucursales'] = $this->MundoCaja->getSucursales();
        $data['tiposCaja'] = $this->MundoCaja->getTiposCaja();
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaMundoCaja", $data, TRUE);
    }
    function editarCaja($idMundoCaja)
    {
        $data['mundoCaja']=$this->MundoCaja->getMundoCaja($idMundoCaja);
        $data['sucursales'] = $this->MundoCaja->getSucursales();
        $data['tiposCaja'] = $this->MundoCaja->getTiposCaja();
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewEdicionMundoCaja", $data, TRUE);

    }

    function insertMundoCajaIndividual()
    {
        $idSucursal=$this->input->post("idSucursal");
        $idTipoCaja=$this->input->post("tipoCaja");
        $pasillo=trim($this->input->post("pasillo"));
        $numeroCaja=trim($this->input->post("numeroCaja"));
        $this->MundoCaja->insertCaja(array(
            'idSucursal' => $idSucursal,
            'pasillo' => $pasillo,
            'numeroCaja' => $numeroCaja,
            'idTipoCaja' => $idTipoCaja,
            'status' => 0
        ));
    }
    function insertMundoCajaMultiple()
    {
        $idSucursal=$this->input->post("idSucursal");
        $idTipoCaja=$this->input->post("tipoCaja");
        $pasillo=trim($this->input->post("pasillo"));
        $inicio=trim($this->input->post("numeroCajaInicio"));
        $fin=trim($this->input->post("numeroCajaFin"));
        $cajasError="";
        for ($inicio; $inicio<=$fin; $inicio++)
        {
            $numeroCaja=$inicio;
            $existencia=$this->MundoCaja->verificarExistenciaCaja($idSucursal, $pasillo, $numeroCaja);
            if(empty($existencia))
                $this->MundoCaja->insertCaja(array(
                    'idSucursal' => $idSucursal,
                    'pasillo' => $pasillo,
                    'numeroCaja' => $numeroCaja,
                    'idTipoCaja' => $idTipoCaja,
                    'status' => 0
                ));
            else
            {
                $cajasError.="$pasillo$numeroCaja, ";
            }

        }
        if(!empty($cajasError))
        {
            echo "Las siguientes cajas no se dieron de alta porque ya existian en el sistema: ".rtrim($cajasError, ", ");
        }


    }
    function updateMundoCaja($idMundoCaja)
    {
        $idSucursal=$this->input->post("idSucursal");
        $idTipoCaja=$this->input->post("tipoCaja");
        $pasillo=trim($this->input->post("pasillo"));
        $numeroCaja=trim($this->input->post("numeroCaja"));

        $existencia=$this->MundoCaja->verificarExistenciaCaja($idSucursal, $pasillo, $numeroCaja, $idMundoCaja);
        if(empty($existencia))
        {
            $this->MundoCaja->updateCaja($idMundoCaja, array(
                'idSucursal' => $idSucursal,
                'pasillo' => $pasillo,
                'numeroCaja' => $numeroCaja,
                'idTipoCaja' => $idTipoCaja,
            ));
            echo "1";
        }
        else
        {
            echo "2";
        }
    }
    function getInformacionCajaOcupada($idMundoCaja)
    {
        echo json_encode($this->MundoCaja->getInformacionCajaOcupada($idMundoCaja));
    }
    function enviarCajaMantenimiento()
    {
        $idCaja=$this->input->post("cajaSeleccionadaMantenimiento");
        $motivo=$this->input->post("motivoMantenimiento");
        $idUsuario=$this->session->userdata("idUser");
        $fecha=date("Y-m-d");
        $idMantenimiento=$this->MundoCaja->insertSolicitudMantenimiento(array(
            'idMundoCaja' => $idCaja,
            'motivo' => $motivo,
            'idUsuarioSolicitud' => $idUsuario,
            'fechaSolicitud' => $fecha
        ));
        //Cuando una caja esta en reparación, el statusReparacion es 1
        $this->MundoCaja->updateCaja($idCaja, array('statusReparacion' => 1));

        $this->enviarCorreoMantenimiento($idMantenimiento);

    }
    function enviarCorreoMantenimiento($idTicketMantenimiento)
    {


        $data['caja']=$this->MundoCaja->getDatosCorreoMantenimiento($idTicketMantenimiento);
        $data['idTicketMantenimiento']=$idTicketMantenimiento;

        $this->load->library("email");
        $config['mailtype']='html';
        $this->email->initialize($config);
        $vista = $this->load->view('viewEmailMantenimientoCaja', $data, TRUE);


        $tecnicos=$this->MundoCaja->getTecnicos();
        foreach ($tecnicos as $tecnico)
        {
            //echo json_encode($tecnico);
            $this->email->from('sistemaGlobalshield@gmail.com', utf8_decode("GLOBAL SHIELD"));
            $this->email->to($tecnico['correoTecnico']);
            $this->email->subject(('Nueva caja en mantenimiento'));
            $this->email->message(($vista));
            if(!$this->email->send())
                print json_encode("Error al enviar el correo");
            else
                print json_encode("Correo enviado");

        }

    }
    function quitarReparacionCaja($idMundoCaja)
    {
        //la quita de reparacion
        $this->MundoCaja->updateCaja($idMundoCaja, array('statusReparacion' => 0));
        //termina el ticket
        $this->MundoCaja->updateSolicitudMantenimiento($idMundoCaja, array('fechaTermino' => date("Y-m-d")));
    }

    function generacionReporteMantenimiento()
    {
        $pdf=new \TCPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setHeaderMargin(0);
        // Auto breaks de página        
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetSubject('Cajas en mantenimiento');
        $pdf->SetKeywords('Cajas, Mantenimiento, Globalshield');
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', "", 12, "", false);
        //fin de la configuración del documento

        //inicio del contenido del documento
        $data['cajasMantenimiento']=$this->MundoCaja->getCajasMantenimiento();
        $datosDocumentoPDF=$this->load->view('exportacionReporteMantenimientoPDF', $data, TRUE);

        //fin del contenido del documento

        // Escribir el contenido
        $pdf->writeHTML($datosDocumentoPDF, false, false, false, false, 'center');


        $pdf->Output('Mantenimiento-Cajas.pdf', 'I');

    }

}