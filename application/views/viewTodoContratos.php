<style>
    /*Estilo que se necesita debido a que el swal suele aparecer detras de
    los modales de materialize. No siempre pasa, pero es molesto*/
    .swal2-container {
        z-index: 10000;
    }
    .chop{
        left: unset !important;
        top: unset !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">CONTRATOS REGISTRADOS</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='btn waves-effect waves-light' onclick="loadUrl('CrudContrato/formAltaContrato')">Nuevo Contrato</a>
            </div>
            <?php
        }
        if($permisos['mostrar']) {
        ?>
        <div class="row">
            <div class="col s12">
                <table id="mainTable" class="highlight col s12 center">
                    <thead>
                    <tr>
                        <th style="background-color: #f9f9f9" >Titular</th>
                        <th style="">ID</th>
                        <th><i class="material-icons">people_outline</i></th>
                        <th>Membresía</th>
                        <th>Caja</th>
                        <th>Fecha de termino</th>
                        <th>Status</th>
                        <th>Moroso</th>
                        <th><i class="material-icons">local_printshop</i></th>

                        <th><i class="material-icons">email</i></th>
                        <th><i class="material-icons">update</i></th>
                        <th><i class="material-icons">list</i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $contador = 1;
                    foreach ($contratos as $row) {
                        $idContrato=$row["idContrato"];
                        $titular=$row["nombreCliente"];
                        $membresia= $row["nombreMembresia"];
                        $caja=$row["nombreCaja"];
                        $pasillo=$row["pasillo"];
                        $numeroCaja=$row["numeroCaja"];
                        $fechaTermino=$row["fechaTermino"];
                        $status=$row['statusContrato'];
                        $archivoFirmado=$row['archivoFirmado'];
                        $fechaHoy=date("Y-m-d");
                        //2019-05-02
                        $newdate = strtotime ("+15 day",strtotime($fechaHoy));
                        //2019-05-17
                        //$newdate = date ('Y-m-d', $newdate);
                        if($newdate>=strtotime($fechaTermino))
                        {
                            $renovacion="<a id='botonRenovacion".$row['idContrato']."' onclick='renovarContrato(".$row['idContrato'].")'><i class='material-icons'>update</i></a>";
                            $correo="<a onclick='verCorreosContrato(".$row['idContrato'].")'><i class='material-icons'>email</i></a>";
                        }

                        else
                        {
                            $renovacion="";
                            $correo="";
                        }

                        $statusStyle="style='height: auto; line-height: normal; padding: 0rem 0.5rem;'";

                        if(strtotime($fechaTermino) < strtotime(date("Y-m-d")))
                        {
                            $status="<a class='btn small gradient-45deg-purple-deep-purple tooltipped' data-position=\"top\" data-tooltip='Clic para terminar' onclick='terminarContrato(".$idContrato.", this)' $statusStyle>Vencido</a>";
                        }
                        else if(!empty($archivoFirmado))
                        {
                            $status="<a class='btn small gradient-45deg-green-teal tooltipped' data-position=\"top\" data-tooltip='Clic para terminar' onclick='terminarContrato(".$idContrato.", this)'  $statusStyle>Firmado</a>";
                        }
                        else if(empty($archivoFirmado))
                        {
                            $status="<a class='btn small gradient-45deg-deep-orange-orange tooltipped' data-position=\"top\" data-tooltip='Clic para terminar' onclick='terminarContrato(".$idContrato.", this)' $statusStyle>Sin firmar</a>";
                        }
                        echo "<tr>
                        <td id='titularContrato$idContrato'>$titular</td>
                        <td id='indice".$row['idContrato']."' style=''>$idContrato</td>
                        <td><a onclick='verCotitulares(" . $row['idContrato'] . ")'><i class=\"material-icons\">people_outline</i></a></td>                        
                        <td>$membresia</td>
                        <td>$caja $pasillo$numeroCaja</td>
                        <td>$fechaTermino</td>
                        <td style='text-align: center'>$status</td>
                        <td style='text-align: center;'><input onclick='terminar(".$row['idContrato'].")' id='terminado".$row['idContrato']."' type=\"checkbox\" class=\"filled-in\" />
                            <label for='terminado".$row['idContrato']."'></label>
                        </td>
                        ";


                        echo "
                        <td><a onclick='abrirModalImpresion(" . $row['idContrato'] . ")'><i class=\"material-icons\">local_printshop</i></a></td>
                        
                        <td>$correo</td>
                        <td>$renovacion</td>
                        ";

                        echo "<td><a class='dropdown-button ' data-activates='dropdown".$row['idContrato']."'><i class=\"material-icons\" style='color: #8324aa !important;' >list</i></a>
                        <ul class='dropdown-content chop' id='dropdown".$row['idContrato']."'>";
                        if($permisos['editar'])
                            echo "<li ><a onclick='loadUrl(\"CrudContrato/verEdicionContrato/" . $row['idContrato'] . "\")'><i class=\"material-icons\" style='color: #8e24aa !important;'>edit</i></a></li>";
                        if($permisos['detalle'])
                            echo "<li ><a onclick='loadUrl(\"CrudContrato/verDetalleContrato/" . $row['idContrato'] . "\")'><i style='color: #8e24aa !important;' class=\"material-icons\">remove_red_eye</i></a></li>";
                        if($permisos['eliminar'])
                            echo "<li><a onclick='borrar(" . $row['idContrato'] . ", this)'><i class=\"material-icons \" style='color: #8e24aa !important;'>delete_forever</i></a></li>";
                        echo "</ul></td>";
                        echo "</tr>";
                        $contador++;
                    }
                    ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <?php
    }?>

    <div id="modalCotitulares" class="modal">
        <div class="modal-content">
            <h4>Cotitulares del contrato</h4>
            <div class="row">
                <div class="collection" id="cotitularesContrato">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
    <div id="modalRenovacion" class="modal">
        <div class="modal-content">
            <h4>Renovación del contrato</h4>
            <form id="formularioRenovacion">
                <input type="hidden" id="contratoRenovacionSeleccionado" name="contratoRenovacionSeleccionado">
                <div class="row" id="contenidoModalRenovacion">
                    <div class="col s12 input-field">
                        <label for="vigenciaRenovacion">Vigencia</label>
                        <select id="vigenciaRenovacion" name="vigenciaRenovacion" onchange="cargarCosto()">
                        </select>

                    </div>

                    <div class="col s4 input-field">
                        <select name="aplicaDepositoRenovacion" id="aplicaDepositoRenovacion" onchange="aplicarDepositoGarantiaRenovacion()">
                            <option value="1">Si</option>
                            <option value="2">N/A</option>
                        </select>
                        <label for="aplicaDepositoRenovacion">¿Depósito en garantia?</label>
                    </div>
                    <div class="col s4 input-field" id="contenedorDepositoGarantiaRenovacion">
                        <input id="depositoGarantiaRenovacion" name="depositoGarantiaRenovacion" type="number" required>
                        <label for="depositoGarantiaRenovacion" class="active">Depósito en garantia</label>
                    </div>
                    <div class="col s4 input-field">
                        <select id="seguroRenovacion" name="seguroRenovacion">
                        </select>
                        <label for="seguroRenovacion">Nuevo seguro</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4 input-field">
                        <select id="formaPagoRenovacion" name="formaPagoRenovacion" required>
                            <option value="1">Efectivo</option>
                            <option value="2">Transferencia</option>
                            <option value="3">Tarjeta</option>
                        </select>
                        <label for="formaPagoRenovacion">Forma de pago</label>
                    </div>
                    <div class="col s4 input-field">
                        <input id="costoAnteriorRenovacion" name="costoAnteriorRenovacion" type="number" readonly>
                        <label for="costoAnteriorRenovacion" class="active">Costo anterior</label>
                    </div>
                    <div class="col s4 input-field">
                        <input id="costoNuevoRenovacion" name="costoNuevoRenovacion" type="number" readonly required>
                        <label for="costoNuevoRenovacion" class="active">Costo nuevo</label>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col s6 offset-s3 center" align="center">
                        <b><label>Total a pagar</label></b><br>
                        <b id="totalAPagar"></b>
                    </div>
                </div>

                <div class="row">
                    <div class="col s3 offset-s3 center" align="center">
                        <b><label>Fecha de termino anterior</label></b><br>
                        <b id="fechaTerminoAnteriorRenovacion">1000-01-01</b>
                    </div>

                    <div class="col s3 center" align="center">
                        <b><label>Nueva fecha de termino</label></b><br>
                        <b id="fechaTerminoNuevaRenovacion">2032-12-31</b>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <a class="left modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <a onclick="renovacionContrato()" class="waves-effect waves-green btn-flat">Renovar</a>
        </div>
    </div>

    <script>
        var tabla;
        $(document).ready(function () {
            $('.tooltipped').tooltip();

            tabla=$("#mainTable").DataTable({

                language:{
                    url: '<?=base_url('assets/i18n/Spanish.json')?>'
                },
                order: [[ 1, "desc" ]],
                responsive: true,
                autoWidth: false,
                fixedHeader: true,
                scrollX: true,
                fixedColumns: {
                    leftColumns: 1
                },
                columnDefs: [
                    { visible: false, targets: 1 }
                ]
            });
            $(".modal").modal();
            $('.dropdown-button').dropdown({
                constrainWidth: true,
                alignment: 'right',
                coverTrigger: true
            });

        });
        function aplicarDepositoGarantiaRenovacion()
        {
            if($("#aplicaDepositoRenovacion").val()==="1")
            {
                $("#contenedorDepositoGarantiaRenovacion").show(1000);
                $("#depositoGarantiaRenovacion").prop("required", true);
            }
            else
            {
                $("#contenedorDepositoGarantiaRenovacion").hide(1000);
                $("#depositoGarantiaRenovacion").prop("required", false);
            }
        }
        /*Esta funcion abre el modal de la renovacion del contrato*/
        function renovarContrato(idContrato)
        {

            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/getInformacionRenovacion/')?>'+idContrato,
                dataType: 'JSON',
                success: function (data)
                {
                    $("#vigenciaRenovacion").empty();
                    $("#seguroRenovacion").empty();
                    $("#costoAnteriorRenovacion").val('');
                    $("#costoNuevoRenovacion").val('');
                    $("#depositoGarantiaRenovacion").val('');
                    $("#contratoRenovacionSeleccionado").val('');

                    /*
                    data[0] son periodos de renovacion
                    data[1] son seguros
                    data[2] es la inforamción del contrato
                    * */
                    let periodosRenovacion=data[0];
                    let seguros=data[1];
                    let contrato=data[2];

                    for (let i=0; i<periodosRenovacion.length; i++)
                    {
                        let nombrePeriodo="";
                        if(periodosRenovacion[i]['numeroAnios']>0)
                        {
                            nombrePeriodo+=periodosRenovacion[i]['numeroAnios']+" año (s) ";
                            if(periodosRenovacion[i]['numeroMeses']!='0')
                                nombrePeriodo+=", ";
                        }
                        if(periodosRenovacion[i]['numeroMeses']!='0')
                        {
                            nombrePeriodo+=periodosRenovacion[i]['numeroMeses']+" meses ";
                            if(periodosRenovacion[i]['numeroDias']!='0')
                                nombrePeriodo+=", "
                        }
                        if(periodosRenovacion[i]['numeroDias']!='0')
                        {
                            nombrePeriodo+=periodosRenovacion[i]['numeroDias']+" días";
                        }
                        $("#vigenciaRenovacion").append("<option value='"+periodosRenovacion[i]['idCosto']+"'>"+nombrePeriodo+"</option>");
                    }


                    for (var i=0; i<seguros.length; i++)
                    {
                        $("#seguroRenovacion").append("<option value='"+seguros[i]['idSeguro']+"'>Hasta $"+seguros[i]['proteccion']+" (USD) por "+seguros[i]['costoAnual']+"(MXN)</option>");
                    }
					
					if(contrato['depositoGarantia']!=null)
						var totalPago = parseFloat(contrato['depositoGarantia'])+ parseFloat(contrato['costoCaja']);
					
					else
						var totalPago = parseFloat(contrato['costoCaja']);
					
                    $("#formaPagoRenovacion").val(contrato['formaPago']);
                    $("#depositoGarantiaRenovacion").val(contrato['depositoGarantia']);
                    $("#aplicaDepositoRenovacion").val(2).change();
                    $("#vigenciaRenovacion").val(contrato['idCosto']);
                    $("#costoAnteriorRenovacion").val(contrato['costoCaja']);
                    $("#fechaTerminoAnteriorRenovacion").html(contrato['fechaTermino']);
                    $("#contratoRenovacionSeleccionado").val(contrato['idContrato']);
                    $("#totalAPagar").html("$ "+totalPago);
                    $("#vigenciaRenovacion").trigger('change');
                    $("select").material_select();
                    $("#modalRenovacion").modal('open');
                }
            });

        }
        /*
        Esta función manda un contrato a renovación
        * */

        function renovacionContrato()
        {
            let nombreTitular=$("#titularContrato"+$("#contratoRenovacionSeleccionado").val()).html();
            Swal.fire({
                type: 'info',
                title: '¿Renovar el contrato de '+nombreTitular+'?',
                html: 'Esta acción no podrá ser cancelada.',
                confirmButtonText: '¡Si, renovar!',
                cancelButtonText: 'Cancelar',
                showCancelButton: true
            }).then(function (result) {
                if(result.value)
                {
                    var formulario=new FormData(document.getElementById("formularioRenovacion"));
                    $.ajax({
                        url: '<?=base_url('index.php/CrudContrato/generarRenovacionContrato')?>',
                        data: formulario,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        dataType: 'HTML',
                        success: function (data)
                        {
                            $("#modalRenovacion").modal('close');

                            $("#botonRenovacion"+$("#contratoRenovacionSeleccionado").val()).remove();
                            swal('¡Exito!', 'Se renovó el contrato!', 'success');
                        }
                    });
                }
            });

        }

        function cargarCosto()
        {
            var idCosto=$("#vigenciaRenovacion").val();
            var fechaAnterior=$("#fechaTerminoAnteriorRenovacion").html();
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/cargarCosto/')?>'+idCosto,
                dataType: 'JSON',
                success: function (data)
                {
                    $("#costoNuevoRenovacion").val(data['costo']);
                }
            });
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/calcularFechaTermino/')?>'+idCosto+"/"+fechaAnterior,
                dataType: 'JSON',
                success: function (data)
                {
                    $("#fechaTerminoNuevaRenovacion").html(data);
                }
            });

        }
        //esta función manda el contrato a morosos. Se llama "terminar" porque antes pensabamos que un contrato terminado era igual a uno en morosos
        function terminar(idContrato)
        {
            var check=$("#terminado"+idContrato).prop("checked");
            var status;
            if(check)
                status=1;
            else
                status=0;
            $.ajax({
                url: "<?=base_url('index.php/CrudContrato/enviarContratoMorosos/')?>"+idContrato+"/"+status,
                dataType: 'JSON',
                success: function (data)
                {
                    if(data)
                        swal(data[0], data[1], data[2]);

                    $("#terminado"+idContrato).prop("checked", data[4]);

                }
            });
        }
        function imprimirTicket(idContrato)
        {
            open('<?=base_url('index.php/CrudContrato/generacionTicket/')?>'+idContrato, 'Ticket', 'location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000');
        }
        function verCotitulares(idContrato) {
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/getCotitularesContrato/')?>'+idContrato,
                dataType: 'JSON',
                success: function (data)
                {
                    $("#cotitularesContrato").empty();
                    for (var i=0; i<data.length; i++)
                    {
                        $("#cotitularesContrato").append("<a class=\"collection-item\">"+data[i]['nombreCliente']+"</a>");
                    }
                    $("#modalCotitulares").modal('open');
                },


            });
        }
        <?php
        if($permisos['eliminar'])
        {
        ?>
        function borrar(identificador, elemento) {
            Swal({
                title: '¿Eliminar este registro?',
                text: "Se desocupará la caja. No se podran revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, borralo!'
            }).then((result) => {
                if (result.value) {
                    $.post('<?=base_url('index.php/CrudContrato/borrarContrato')?>',
                        {idContrato: identificador},
                        function (response) {
                            tabla.row($(elemento).closest('tr')).remove().draw();
                            Swal(
                                'Borrado!',
                                'El registro fue eliminado',
                                'success'
                            );
                        }
                    );
                }
            })
        }
        <?php
        }
        ?>
        //Esta función manda a terminar un contrato definitivamente
        function terminarContrato(idContrato, btnStatus) {
            Swal.fire({
                type: 'question',
                text:'Se terminará el contrato',
                title: '¿Terminar el contrato?',
                showCancelButton: true,
                confirmButtonText: 'Si, terminar el contrato',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value)
                {
                    $.ajax({
                        url: '<?=base_url('index.php/CrudContrato/terminarContrato/')?>'+idContrato,
                        dataType:'JSON',
                        success: function (data)
                        {
                            if(data)
                                swal(data[0], data[1], data[2]);
                            if(data[2]!="error")
                                tabla.row($(btnStatus).closest('tr')).remove().draw();
                        }

                    });

                }

            });

        }

        function abrirModalImpresion(idContrato)
        {
            $("#contratoSeleccionado").val(idContrato);
            $("#comprobantesPago").empty();
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/traerContratoFirmado/')?>'+idContrato,
                dataType: 'JSON',
                success: function (data)
                {
                    if(data['archivoFirmado'])
                    {
                        $("#dropifyContrato").html('<input type="file" class="dropify" onchange="subirContratoFirmado('+idContrato+')" id="contratoFirmado" name="contratoFirmado" data-default-file="<?=base_url('assets/fileUpload/contratos/')?>'+data['archivoFirmado']+'">');
                        $("#enlaceContratoFirmado").html('<div class="col s12 center" align="center"><a download href="<?=base_url('assets/fileUpload/contratos/')?>'+data['archivoFirmado']+'">Descargar contrato firmado</a></div>');
                    }
                    else
                    {
                        $("#dropifyContrato").html('<input type="file" class="dropify" onchange="subirContratoFirmado('+idContrato+')" id="contratoFirmado" name="contratoFirmado">');
                        $("#enlaceContratoFirmado").html('');

                    }
                    $.ajax({
                        url: '<?=base_url('index.php/CrudContrato/getComprobantesPago/')?>'+idContrato,
                        dataType: 'JSON',
                        success: function (comprobantesPago)
                        {

                            for (var i=0; i<comprobantesPago.length; i++) {

                                $("#comprobantesPago").append(" " +
                                    "<div class='col s6'>" +
                                    "   <input type='file' class='dropify dropifysComprobantes' onChange='subirComprobante(" + comprobantesPago[i]['idHistorial'] + ")' id='comprobantePago" + comprobantesPago[i]['idHistorial'] + "' name='comprobantePago" + comprobantesPago[i]['idHistorial'] + "'>" +
                                    "   <div class='col s12 center' align='center'>" +
                                    "       <a download id='descargaComprobantePago" + comprobantesPago[i]['idHistorial'] + "'></a>" +
                                    "   </div>" +
                                    "</div>");
                                if (comprobantesPago[i]['comprobantePago'])
                                {
                                    $("#comprobantePago"+comprobantesPago[i]['idHistorial']).attr("data-default-file", "<?=base_url('assets/fileUpload/contratos/')?>"+comprobantesPago[i]['comprobantePago']);
                                    $("#descargaComprobantePago"+comprobantesPago[i]['idHistorial']).attr("href", "<?=base_url('assets/fileUpload/contratos/')?>"+comprobantesPago[i]['comprobantePago']);
                                    $("#descargaComprobantePago"+comprobantesPago[i]['idHistorial']).html("Descargar comprobante de pago "+(i+1));
                                }
                            }
                            $(".dropifysComprobantes").dropify({
                                messages: {
                                    'default': 'Arrastra y suelta el comprobante de pago o haz clic',
                                    'replace': 'Arrastra y suelta el comprobante de pago ó haz clic para reemplazar',
                                    'remove':  'Remover',
                                    'error':   'Ooops, ocurrió un error.'
                                }
                            });
                            $("#modalImpresion").modal('open');
                        }
                    });
                    $("#dropifyContrato").dropify({
                        messages: {
                            'default': 'Arrastra y suelta el contrato firmado ó haz clic',
                            'replace': 'Arrastra y suelta el contrato firmado ó haz clic para reemplazar',
                            'remove':  'Remover',
                            'error':   'Ooops, ocurrió un error.'
                        }
                    });

                }
            });
        }
        function subirComprobante(idHistorialRenovacion)
        {
            $("#idHistorialSeleccionado").val(idHistorialRenovacion);
            var form = new FormData(document.getElementById("formularioComprobantesPago"));
            jQuery.each(jQuery('#comprobantePago'+idHistorialRenovacion)[0].files, function(i, file) {
                form.append('comprobantePago', file);
            });
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/subirComprobantePago')?>',
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'HTML',
                success: function (data)
                {
                    if((data))
                    {
                        $("#descargaComprobantePago"+idHistorialRenovacion).attr("href", "<?=base_url('assets/fileUpload/contratos/')?>"+data);
                        $("#descargaComprobantePago"+idHistorialRenovacion).html("Descargar el nuevo comprobante de pago");
                    }

                    swal("¡Exito!", "Se ha registrado el comprobante de pago", "success");
                }
            });
        }
        function subirContratoFirmado(idContrato)
        {
            console.log("Subiendo el contrato "+idContrato);
            $("#formContratoFirmado").submit();
        }

        $("#formContratoFirmado").submit(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Procesando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});

            var form=new FormData(document.getElementById("formContratoFirmado"));
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/subirContratoFirmado/')?>'+$("#contratoSeleccionado").val(),
                data: form,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data)
                {
                    Swal.close();
                    swal("Bien!", "El contrato firmado ha sido guardado", "success");

                }
            });
        });

        function generarContrato()
        {
            var idContrato=$("#contratoSeleccionado").val();


            open('<?=base_url('index.php/CrudContrato/generacionContrato/')?>'+idContrato, 'Contrato', 'location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000');
        }
        function generarTicket()
        {
            var idContrato=$("#contratoSeleccionado").val();

            imprimirTicket(idContrato);
        }
        function verCorreosContrato(idContrato)
        {
            $("#tablaCorreos").empty();
            $("#idContratoCorreos").val(idContrato);
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/getCorreosEnviados/')?>'+idContrato,
                dataType:'JSON',
                success: function (data)
                {
                    var usuario="";
                    var fechaLectura="";
                    for(var i=0; i<data.length; i++)
                    {
                        usuario=(data[i]['nombreUsuario'])?data[i]['nombreUsuario']:"Sistema";
                        fechaLectura=(data[i]['fechaLectura'])?data[i]['fechaLectura']:"No leído";
                        $("#tablaCorreos").append(' ' +
                            '<tr>' +
                            '<td>'+(i+1)+'</td>' +
                            '<td>'+usuario+'</td>' +
                            '<td>'+data[i]['fechaEnvio']+'</td>' +
                            '<td>'+fechaLectura+'</td>' +
                            '</tr>');
                    }
                    $("#modalCorreos").modal('open');
                }
            });
        }
        function reenviarCorreo()
        {
            Swal.fire({
                title: 'Procesando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});
            let idContrato=$("#idContratoCorreos").val();
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/reenviarCorreo/')?>'+idContrato,
                dataType: 'JSON',
                success: function (data)
                {
                    let html="";
                    let usuario="";
                    let fechaLectura="";
                    for(let i=0; i<data.length; i++)
                    {
                        usuario=(data[i]['nombreUsuario'])?data[i]['nombreUsuario']:"Sistema";
                        fechaLectura=(data[i]['fechaLectura'])?data[i]['fechaLectura']:"No leído";
                        html+=' ' +
                            '<tr>' +
                            '<td>'+(i+1)+'</td>' +
                            '<td>'+usuario+'</td>' +
                            '<td>'+data[i]['fechaEnvio']+'</td>' +
                            '<td>'+fechaLectura+'</td>' +
                            '</tr>';
                    }
                    $("#tablaCorreos").html(html);
                    Swal.close();
                    swal("Bien!", "Se reenvió el correo", "success");
                }
            });
        }
    </script>

    <div id="modalCorreos" class="modal">
        <input type="hidden" id="idContratoCorreos" name="idContratoCorreos">
        <div class="modal-content">
            <h4>Correos del contrato</h4>
            <p>Los siguientes son los correos que se han enviado al cliente:</p>
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario que envió</th>
                            <th>Fecha de envío</th>
                            <th>Fecha de lectura</th>
                        </tr>
                        </thead>
                        <tbody id="tablaCorreos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a onclick="reenviarCorreo()" class="left waves-effect waves-green btn-flat">Reenviar correo</a>
            <a class="right modal-close waves-effect waves-green btn-flat">Aceptar</a>
        </div>
    </div>




    <div id="modalImpresion" class="modal ">
        <div class="modal-content">
            <h4>Impresión del contrato</h4>
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="col s6 center" align="center">
                            <input type="hidden" id="contratoSeleccionado" name="contratoSeleccionado">
                            <button onclick="generarContrato()" class="btn waves-effect waves-light" style="margin-bottom: 10px">Generar contrato</button>
                        </div>
                        <div class="col s6 center" align="center">
                            <button onclick="generarTicket()" class="btn waves-effect waves-light" style="margin-bottom: 10px">Generar ticket</button>
                        </div>
                    </div>
                    <div class="row">
                        <form id="formContratoFirmado" class="col s6">
                            <div class="col s12" id="dropifyContrato">

                            </div>
                            <div class="col s12" id="enlaceContratoFirmado">

                            </div>
                        </form>
                        <form id="formularioComprobantesPago" enctype="multipart/form-data">
                            <input type="hidden" id="idHistorialSeleccionado" name="idHistorialRenovacion">
                        </form>
                        <div id="comprobantesPago">

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

