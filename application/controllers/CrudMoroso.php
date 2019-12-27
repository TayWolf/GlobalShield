<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use tcpdf\tcpdf;
class CrudMoroso extends CI_Controller
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

        $this->load->model('Contrato');
        $this->load->helper("download");
    }
    public function index()
    {
        $this->load->model("Permisos");
        $data['contratos'] = $this->Contrato->getMorosos();
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 11);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoMorosos', $data, TRUE);

    }


    function getCotitularesContrato($idContrato)
    {
        echo json_encode($this->Contrato->getCotitularesContrato($idContrato));
    }
    function getContrato($idContrato)
    {
        echo json_encode($this->Contrato->getContrato($idContrato));
    }

    function getDatosTitular($idContrato)
    {
        echo json_encode($this->Contrato->getClienteContrato($idContrato));
    }

    function generacionContrato($idContrato)
    {
        $pdf=new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Auto breaks de página
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetSubject('Contratos');
        $pdf->SetKeywords('Contratos, Clientes');
        $pdf->AddPage('P', 'LETTER');
        //fin de la configuración del documento

        //inicio del contenido del documento
        $data['cotitulares']=$this->Contrato->getCotitularesContrato($idContrato);
        $data['beneficiarios']=$this->Contrato->getBeneficiariosContrato($idContrato);
        $data['contrato']=$this->Contrato->getContrato($idContrato);
        $data['datosCliente']=$this->Contrato->getDatosCliente($idContrato);
        $data['datosSucursal']=$this->Contrato->getDatosSucursal($idContrato);
		$data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionContratoPDF', $data, TRUE);

        //fin del contenido del documento
        // Escribir el contenido
        $pdf->writeHTML($datosDocumentoPDF, false, false, false, false, '');
        $pdf->Output('Contrato.pdf', 'I');

    }
    function traerContratoFirmado($idContrato)
    {
        echo json_encode($this->Contrato->getArchivoFirmado($idContrato));
    }

}
?>