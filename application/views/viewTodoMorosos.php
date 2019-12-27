<style>
    /*Estilo que se necesita debido a que el swal suele aparecer detras de
    los modales de materialize. No siempre pasa, pero es molesto*/
    .swal2-container {
        z-index: 10000;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">MOROSOS</h4></div>
        </div>
        <?php
        if($permisos['mostrar']) {
        ?>
        <div class="col s12">
            <table id="mainTable" class="highlight">
                <thead>
                <tr>
                    <th style="display: none">ID</th>
                    <th>Titular</th>
                    <th><i class="material-icons">people_outline</i></th>
                    <th>Membresía</th>
                    <th>Caja</th>
                    <th>Fecha de termino</th>
                    <th>Status</th>
                    <th>Moroso</th>
                    <th>Ticket</th>
                    <th><i class="material-icons">email</i></th>

                    <?php
                    if($permisos['detalle']) {
                        ?>
                        <th><i class="material-icons">remove_red_eye</i></th>
                        <?php
                    }?>
                    <th><i class="material-icons">local_printshop</i></th>


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

                        $correo="<a onclick='verCorreosContrato(".$row['idContrato'].")'><i class='material-icons'>email</i></a>";
                    }

                    else
                    {

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
                        <td id='indice".$row['idContrato']."' style='display:none'>$idContrato</td>
                        <td>$titular</td>
                        <td><a onclick='verCotitulares(" . $row['idContrato'] . ")'><i class=\"material-icons\">people_outline</i></a></td>                        
                        <td>$membresia</td>
                        <td>$caja $pasillo$numeroCaja</td>
                        <td>$fechaTermino</td>
                        <td style='text-align: center'>$status</td>
                        <td style='text-align: center;'><input onclick='terminar(".$row['idContrato'].")' id='terminado".$row['idContrato']."' type=\"checkbox\" checked class=\"filled-in\" />
                            <label for='terminado".$row['idContrato']."'></label>
                        </td>
                        <td><a onclick='imprimirTicket(".$row['idContrato'].")'>Ticket</a></td>
                        <td>$correo</td>";

                    if($permisos['detalle'])
                        echo "<td><a onclick='loadUrl(\"CrudContrato/verDetalleContrato/" . $row['idContrato'] . "\")'><i class=\"material-icons\">remove_red_eye</i></a></td>";
                    echo "<td><a onclick='abrirModalImpresion(" . $row['idContrato'] . ")'><i class=\"material-icons\">local_printshop</i></a></td>";

                    echo "</tr>";
                    $contador++;
                }
                ?>
                </tbody>

            </table>
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

    <script>
        var tabla;
        $(document).ready(function () {
            $('.tooltipped').tooltip();
            tabla=$("#mainTable").DataTable({
                language:{
                    url: '<?=base_url('assets/i18n/Spanish.json')?>'
                },
                order: [[ 0, "desc" ]]
            });
            $(".modal").modal();
        });

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
                        $("#enlaceContratoFirmado").html('<div class="col s12 center" align="center"><a download href="<?=base_url('assets/fileUpload/contratos/')?>'+data['archivoFirmado']+'">Descargar contrato firmado</a></div>');
                    }
                    else
                    {
                        $("#enlaceContratoFirmado").html('');

                    }
                    $.ajax({
                        url: '<?=base_url('index.php/CrudContrato/getComprobantesPago/')?>'+idContrato,
                        dataType: 'JSON',
                        success: function (comprobantesPago)
                        {

                            for (var i=0; i<comprobantesPago.length; i++) {

                                $("#comprobantesPago").append(" " +
                                    "<div class='col s6 center' align='center'>" +
                                    "       <a download id='descargaComprobantePago" + comprobantesPago[i]['idHistorial'] + "'></a>" +
                                    "</div>");
                                if (comprobantesPago[i]['comprobantePago'])
                                {
                                    $("#comprobantePago"+comprobantesPago[i]['idHistorial']).attr("data-default-file", "<?=base_url('assets/fileUpload/contratos/')?>"+comprobantesPago[i]['comprobantePago']);
                                    $("#descargaComprobantePago"+comprobantesPago[i]['idHistorial']).attr("href", "<?=base_url('assets/fileUpload/contratos/')?>"+comprobantesPago[i]['comprobantePago']);
                                    $("#descargaComprobantePago"+comprobantesPago[i]['idHistorial']).html("Comprobante de pago "+(i+1));

                                }
                            }

                            $("#modalImpresion").modal('open');
                        }
                    });

                }
            });
        }
        function generarContrato()
        {
            var idContrato=$("#contratoSeleccionado").val();


            open('<?=base_url('index.php/CrudContrato/generacionContrato/')?>'+idContrato, 'Contrato', 'location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000');
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
        function reenviarCorreo() {
            Swal.fire({
                title: 'Procesando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});
            var idContrato=$("#idContratoCorreos").val();
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/reenviarCorreo/')?>'+idContrato,
                dataType: 'JSON',
                success: function (data)
                {
                    var html="";
                    var usuario="";
                    var fechaLectura="";
                    for(var i=0; i<data.length; i++)
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
                        <div class="col s12 center" align="center">
                            <input type="hidden" id="contratoSeleccionado" name="contratoSeleccionado">
                            <button onclick="generarContrato()" class="btn waves-effect waves-light" style="margin-bottom: 10px">Generar contrato</button>
                        </div>
                    </div>
                    <div class="row">
                        <div id="enlaceContratoFirmado">
                        </div>
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
