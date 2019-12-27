<?php
if(!empty($permisos)&&$permisos['mostrar'])
{
    ?>


    <div class="container">
        <div class="row">
            <div class="col s12">
                <h4 class="header">Mundo de cajas</h4>
            </div>
        </div>
        <?php
        if($permisos['alta'])
        {
            ?>
            <div class="row">
                <div class="col s12 m8" align="center">
                    <a onclick="loadUrl('CrudMundoCaja/altaCaja/')" class="btn waves-effect waves-light">Nueva caja</a>
                </div>
                <div class="col s12 m4" align="center" style="margin-top: 5px;">
                    <a  onclick="imprimirReporteMantenimiento();" class="btn waves-effect waves-light">Cajas en Mantenimiento PDF</a>
                </div>
            </div>
                
            <?php
        }
        ?>
        <div class="row">
            <div class="col s12">
                <table class="highlight" id="tablaMundoCaja">
                    <thead>
                    <th>Sucursal</th>
                    <th>Pasillo</th>
                    <th>Número de caja</th>
                    <th>Tipo de caja</th>
                    <th>Status</th>
                    <th class="center"><i class="material-icons">build</i></th>
                    <?php
                    if($permisos['editar'])
                    {
                        ?>
                        <th class="center"><i class="material-icons">edit</i></th>
                        <?php
                    }
                    if($permisos['eliminar'])
                    {
                        ?>
                        <th class="center"><i class="material-icons">delete_forever</i></th>
                        <?php
                    }
                    ?>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($mundoCajas as $mundoCaja)
                    {
                        $mandarMantenimiento="<a onclick='enviarCajaMantenimiento(".$mundoCaja['idMundoCaja'].", \"".$mundoCaja['pasillo']."-".$mundoCaja['numeroCaja']."\")'><i class='material-icons'>build</i></a>";
                        $btnStatus="";
                        $respaldoBtnStatus="";
                        if($mundoCaja['status']==0)
                        {
                            $btnStatus="<a class='btn center-align gradient-45deg-green-teal btn-small' >Disponible</a>";
                            $respaldoBtnStatus="<a class='btn center-align gradient-45deg-green-teal btn-small hide' id='botonOculto".$mundoCaja['idMundoCaja']."' >Disponible</a>";
                        }

                        else if($mundoCaja['status']==1)
                        {
                            $btnStatus="<a class='btn center-align gradient-45deg-amber-amber btn-small' onclick='verInformacionCajaOcupada(".$mundoCaja['idMundoCaja'].", \"".$mundoCaja['pasillo']."-".$mundoCaja['numeroCaja']."\")'>Ocupada</a>";
                            $respaldoBtnStatus="<a class='btn center-align gradient-45deg-amber-amber btn-small hide' id='botonOculto".$mundoCaja['idMundoCaja']."' onclick='verInformacionCajaOcupada(".$mundoCaja['idMundoCaja'].", \"".$mundoCaja['pasillo']."-".$mundoCaja['numeroCaja']."\")'>Ocupada</a>";
                        }


                        //Deshabilita el icono de mantenimiento y coloca el boton en mantenimiento

                        if($mundoCaja['statusReparacion']==1)
                        {
                            $btnStatus="<a class='btn center-align gradient-45deg-red-pink btn-small' onclick='quitarDeMantenimiento(".$mundoCaja['idMundoCaja'].", \"".$mundoCaja['pasillo']."-".$mundoCaja['numeroCaja']."\", this)' >Mantenimiento</a>";
                            $mandarMantenimiento="<i class='material-icons'>build</i>";
                        }
                        print "<tr>
                                <td>".$mundoCaja['nombreSucursal']."</td>
                                <td>".$mundoCaja['pasillo']."</td>
                                <td>".$mundoCaja['numeroCaja']."</td>
                                <td>".$mundoCaja['tipoCaja']."</td>
                                <td class='text-center center' id='statusCaja".$mundoCaja['idMundoCaja']."'>".$btnStatus.$respaldoBtnStatus."</td>
                                <td class='text-center center' id='statusCajaLink".$mundoCaja['idMundoCaja']."'>$mandarMantenimiento</td>";
                        if($permisos['editar'])
                            print "<td class='center'><a onclick='loadUrl(\"CrudMundoCaja/editarCaja/".$mundoCaja['idMundoCaja']."\")'><i class=\"material-icons\">edit</i></a></td>";
                        if($permisos['eliminar'])
                            print "<td class='center'><a onclick='eliminarMundoCaja(\"".$mundoCaja['idMundoCaja']."\", this)'><i class=\"material-icons\">delete_forever</i></a></td>";
                        print "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalStatusCaja" class="modal">
        <div class="modal-content">
            <h4 id="nombreCajaOcupadaSeleccionada">Información de la caja </h4>

            <div class="collection">
                <a class="collection-item">Cliente: <label id="clienteCajaOcupada"></label></a>
                <a class="collection-item">Membresía: <label id="membresiaCajaOcupada"></label></a>
                <a class="collection-item">Fecha de registro del contrato: <label id="fechaContratoCajaOcupada"></label></a>
                <a class="collection-item">Fecha de termino: <label id="fechaTerminoCajaOcupada"></label></a>
            </div>

        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
    <div id="modalMantenimiento" class="modal">
        <div class="modal-content">
            <h4 id="tituloMantenimiento">Mantenimiento de la caja </h4>
            <div class="row">
                <form id="formularioMantenimiento">
                    <div class="col s12">
                        <div class="input-field col s12">
                            <input type="hidden" id="cajaSeleccionadaMantenimiento" name="cajaSeleccionadaMantenimiento">
                            <textarea class="materialize-textarea" id="motivoMantenimiento" name="motivoMantenimiento"></textarea>
                            <label for="motivoMantenimiento">Motivo del mantenimiento</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="left"><a class="modal-close waves-effect waves-green btn-flat">Cerrar</a></div>
            <div class="right"><a class="modal-close waves-effect waves-green btn-flat" onclick="mantenimientoCaja();">Enviar a mantenimiento</a></div>

        </div>
    </div>

    <script>
        var tabla;
        $(document).ready(function () {
            $('#tablaMundoCaja thead tr').clone(true).appendTo( '#tablaMundoCaja thead' );
            $('#tablaMundoCaja thead tr:eq(1) th').each( function (i) {
                if(i<5)
                {
                    var title = $(this).text();
                    $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );

                    $( 'input', this ).on( 'keyup change', function () {
                        if ( tabla.column(i).search() !== this.value ) {
                            tabla
                                .column(i)
                                .search( this.value )
                                .draw();
                        }
                    } );
                }

            } );
            tabla=$("#tablaMundoCaja").DataTable({
                language:{
                    url: "<?=base_url('assets/i18n/Spanish.json')?>"
                },
                orderCellsTop: true,
                fixedHeader: true
            });
            $(".modal").modal();
        });
        <?php
        if($permisos['eliminar'])
        {
        ?>
        function eliminarMundoCaja(identificador, elemento) {

            Swal({

                title: 'Eliminar este registro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Si, borralo!'

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/CrudMundoCaja/eliminarCaja')?>',

                        {idMundoCaja: identificador},

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
        function verInformacionCajaOcupada(idMundoCaja, nombreCaja)
        {
            $.ajax({
                url: '<?=base_url('index.php/CrudMundoCaja/getInformacionCajaOcupada/')?>'+idMundoCaja,
                dataType: 'JSON',
                success: function (data)
                {

                    $("#nombreCajaOcupadaSeleccionada").html("Información de la caja "+nombreCaja);
                    $("#clienteCajaOcupada").html(data['nombreCliente']);
                    $("#membresiaCajaOcupada").html(data['nombreMembresia']);
                    $("#fechaContratoCajaOcupada").html(data['fechaRegistro']);
                    $("#fechaTerminoCajaOcupada").html(data['fechaTermino']);
                    $("#modalStatusCaja").modal('open');
                }
            });
        }
        //Abre el modal del mantenimiento
        function enviarCajaMantenimiento(idMundoCaja, cajaEnviada)
        {
            $("#cajaSeleccionadaMantenimiento").val(idMundoCaja);
            $("#motivoMantenimiento").val('');
            $('#motivoMantenimiento').trigger('autoresize');
            $("#tituloMantenimiento").html("Mantenimiento de la caja "+cajaEnviada);
            $("#modalMantenimiento").modal('open');
        }
        //Envia una caja a mantenimiento
        function mantenimientoCaja()
        {
            Swal.fire({
                title: 'Procesando...',
                onBeforeOpen: () => {
                    Swal.showLoading();
                }});
            var idCaja=$("#cajaSeleccionadaMantenimiento").val();
            var form=new FormData(document.getElementById('formularioMantenimiento'));
            $.ajax({
                url: '<?=base_url('index.php/CrudMundoCaja/enviarCajaMantenimiento/')?>',
                data: form,
                type: 'POST',
                contentType: false,
                dataType: 'HTML',
                processData: false,
                success: function (data)
                {
                    Swal.close();
                    swal("Bien", "Se ha enviado la caja a mantenimiento", "success");
                    $("#statusCaja"+idCaja).html("<a class='btn center-align gradient-45deg-red-pink btn-small' >Mantenimiento</a>");
                    $("#statusCajaLink"+idCaja).html('<i class="material-icons">build</i>');
                }

            });
        }
        function quitarDeMantenimiento(idMundoCaja, numeroCaja, botonDeMantenimiento)
        {
            Swal.fire({
                title: '¿La caja '+numeroCaja+' ha sido reparada?',
                type: 'question',
                showCancelButton: true,
                text: 'Se quitará de mantenimiento',
                confirmButtonText: 'Si, ha sido reparada',
                cancelButtonText: 'Cancelar',
            }).then(function (confirm) {
                if(confirm.value)
                {
                    $.ajax({
                        url: '<?=base_url('index.php/CrudMundoCaja/quitarReparacionCaja/')?>'+idMundoCaja,
                        success:function (result)
                        {
                            $(botonDeMantenimiento).remove();
                            $("#botonOculto"+idMundoCaja).removeClass("hide");
                            swal("Bien!", "La caja ha sido reparada!", "success");
                        }
                    });
                }

            });
        }
        function imprimirReporteMantenimiento()
        {
            open('<?=base_url('index.php/CrudMundoCaja/generacionReporteMantenimiento/')?>','ReporteMantenimiento', 'location=no,toolbar=no,menubar=no,width=0,height=0,left=-1000,top=-1000');
        }
    </script>
    <?php
}
?>