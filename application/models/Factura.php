<?php


class Factura extends CI_Model
{

    function getFacturasClientes()
    {
        $this->db->select("Factura.*, CONCAT(COALESCE(ClienteFisico.nombreClienteFisico, \"\"), COALESCE(ClienteMoral.nombreClienteMoral, \"\")) as nombreCliente");
        $this->db->from("Factura");
        $this->db->join("HistorialRenovacion", "Factura.idHistorial=HistorialRenovacion.idHistorial");
        $this->db->join("Contrato", "HistorialRenovacion.idContrato=Contrato.idContrato");
        $this->db->join("ClienteExterno", "ClienteExterno.idClienteExterno=Contrato.idTitular");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario", "Left");
        $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario", "Left");
        return $this->db->get()->result_array();
    }
    function getDatosSucursal($idContrato)
    {
        $this->db->select("Sucursal.*, Region.nombreRegion, LPAD(Region.codigoPostal, 5, 0) as codigoPostal, Municipio.nombreMunicipio, Estado.nombreEstado");
        $this->db->from("Sucursal");
        $this->db->join("Region", "Sucursal.idRegion=Region.idRegion");
        $this->db->join("Municipio", "Region.idMunicipio=Municipio.idMunicipio");
        $this->db->join("Estado", "Estado.idEstado=Municipio.idEstado");
        $this->db->join("MundoCaja", "MundoCaja.idSucursal=Sucursal.idSucursal");
        $this->db->join("Contrato", "Contrato.idMundoCaja=MundoCaja.idMundoCaja");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->row_array();
    }
    function getDatosCliente($idContrato)
    {
        //Verificar si es un cliente fisico o un cliente moral
        $this->db->select("ClienteFisico.*");
        $this->db->from("ClienteExterno");
        $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario");
        $this->db->join("Contrato", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->where("Contrato.idContrato", $idContrato);
        $clienteFisico=$this->db->get()->row_array();

        if(!empty($clienteFisico))
        {
            $this->db->select("
        ClienteExterno.idClienteExterno, ClienteFisico.nombreClienteFisico as nombreCliente,
        ClienteFisico.calleParticular as calle,
        ClienteFisico.numeroParticular as numero,
        ClienteFisico.numeroInteriorParticular as numeroInterior,
        ClienteFisico.razonSocial,
        ClienteFisico.idRegionParticular as regionF,
        Region.idRegion, Region.nombreRegion, Region.idMunicipio, LPAD(Region.codigoPostal, 5, '0') as codigoPostal, Municipio.*, Estado.*         
        ");
            $this->db->from("ClienteExterno");
            $this->db->join("ClienteFisico", "ClienteExterno.idClienteExterno=ClienteFisico.idUsuario");
            $this->db->join("Region", "Region.idRegion=ClienteFisico.idRegionParticular");
        }
        //si se trata de un cliente moral, retornar la consulta de su domicilio fiscal
        else
        {
            $this->db->select("
        ClienteExterno.idClienteExterno, ClienteMoral.nombreClienteMoral as nombreCliente,
        ClienteMoral.calleFiscal as calle,
        ClienteMoral.numeroFiscal as numero,
        ClienteMoral.numeroInteriorFiscal as numeroInterior,
        ClienteMoral.razonSocial,
        ClienteMoral.idRegionFiscal as regionF,
        Region.idRegion, Region.nombreRegion, Region.idMunicipio, LPAD(Region.codigoPostal, 5, '0') as codigoPostal, Municipio.*, Estado.*         
        ");
            $this->db->from("ClienteExterno");
            $this->db->join("ClienteMoral", "ClienteExterno.idClienteExterno=ClienteMoral.idUsuario");
            $this->db->join("Region", "Region.idRegion=ClienteMoral.idRegionFiscal");
        }
        $this->db->join("Municipio", "Municipio.idMunicipio=Region.idMunicipio");
        $this->db->join("Estado", "Estado.idEstado=Municipio.idEstado");
        $this->db->join("Contrato", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->where("Contrato.idContrato", $idContrato);
        return $this->db->get()->row_array();
    }
    //Verifica que un folio pueda ser facturado
    function verificar($idContrato, $fecha)
    {


        $this->db->select("Contrato.idContrato, Contrato.fechaRegistro");
        $this->db->from("Contrato");
        $this->db->join("ClienteExterno", "Contrato.idTitular=ClienteExterno.idClienteExterno");
        $this->db->where("Contrato.idContrato", $idContrato);
        $idContratoRecuperado=$this->db->get()->row_array();

        if(!empty($idContratoRecuperado))
        {

            if($idContratoRecuperado['idContrato']===$idContrato)
            {

                $this->db->select("Factura.folioFactura");
                $this->db->from("Factura");
                $this->db->join("HistorialRenovacion", "Factura.idHistorial=HistorialRenovacion.idHistorial");
                $this->db->join("Contrato", "HistorialRenovacion.idContrato=Contrato.idContrato");
                $this->db->where("Contrato.idContrato", $idContrato);
                $existeFactura=$this->db->get()->num_rows();
                if($existeFactura==0)
                {

                    //PASO 3: Verificar que la fecha se encuentre dentro de 5 días apartir de la fecha de hoy
                    $fechaRecuperada=new DateTime($idContratoRecuperado['fechaRegistro']);
                    $anioRecuperado=$fechaRecuperada->format('Y');
                    $mesRecuperado=$fechaRecuperada->format('m');
                    $diaRecuperado=$fechaRecuperada->format('d');
                    $anio=substr($fecha, 0, 4);
                    $mes=substr($fecha, 4, 2);
                    $dia=substr($fecha, 6, 2);

                    if($anioRecuperado===$anio&&$mesRecuperado===$mes&&$diaRecuperado===$dia)
                    {

                        $fechaLimite=strtotime(date("Y-m-d", strtotime($anio."-".$mes."-".$dia.'+5 days')));
                        $fechaHoy=strtotime(date("Y-m-d"));

                        if($fechaHoy<=$fechaLimite)
                        {

                            return 1;
                        }


                    }
                }



            }
        }
        return 0;
    }
    function insertFactura($data)
    {
        $this->db->insert("Factura", $data);
    }
    //Verifica que el folio pertenezca al usuario
    function verificarFolioUsuario($folio)
    {
        $this->db->select("Factura.folioFactura");
        $this->db->from("Factura");
        $this->db->join("HistorialRenovacion", "Factura.idHistorial=HistorialRenovacion.idHistorial");
        $this->db->join("Contrato", "HistorialRenovacion.idContrato=Contrato.idContrato");
        $this->db->where("Factura.folioFactura", $folio);
        return $this->db->get()->num_rows();
    }
    function getFactura($folio)
    {
        $this->db->select("Factura.*");
        $this->db->from("Factura");
        $this->db->where("Factura.folioFactura", $folio);
        return $this->db->get()->row_array();
    }
}