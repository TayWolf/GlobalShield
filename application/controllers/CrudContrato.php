<?php /** @noinspection PhpUndefinedNamespaceInspection */
defined('BASEPATH') OR exit('No direct script access allowed');
use tcpdf\tcpdf;
class CrudContrato extends CI_Controller
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
        $data['contratos'] = $this->Contrato->getContratos();
        //Estos son los permisos de contratos
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 4);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoContratos', $data, TRUE);

    }
    function contratosTerminados()
    {
        $this->load->model("Permisos");
        $data['contratos'] = $this->Contrato->getContratosTerminados();
        //Estos son los permisos de contratos
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 14);
		$data = $this->security->xss_clean($data);
        print $this->load->view('viewTodoContratosTerminados', $data, TRUE);
    }

    function formAltaContrato()
    {
        $this->load->model("Permisos");

        //Estos son los permisos para dar de alta clientes ó editarlos
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 6);
        $data['permisosTarjeta']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 16);
        $data['sucursales']=$this->Contrato->getSucursales();
        $data['membresias']=$this->Contrato->getMembresias();

        $data['clientes']=$this->Contrato->getClientes();
        $data['seguros']=$this->Contrato->getSeguros();

        /*=============================
        =            Caché            =
        =============================*/
        /* -------------------------Instrcucciones------------------------------  
        Paso 1. Cargar la cache de CodeIgniter
        Paso2.  Obtener id del usuario que está logeado
        Paso 3. Checar que el item de cache (contador.$idUsuario) exista
            Paso 3.1 Si existe incrementarlo y guardarlo en una variable
            Paso 3.2 Si no existe inicializarlo como 1 y guardarlo en una variable
        Paso 4. Enviar esa variable al Alta
        Paso 5. Pintar Fecha si guiones, idUsuario - Variable del contador 
        ------------------------------------------------------------------------*/

        $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
        $idUsuario=$this->session->userdata("idUser");
        if (!$this->cache->get('CacheUsuario'.$idUsuario))
        {
            $this->cache->save('CacheUsuario'.$idUsuario, 1, 43200); // 1 día    
        }
        else
        {
            $this->cache->increment('CacheUsuario'.$idUsuario);
        }

        $FolioFT = $this->cache->get('CacheUsuario'.$idUsuario);
        $data['FolioFT'] = $FolioFT;

        /*=====  End of Caché  ======*/
		$data = $this->security->xss_clean($data);
        print $this->load->view("formAltaContrato", $data, TRUE);


    }
    function verDetalleContrato($idContrato)
    {

        $data['cotitulares']=$this->Contrato->getCotitularesContrato($idContrato);
        $data['beneficiarios']=$this->Contrato->getBeneficiariosContrato($idContrato);
        $data['tarjetas']=$this->Contrato->getTarjeta($idContrato);
        $data['contrato']=$this->Contrato->getContrato($idContrato);
        $data['contratos'] = $this->Contrato->getContratos();
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewDetalleContratos", $data, TRUE);
    }
    function verEdicionContrato($idContrato)
    {
        $this->load->model("Permisos");

        //Estos son los permisos para dar de alta clientes ó editarlos
        $data['permisos']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 6);
        $data['permisosTarjetas']=$this->Permisos->getPermisosUsuarioModulo($this->session->userdata("idTipo"), 16);
        $data['idContrato']=$idContrato;
        $data['contratos'] = $this->Contrato->getContratos();
        $data['sucursales']=$this->Contrato->getSucursales();
        $data['membresias']=$this->Contrato->getMembresias();
        $data['contrato']=$this->Contrato->getContrato($idContrato);

        $data['clientes']=$this->Contrato->getClientes();
        $data['seguros']=$this->Contrato->getSeguros();
        $data['mundoCaja']=$this->Contrato->getMundoCaja($idContrato);

        /*=============================
        =            Caché            =
        =============================*/
        /* -------------------------Instrcucciones------------------------------  
        Paso 1. Cargar la cache de CodeIgniter
        Paso2.  Obtener id del usuario que está logeado
        Paso 3. Checar que el item de cache (contador.$idUsuario) exista
            Paso 3.1 Si existe incrementarlo y guardarlo en una variable
            Paso 3.2 Si no existe inicializarlo como 1 y guardarlo en una variable
        Paso 4. Enviar esa variable al Alta
        Paso 5. Pintar Fecha si guiones, idUsuario - Variable del contador 
        ------------------------------------------------------------------------*/

        $this->load->driver('cache',array('adapter' => 'apc', 'backup' => 'file'));
        $idUsuario=$this->session->userdata("idUser");
        if (!$this->cache->get('CacheUsuario'.$idUsuario))
        {
            $this->cache->save('CacheUsuario'.$idUsuario, 1, 43200); // 1 día    
        }
        else
        {
            $this->cache->increment('CacheUsuario'.$idUsuario);
        }

        $FolioFT = $this->cache->get('CacheUsuario'.$idUsuario);
        $data['FolioFT'] = $FolioFT;

        /*=====  End of Caché  ======*/
		$data = $this->security->xss_clean($data);
        print $this->load->view("viewEdicionContrato", $data, TRUE);
    }

    function getTipoCliente()
    {
        $idClienteExterno=$this->input->post("idClienteExterno");
        $cliente=$this->Contrato->getTipoCliente($idClienteExterno);
        echo json_encode($cliente);
    }
    function actualizarAutocomplete()
    {
        echo json_encode($this->Contrato->getClientes());
    }
    function cargarCajaMembresia($idMembresia)
    {
        echo json_encode($this->Contrato->getCajaMembresia($idMembresia));
    }
    function getPeriodos($idMembresia, $idTipoCaja)
    {
        echo json_encode($this->Contrato->getPeriodos($idMembresia, $idTipoCaja));
    }
    function cargarCosto($idCosto=null)
    {
        if(empty($idCosto))
            return;
        echo json_encode($this->Contrato->getCosto($idCosto));
    }
    function calcularFechaTermino($idCosto, $fechaAnterior)
    {
        $costo=$this->Contrato->getCosto($idCosto);
        $fechaHoy=date("Y-m-d");

        //Si el contrato aun no vence
        if(strtotime($fechaHoy)<strtotime($fechaAnterior))
        {
            $tiempoRestante=strtotime($fechaAnterior)-strtotime($fechaHoy);
            $nuevaFecha=((date("Y-m-d", strtotime('+'.$costo['numeroAnios'].' year '.$costo['numeroMeses'].' month '.$costo['numeroDias'].' day')+$tiempoRestante)));
        }
        else if(strtotime($fechaHoy)>=strtotime($fechaAnterior))
        {
            $nuevaFecha=((date("Y-m-d", strtotime('+'.$costo['numeroAnios'].' year '.$costo['numeroMeses'].' month '.$costo['numeroDias'].' day'))));
        }
        echo json_encode($nuevaFecha);
        return $nuevaFecha;

    }

    function getPasillos($idSucursal, $idTipoCaja)
    {
        echo json_encode($this->Contrato->getPasillos($idSucursal, $idTipoCaja));
    }
    function cargarCajasPasillo()
    {
        $idSucursal=$this->input->post("idSucursal");
        $idTipoCaja=$this->input->post("idTipoCaja");
        $idPasillo=$this->input->post("idPasillo");
        echo json_encode($this->Contrato->getMundoCajas($idSucursal, $idTipoCaja, $idPasillo));
    }
    function insertContrato()
    {
        //Verifica que los folios de las tarjetas que insertará el usuario sean únicos
        $numeroTarjeta=$this->input->post("numeroTarjeta");
        for($i=0; $i<$numeroTarjeta; $i++)
        {
            $Folio=$this->input->post("Folio".$i);
            if($this->Contrato->verificarExistenciaTarjeta($Folio))
            {
                header('HTTP/1.1 500 Internal Server');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => "El folio de tarjeta $Folio ya esta registrado", 'code' => 1337)));
            }
        }
        $titular=$this->input->post("idTitular0");
        $idMembresia=$this->input->post("idMembresia");
        $idMundoCaja=$this->input->post("cajaSeleccionada");
        $idSeguro=$this->input->post("idSeguro");
        //Esta condición se cumple si el valor del idSeguro es 0. No puede haber ceros en la foranea, pero si puede haber nulls
        if(empty($idSeguro))
            $idSeguro=null;
        $costoContrato=$this->input->post("costoContrato");
        $depositoGarantia=$this->input->post("depositoGarantia");
        $formaPago=$this->input->post("formaPago");
        $fechaRegistro=date("Y-m-d");
        $idCosto=$this->input->post("idPeriodo");
        $costo=$this->Contrato->getCosto($idCosto);
        $fechaTermino=date('Y-m-d', strtotime('+'.$costo['numeroAnios'].' year '.$costo['numeroMeses'].' month '.$costo['numeroDias'].' day'));

        //Ocupa la caja y da de alta el contrato
        $this->Contrato->actualizarStatusCaja($idMundoCaja, array('status' => 1));
        $idContrato=$this->Contrato->insertContrato(array(
            'idTitular' => $titular,
            'idMundoCaja' => $idMundoCaja,
            'idMembresia' => $idMembresia,
            'idSeguro' => $idSeguro,
            'idCosto' => $idCosto,
            'fechaRegistro' => $fechaRegistro,
            'fechaTermino' => $fechaTermino,
            'costoCaja' => $costoContrato,
            'depositoGarantia' => $depositoGarantia,
            'formaPago'=> $formaPago
        ));
        $this->Contrato->insertHistorialRenovacion(array(
            'idContrato' => $idContrato,
            'idCosto' => $idCosto,
            'fecha' => date("Y-m-d"),
            'fechaInicio' => $fechaRegistro,
            'fechaFin' => $fechaTermino,
            'precioOriginal' => $costoContrato
        ));
        //da de alta los cotitulares. Inicia en 1 porque el 0 es el titular del contrato
        $numeroCotitulares=$this->input->post("numeroCotitulares");
        for($i=1; $i<$numeroCotitulares; $i++)
        {
            $idCotitular=$this->input->post("idTitular".$i);
            if(!empty($idCotitular))
            {
                $this->Contrato->insertCotitular(array(
                    'idContrato' => $idContrato,
                    'idCliente' => $idCotitular
                ));
            }
        }
        //inserta las tarjetas
        $numeroTarjeta=$this->input->post("numeroTarjeta");
        for($i=0; $i<$numeroTarjeta; $i++)
        {
            $Folio=$this->input->post("Folio".$i);
            $folioFT=$this->input->post("folioFT");
            $cboxFactura=$this->input->post("cbox".$i);
            if(!$cboxFactura)
            {
                $folioFT=null;
            }
            if(!empty($Folio))
            {
                $this->Contrato->insertTarjetaContratos(array(
                    'idContrato' => $idContrato,
                    'FolioTarjeta' => $Folio,
                    'FolioFacturacion' => $folioFT,
                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s")
                ));
            }
        }
        echo $this->input->post('folioFT');

        //inserta los beneficiarios
        $numeroBeneficiarios=$this->input->post("numeroBeneficiarios");
        for($i=0; $i<$numeroBeneficiarios; $i++)
        {
            $nombreBeneficiario=$this->input->post("beneficiario".$i);
            $fechaNacimiento=$this->input->post("fechaNacimientoBeneficiario".$i);
            $telefono=$this->input->post("telefonoBeneficiario".$i);
            if(!empty($nombreBeneficiario))
            {
                $this->Contrato->insertBeneficiario(array(
                    'idContrato' => $idContrato,
                    'nombreBeneficiario' => $nombreBeneficiario,
                    'fechaNacimiento' => $fechaNacimiento,
                    'telefono' => $telefono
                ));
            }
        }
        echo "$idContrato";
    }

    function updateContrato()
    {

        //Verifica que las nuevas tarjetas no esten en la base de datos
        $numeroTarjeta=$this->input->post("numeroTarjeta");
        for($i=0; $i<$numeroTarjeta; $i++)
        {
            $Folio=$this->input->post("Folio".$i);
            if($this->Contrato->verificarExistenciaTarjeta($Folio))
            {
                header('HTTP/1.1 500 Internal Server');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => "El folio de tarjeta $Folio ya esta registrado", 'code' => 1337)));
            }
        }

        //Desocupa la caja
        $idContrato=$this->input->post("idContrato");
        $mundoCaja=$this->Contrato->getMundoCaja($idContrato);
        $this->Contrato->desocuparCaja($mundoCaja['idMundoCaja']);
        //recolecta los datos del post
        $titular=$this->input->post("idTitular0");
        $idMembresia=$this->input->post("idMembresia");
        $idMundoCaja=$this->input->post("cajaSeleccionada");
        $idSeguro=$this->input->post("idSeguro");
        //Esta condición se cumple si el valor del idSeguro es 0. No puede haber ceros en la foranea, pero si puede haber nulls
        if(empty($idSeguro))
            $idSeguro=null;
        $costoContrato=$this->input->post("costoContrato");
        $depositoGarantia=$this->input->post("depositoGarantia");
        $idCosto=$this->input->post("idPeriodo");
        $formaPago=$this->input->post("formaPago");

        //Ocupa la caja y actualiza el contrato
        $this->Contrato->actualizarStatusCaja($idMundoCaja, array('status' => 1));
        $this->Contrato->updateContrato($idContrato, array(
            'idTitular' => $titular,
            'idMundoCaja' => $idMundoCaja,
            //'idMembresia' => $idMembresia, Ya no sirve esta línea porque el costo depende de la renovación
            'idSeguro' => $idSeguro,
            //'idCosto' => $idCosto, Ya no sirve esta línea porque el costo depende de la renovación
            //'costoCaja' => $costoContrato, Ya no sirve esta línea porque el costo depende de la renovación
            'depositoGarantia' => $depositoGarantia,
            'formaPago' => $formaPago
        ));
        //elimina  los cotitulares existentes
        $this->Contrato->deleteCotitulares($idContrato);
        //da de alta los cotitulares. Inicia en 1 porque el 0 es el titular del contrato
        $numeroCotitulares=$this->input->post("numeroCotitulares");
        for($i=1; $i<$numeroCotitulares; $i++)
        {
            $idCotitular=$this->input->post("idTitular".$i);
            if(!empty($idCotitular))
            {
                $this->Contrato->insertCotitular(array(
                    'idContrato' => $idContrato,
                    'idCliente' => $idCotitular,
                ));
            }
        }
        //elimina los beneficiarios
        $this->Contrato->deleteBeneficiarios($idContrato);
        //inserta los beneficiarios
        $numeroBeneficiarios=$this->input->post("numeroBeneficiarios");
        for($i=0; $i<$numeroBeneficiarios; $i++)
        {
            $nombreBeneficiario=$this->input->post("nombreBeneficiario".$i);
            $fechaNacimiento=$this->input->post("fechaNacimientoBeneficiario".$i);
            $telefono=$this->input->post("telefonoBeneficiario".$i);
            if(!empty($nombreBeneficiario))
            {
                $this->Contrato->insertBeneficiario(array(
                    'idContrato' => $idContrato,
                    'nombreBeneficiario' => $nombreBeneficiario,
                    'fechaNacimiento' => $fechaNacimiento,
                    'telefono' => $telefono
                ));
            }
        }
        echo "1";


        //ELimina las tarjetas anteriores
        /*
        $numeroTarjetasAnteriores=$this->input->post("numeroTarjetasAnteriores");
        for($i=0; $i<$numeroTarjetasAnteriores; $i++)
        {
            $esValida=$this->input->post("tarjetaAnteriorActiva".$i);
            $folioTarjetaAnterior=$this->input->post("FolioTarjetaAnterior".$i);
            if(empty($esValida))
            {
                //Si esta tarjeta fue eliminada en la vista, entonces eliminarla de la base de datos
                $this->Contrato->deleteTarjetaContrato($idContrato, $folioTarjetaAnterior);
            }
        }
           */
        //Da de alta nuevas tarjetas
        $numeroTarjeta=$this->input->post("numeroTarjeta");
        for($i=0; $i<$numeroTarjeta; $i++)
        {
            $cbox=$this->input->post("cbox".$i);
            $Folio=$this->input->post("Folio".$i);
            if(!empty($cbox))
            {
                $this->Contrato->insertTarjetaContratos(
                array(
                    'idContrato' => $idContrato,
                    'FolioTarjeta' => $Folio,
                    'FolioFacturacion' => $this->input->post("nuevoFolioFacturacion"),
                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s")
                ));
            }
            else
            {
                $this->Contrato->insertTarjetaContratos(
                array(
                    'idContrato' => $idContrato,
                    'FolioTarjeta' => $Folio,
                    'FolioFacturacion' => null,
                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s")
                ));
            }
        }

        echo "$Folio";
    }
    function getCotitularesContrato($idContrato)
    {
        echo json_encode($this->Contrato->getCotitularesContrato($idContrato));
    }
    function getContrato($idContrato)
    {
        echo json_encode($this->Contrato->getContrato($idContrato));
    }
    function borrarContrato()
    {
        $idContrato=$this->input->post("idContrato");
        $contrato=$this->Contrato->getContrato($idContrato);
        $idMundoCaja=$contrato['idMundoCaja'];
        $this->Contrato->actualizarStatusCaja($idMundoCaja, array('status' => 0));
        $this->Contrato->eliminarContrato($idContrato);
    }
    function getDatosTitular($idContrato)
    {
        echo json_encode($this->Contrato->getClienteContrato($idContrato));
    }
    function getBeneficiariosContrato($idContrato)
    {
        echo json_encode($this->Contrato->getBeneficiariosContrato($idContrato));
    }
    function getTarjeta($idContrato)
    {
        echo json_encode($this->Contrato->getTarjeta($idContrato));
    }
    function generacionContrato($idContrato)
    {
        //inicio del contenido del documento
        $data['cotitulares']=$this->Contrato->getCotitularesContrato($idContrato);
        $data['beneficiarios']=$this->Contrato->getBeneficiariosContrato($idContrato);
        $data['tarjeta']=$this->Contrato->getTarjeta($idContrato);
        $data['contrato']=$this->Contrato->getContrato($idContrato);
        $data['datosCliente']=$this->Contrato->getDatosCliente($idContrato);
		$data['seguros']=$this->Contrato->getSeguros();
		
        $data['datosSucursal']=$this->Contrato->getDatosSucursal($idContrato);
        //getComprobantesPago($idContrato) tambien trae el historial de renovación de un contrato
        $data['historialesRenovacion']=$this->Contrato->getComprobantesPago($idContrato);
		$data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionContratoPDF', $data, TRUE);
        $datosClientePDF=$this->load->view('exportacionDatosClienteContratoPDF', $data, TRUE);
        $esPersonaFisica=$this->Contrato->getTipoCliente($data['contrato']['idClienteExterno']);

        //fin del contenido del documento
        //generación del PDF
        $pdf=new MYPDF($datosClientePDF);

        // remove default header/footer
        $pdf->setPrintHeader(false);
        //$pdf->setPrintFooter(false);

        // Auto breaks de página
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetSubject('Contratos');
        $pdf->SetKeywords('Contratos, Clientes');
        $pdf->AddPage('P', 'LETTER');
        //fin de la configuración del documento


        // Escribir el contenido
        $pdf->writeHTML($datosDocumentoPDF, false, false, false, false, '');

        if(sizeof($data['beneficiarios'])<5)
            $pdf->AddPage();

        /*clausulas del contrato*/
        // ---------------------------------------------------------
        $pdf->writeHTML("<p style=\"text-align: center;\"><b><span style=\"font-size: 7.5pt;\">&nbsp;CONTRATO DE PRESTACI&Oacute;N DE SERVICIOS DE CAJAS DE SEGURIDAD DE SOCIEDAD MERCANTIL</span></b></p>", false, false, false, false, '');
        $pdf->resetColumns();
        $pdf->setEqualColumns(2, 90);
        $pdf->selectColumn();
        if($esPersonaFisica==1)
            $content = $this->load->view("exportacionClausulasPersonaFisicaPDF", $data, true);
        else
            $content = $this->load->view("exportacionClausulasPersonaMoralPDF", $data, true);
        //print $content;
        $pdf->writeHTML($content, false, false, false, false, '');
        $pdf->resetColumns();


        $pdf->Output('Contrato.pdf', 'I');

    }
    function traerContratoFirmado($idContrato)
    {
        echo json_encode($this->Contrato->getArchivoFirmado($idContrato));
    }
    function subirContratoFirmado($idContrato)
    {
        $contrato=$this->Contrato->getArchivoFirmado($idContrato);
        $nombreArchivo=$this->subirDocumento("contratoFirmado");
        if($nombreArchivo)
        {
            $this->borrarArchivo($contrato['archivoFirmado']);
            $this->Contrato->updateContrato($idContrato, array('archivoFirmado' => $nombreArchivo));
        }

    }

    function subirDocumento($nombrePOST, $ruta=null)
    {
        if(empty($ruta))
            $ruta = "assets/fileUpload/contratos/";
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
            echo "no se pudo mover el archivo a " . $target;
            return null;
        }


    }
    function generacionTicket($idContrato)
    {
        $medidas = array(80, 200); // Ajustar aqui segun los milimetros necesarios;
        $pdf=new \TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setHeaderMargin(0);
        // Auto breaks de página
        $pdf->SetMargins(0,0,0);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetSubject('Ticket');
        $pdf->SetKeywords('Ticket, Clientes, Globalshield');
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', "", 12, "", false);
        //fin de la configuración del documento

        //inicio del contenido del documento
        $data['cotitulares']=$this->Contrato->getCotitularesContrato($idContrato);
        $data['beneficiarios']=$this->Contrato->getBeneficiariosContrato($idContrato);
        $data['contrato']=$this->Contrato->getContrato($idContrato);
        $data['tarjeta']=$this->Contrato->getTarjeta($idContrato);
        $data['datosCliente']=$this->Contrato->getDatosCliente($idContrato);
        $data['datosSucursal']=$this->Contrato->getDatosSucursal($idContrato);
        $data['renovaciones']=$this->Contrato->getComprobantesPago($idContrato);
        $data['numeroRenovaciones']=sizeof($data['renovaciones']);
        //TODO AGREGAR CONDICION PARA QUE DIGA RENOVACION O PERIODO
		$data = $this->security->xss_clean($data);
        $datosDocumentoPDF=$this->load->view('exportacionTicketPDF', $data, TRUE);

        //fin del contenido del documento

        // Escribir el contenido
        $pdf->writeHTML($datosDocumentoPDF, false, false, false, false, 'center');


        $pdf->Output('Ticket.pdf', 'I');

    }
    function borrarArchivo($archivo, $rutaDocumentos=null)
    {
        if(empty($rutaDocumentos))
            $rutaDocumentos = "assets/fileUpload/contratos/";
        if(!empty($archivo))
            unlink($rutaDocumentos . $archivo);
    }
    //Esta función establece un contrato en morosos
    function enviarContratoMorosos($idContrato, $status=1)
    {
        $this->Contrato->updateContrato($idContrato, array('statusFinalizado' => $status));
        if($status==1)
        {
            $swal[0]="Exito";
            $swal[1]="Se ha enviado el contrato a morosos";
            $swal[2]="success";
            $swal[4]=true;
            echo json_encode($swal);
        }
        else
        {
            $swal[0]="Exito";
            $swal[1]="Se ha recuperado el contrato";
            $swal[2]="success";
            $swal[4]=false;
            echo json_encode($swal);
        }
    }
    //Esta función sirve para enviar el contrato morosos
    function cambiarTerminoContrato($idContrato, $status)
    {
        //el statusFinalizado 0 es aún vigente, el statusFinalizado 1 es moroso, el statusFinalizado 2 es terminado
        $mundoCaja=$this->Contrato->getMundoCaja($idContrato);
        $swal=array();
        if($status==0)
        {
            //en caso de querer recuperar un contrato terminado, no se puede si un contrato ya tiene la caja del contrato seleccionado
            $contratosQueOcupanLaMismaCaja=$this->Contrato->recuperarCajaContrato($mundoCaja['idMundoCaja']);
            if(sizeof($contratosQueOcupanLaMismaCaja)<1)
            {
                $this->Contrato->updateContrato($idContrato, array('statusFinalizado' => $status));
                $this->Contrato->ocuparCaja($mundoCaja['idMundoCaja']);
                $swal[0]="Exito";
                $swal[1]="Se ha recuperado el contrato";
                $swal[2]="success";
                $swal[4]=false;

            }
            else
            {
                $swal[0]="Error";
                $swal[1]="No se puede recuperar la caja porque se encuentra ocupada por otro contrato";
                $swal[2]="error";
                $swal[4]=true;
            }
            echo json_encode($swal);
            return;
        }

        $this->Contrato->desocuparCaja($mundoCaja['idMundoCaja']);
        $this->Contrato->updateContrato($idContrato, array('statusFinalizado' => $status));
        $swal[0]="Exito";
        $swal[1]="Se ha terminado el contrato";
        $swal[2]="success";
        $swal[4]=true;
        echo json_encode($swal);
    }
    //esta función manda el contrato a los ocntratos terminados
    //los contratos terminados son aquellos en los que el cliente entregó la caja sin problemas y ya no se quiere saber más de este cliente
    function terminarContrato($idContrato)
    {
        $this->cambiarTerminoContrato($idContrato, 2);
    }
    function getCorreosEnviados($idContrato)
    {
        echo json_encode($this->Contrato->getCorreosEnviados($idContrato));
    }

    function reenviarCorreo($idContrato)
    {
        $this->load->library('email');
        $config['mailtype']='html';
        $this->email->initialize($config);
        $this->load->library('encryption');
        $this->key = bin2hex($this->encryption->create_key(16));

        $idUsuario=$this->session->userdata("idUser");
        if(!empty($idUsuario))
        {
            $contrato = $this->Contrato->getContrato($idContrato); //15 dias

            $idCorreo = $this->insertCorreoEnviado($idContrato, $idUsuario);
            $contrato['idCorreoEncriptado'] = strtr($this->encryption->encrypt($idCorreo), array('+' => '.', '=' => '-', '/' => '~'));
            $contrato['urlCliente']=$this->config->item("base_url_cliente");
            $vista = $this->load->view('viewEmailContratoPorVencer', $contrato, TRUE);

            //print $vista;
            $this->email->from('sistemaGlobalshield@gmail.com', utf8_decode("GLOBAL SHIELD"));

            $this->email->to($contrato['usuario']);
            $this->email->subject(utf8_encode('Tu contrato esta por vencer'));
            $this->email->message(($vista));
            if ($this->email->send())
            {
                //print "Error al enviar correo";
                $this->getCorreosEnviados($idContrato);
            } else
            {
                print "error al enviar correo";
                show_error($this->email->print_debugger());
            }



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
    function getComprobantesPago($idContrato)
    {
        echo json_encode($this->Contrato->getComprobantesPago($idContrato));
    }
    function subirComprobantePago()
    {
        $comprobantePagoAnterior=$this->Contrato->getHistorial($this->input->post("idHistorialRenovacion"));
        //echo json_encode($_FILES);
        $nombreArchivo=$this->subirDocumento("comprobantePago");
        if($nombreArchivo)
        {
            $this->borrarArchivo($comprobantePagoAnterior['comprobantePago']);
            $this->Contrato->updateHistorialRenovacion($this->input->post("idHistorialRenovacion"), array('comprobantePago' => $nombreArchivo));
        }
        echo $nombreArchivo;
    }
    function getInformacionRenovacion($idContrato)
    {
        $array=array();
        $contrato=$this->Contrato->getContrato($idContrato);
        $array[0]=$this->Contrato->getPeriodos($contrato['idMembresia'], $contrato['idTipoCaja']);
        $array[1]=$this->Contrato->getSeguros();
        $array[2]=$contrato;
        echo json_encode($array);
    }
    function generarRenovacionContrato()
    {
        //actualizar el contrato
        $contrato=$this->Contrato->getContrato($this->input->post("contratoRenovacionSeleccionado"));
        $idSeguro=$this->input->post("seguroRenovacion");
        $aplicaDeposito=$this->input->post("aplicaDepositoRenovacion");
        if($aplicaDeposito==1)
            $deposito=$this->input->post("depositoGarantiaRenovacion");
        else
            $deposito=null;
        if(empty($idSeguro))
            $idSeguro=null;
        $this->Contrato->updateContrato($this->input->post("contratoRenovacionSeleccionado"), array(

            'idSeguro' => $idSeguro,
            //'idCosto' => $this->input->post("vigenciaRenovacion"),
            //'costoCaja' => $this->input->post("costoNuevoRenovacion"),
            'depositoGarantia' => $deposito,
            'formaPago' => $this->input->post("formaPagoRenovacion"),
            'fechaRegistro' => date("Y-m-d"),
            'fechaTermino' => $this->calcularFechaTermino($this->input->post("vigenciaRenovacion"),$contrato['fechaTermino'])
        ));
        //insertar un nuevo historial de renovacion
        $this->Contrato->insertHistorialRenovacion(array(
            'idContrato' => $this->input->post("contratoRenovacionSeleccionado"),
            'idCosto' => $this->input->post("vigenciaRenovacion"),
            'fecha' => date("Y-m-d"),
            'fechaInicio' => $contrato['fechaTermino'],
            'fechaFin' => $this->calcularFechaTermino($this->input->post("vigenciaRenovacion"),$contrato['fechaTermino']),
            'precioOriginal' => $this->Contrato->getCosto($this->input->post("vigenciaRenovacion"))['costo']
        ));
    }
    function eliminarTarjetaContrato()
    {
        $folio=$this->input->post("folioTarjeta");
        $this->Contrato->deleteTarjeta($folio);
    }

}
//Objeto que extiende TCPDF para sobreescribir el metodo del footer
class MYPDF extends \TCPDF
{
    private $datosCliente;
    function __construct($datosCliente, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->datosCliente=$datosCliente;
    }

    //Footer del pdf
    public function Footer()
    {
        //establece la leyenda de la primera página.
        if($this->getPage()==1)
        {
            $this->setY(-25);
            $this->writeHTML($this->datosCliente, false, false, false, true, 0);
        }
        $this->SetY(-8);
        $this->SetFont('helvetica', 'I', 8);
        //numero de pagina
        $this->Cell(0, 10,'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages() , 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


?>