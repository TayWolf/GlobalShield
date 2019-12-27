
<div class="container">
    <div class="row">

        <div class="col s12">
            <div class="col s11"><h4 class="header">CAJAS DEL SISTEMA</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudCaja/altaCaja')"
                   data-target='dropdown1'>Nueva caja</a>
            </div>
            <?php
        }
        if($permisos['mostrar']) {
            ?>

            <div class="col s12">
                <table id="mainTable" class="highlight">
                    <thead>
                    <tr>
                        <th style="display: none;">ID</th>
                        <th>Nombre</th>
                        <th>Especificaciones técnicas</th>
                        <?php
                        if ($permisos['eliminar']) {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($cajas as $caja) {
                        $idCaja = $caja['idCaja'];
                        $nombreCaja = $caja['nombreCaja'];
                        $especificaciones = rawurlencode($caja['especificaciones']);
                        print "
                    <tr>
                        <td style='display: none;'>$idCaja</td>
                        <td>$nombreCaja</td>
                        <td><a id='click$idCaja' onclick='verEspecificaciones($idCaja, \"" . rawurlencode($nombreCaja) . "\",\"$especificaciones\")'>Especificaciones técnicas</a></td>";
                        if ($permisos['eliminar'])
                            print "<td><a onclick='eliminarCaja($idCaja, this)'>Eliminar</a></td>";
                        print "</tr>";
                    }
                    ?>
                    </tbody>

                </table>
            </div>
            <?php
        }?>
    </div>
</div>

<!-- Modal Structure -->
<div id="modalEspecificaciones" class="modal">
    <div class="modal-content">
        <div class="row">
            <h4 class="col s12">Especificaciones técnicas '<data id="nombreCaja"></data>'</h4>
            <textarea class="materialize-textarea" id="especificaciones"></textarea>
            <input type="hidden" id="idCajaSeleccionada" name="idCajaSeleccionada">
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat" <?php if($permisos['editar']){?> onclick="guardarEspecificaciones()" <?php }?>>Guardar & cerrar</a>
    </div>
</div>

<script>
    var tabla;
    $(document).ready(function () {
        tabla=$("#mainTable").DataTable({language:{url: "<?=base_url('assets/i18n/Spanish.json')?>"}});

        $(".modal").modal();
        <?php
        if($permisos['editar'])
        {
        ?>
        $("table").Tabledit({
            url: '<?=base_url('index.php/CrudCaja/editarCaja/')?>',
            editButton: false,
            deleteButton: false,
            columns: {
                identifier: [0, 'idCaja'],
                editable: [[1, 'nombreCaja']]
            }
        });
        <?php
        }?>
    });
    <?php
    if($permisos['eliminar'])
    {?>
    function eliminarCaja(id, elemento) {
        Swal({
            title: 'Eliminar este registro?',
            text: "No se podran revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, borralo!'
        }).then((result) => {
            if (result.value) {
                $.post('<?=base_url('index.php/CrudCaja/borrarCaja/')?>',

                    {idCaja: id},

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
    }?>
    function verEspecificaciones(idCaja, nombreCaja ,especificaciones)
    {

        $("#idCajaSeleccionada").val(idCaja);
        $("#nombreCaja").html(decodeURIComponent(nombreCaja));
        $("#especificaciones").val(decodeURIComponent(especificaciones));
        $('#especificaciones').trigger('autoresize');
        $("#modalEspecificaciones").modal('open');

    }
    <?php
    if($permisos['editar'])
    {?>
    function guardarEspecificaciones() {
        $.post(
            '<?=base_url('index.php/CrudCaja/editarCaja/')?>',
            {idCaja: $("#idCajaSeleccionada").val(), especificaciones: $("#especificaciones").val()},
            function (response) {
                $("#click" + $("#idCajaSeleccionada").val()).attr("onClick", "verEspecificaciones('" + $("#idCajaSeleccionada").val() + "', '" + encodeURIComponent($("#nombreCaja").html()) + "', '" + encodeURIComponent($("#especificaciones").val()) + "')");
            }
        );

    }
    <?php
    }?>
</script>

