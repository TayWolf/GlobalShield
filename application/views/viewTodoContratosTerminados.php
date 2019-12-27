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
            <div class="col s11"><h4 class="header">CONTRATOS TERMINADOS</h4></div>
        </div>
        <?php
        if($permisos['mostrar']) {
        ?>
        <div class="col s12">
            <table id="mainTable">
                <thead>
                <tr>
                    <th style="display: none">ID</th>
                    <th>Titular</th>
                    <th>Cotitulares</th>
                    <th>Membresía</th>
                    <th>Caja</th>
                    <th>Fecha de termino</th>
                    <th>Status</th>
                    <!--<th>Moroso</th>-->
                    <th>Ticket</th>
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

                    $statusStyle="style='height: auto; line-height: normal; padding: 0rem 0.5rem;'";

                    if(strtotime($fechaTermino) < strtotime(date("Y-m-d")))
                    {
                        $status="<a class='btn small gradient-45deg-purple-deep-purple tooltipped' data-position=\"top\" data-tooltip='Clic para recuperar' onclick='terminarContrato(".$idContrato.", this)' $statusStyle>Vencido</a>";
                    }
                    else if(!empty($archivoFirmado))
                    {
                        $status="<a class='btn small gradient-45deg-green-teal tooltipped' data-position=\"top\" data-tooltip='Clic para recuperar' onclick='terminarContrato(".$idContrato.", this)'  $statusStyle>Firmado</a>";
                    }
                    else if(empty($archivoFirmado))
                    {
                        $status="<a class='btn small gradient-45deg-deep-orange-orange tooltipped' data-position=\"top\" data-tooltip='Clic para recuperar' onclick='terminarContrato(".$idContrato.", this)' $statusStyle>Sin firmar</a>";
                    }
                    //checkbox de morosos
                    //<td style='text-align: center;'><input onclick='terminar(".$row['idContrato'].")' id='terminado".$row['idContrato']."' type=\"checkbox\" class=\"filled-in\" />
                    //                            <label for='terminado".$row['idContrato']."'></label>
                    //                        </td>
                    echo "<tr>
                        <td id='indice".$row['idContrato']."' style='display:none'>$idContrato</td>
                        <td>$titular</td>
                        <td><a onclick='verCotitulares(" . $row['idContrato'] . ")'>Cotitulares</a></td>                        
                        <td>$membresia</td>
                        <td>$caja $pasillo$numeroCaja</td>
                        <td>$fechaTermino</td>
                        <td style='text-align: center'>$status</td>
                        <td><a onclick='imprimirTicket(".$row['idContrato'].")'>Ticket</a></td>";
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
                text:'Se recuperará el contrato',
                title: '¿Recuperar el contrato?',
                showCancelButton: true,
                confirmButtonText: 'Si, recuperar el contrato',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value)
                {
                    $.ajax({
                        url: '<?=base_url('index.php/CrudContrato/cambiarTerminoContrato/')?>'+idContrato+"/0",
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

                    if(data['comprobantePago'])
                    {
                        $("#dropifyComprobantePago").html('<input type="file" class="dropify" onchange="subirComprobante('+idContrato+')" id="comprobantePago" name="comprobantePago" data-default-file="<?=base_url('assets/fileUpload/comprobantesPago/')?>'+data['comprobantePago']+'">');
                        $("#enlaceComprobantePago").html('<div class="col s12 center"><a download href="<?=base_url('assets/fileUpload/comprobantesPago/')?>'+data['comprobantePago']+'">Descargar comprobante de pago</a></div>');

                    }
                    else
                    {
                        $("#dropifyComprobantePago").html('<input type="file" class="dropify" onchange="subirComprobante('+idContrato+')" id="comprobantePago" name="comprobantePago">');
                        $("#enlaceComprobantePago").html('');
                    }



                    $("#dropifyContrato").dropify({
                        messages: {
                            'default': 'Arrastra y suelta el contrato firmado o haz clic',
                            'replace': 'Arrastra y suelta el contrato firmado haz clic para reemplazar',
                            'remove':  'Remover',
                            'error':   'Ooops, ocurrió un error.'
                        }
                    });
                    $("#dropifyComprobantePago").dropify({
                        messages: {
                            'default': 'Arrastra y suelta el comprobante de pago o haz clic',
                            'replace': 'Arrastra y suelta el comprobante de pago haz clic para reemplazar',
                            'remove':  'Remover',
                            'error':   'Ooops, ocurrió un error.'
                        }
                    });
                    $("#modalImpresion").modal('open');
                }
            });
        }
        function subirContratoFirmado(idContrato)
        {
            console.log("Subiendo el contrato "+idContrato);
            $("#formContratoFirmado").submit();
        }
        function subirComprobante(idContrato)
        {
            console.log("Subiendo el comprobante "+idContrato);
            $("#formComprobantePago").submit();
        }
        $("#formContratoFirmado").submit(function (e) {
            e.preventDefault();
            console.log("Subiendo el contrato... "+$("#contratoSeleccionado").val());

            var form=new FormData(document.getElementById("formContratoFirmado"));
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/subirContratoFirmado/')?>'+$("#contratoSeleccionado").val(),
                data: form,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data)
                {
                    swal("Bien!", "El contrato firmado ha sido guardardo", "success");
                    console.log(JSON.stringify(data));
                }
            });
        });

        $("#formComprobantePago").submit(function (e) {
            e.preventDefault();
            console.log("Subiendo el comprobante... "+$("#contratoSeleccionado").val());

            var form=new FormData(document.getElementById("formComprobantePago"));
            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/subirComprobantePago/')?>'+$("#contratoSeleccionado").val(),
                data: form,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data)
                {
                    swal("Bien!", "El comprobante de pago ha sido guardardo", "success");
                    console.log(JSON.stringify(data));
                }
            });
        });

        function generarContrato()
        {
            var idContrato=$("#contratoSeleccionado").val();


            open('<?=base_url('index.php/CrudContrato/generacionContrato/')?>'+idContrato, 'Contrato', 'location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000');
        }
    </script>

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
                        <form id="formContratoFirmado" class="col s6">
                            <div class="col s12" id="dropifyContrato">

                            </div>
                            <div class="col s12" id="enlaceContratoFirmado">

                            </div>
                        </form>
                        <form id="formComprobantePago" class="col s6">
                            <div class="col s12" id="dropifyComprobantePago">

                            </div>
                            <div class="col s12" id="enlaceComprobantePago">

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
