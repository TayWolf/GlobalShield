<div class="container">
    <div class="row">
        <div class="col s12">

            <div class="col s11"><h4 class="header">Membresías</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div class="col s12">
                <div class="col s4 offset-s4" align="center">
                    <a onclick="loadUrl('CrudMembresia/altaMembresia/')" class="btn waves-effect waves-light">Nueva
                        membresía</a>
                </div>
            </div>
            <?php
        }?>
        <?php
        if($permisos['mostrar']) {
            ?>
            <div class="col s12">
                <table class="highlight">
                    <thead>
                    <tr>
                        <th style="display:none;">ID</th>
                        <th>Membresía</th>
                        <?php
                        if($permisosCostos['mostrar']) {
                            ?>
                            <th>Costos</th>
                            <?php
                        }?>
                        <?php
                        if($permisos['eliminar']) {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($membresias as $membresia) {

                        print "
                        <tr>
                        <td style='display: none;'>" . $membresia['idMembresia'] . "</td>
                        <td>" . $membresia['nombreMembresia'] . "</td>";
                        if($permisosCostos['mostrar'])
                            print "<td><a onclick='loadUrl(\"CrudCosto/verCostos/".$membresia['idMembresia']."\")'>Ver costos</a></td>";
                        if($permisos['eliminar'])
                            print "<td><a onclick='eliminarMembresia(" . $membresia['idMembresia'] . ", this)'>Eliminar</a></td>";
                        print "</tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }?>
    </div>
</div>
<script>
    var table;
    $(document).ready(function () {
        table=$("table").DataTable({
            language: {
                url: '<?=base_url('assets/i18n/Spanish.json')?>'
            }
        });
        <?php
        if($permisos['editar'])
        {
        ?>
        $("table").Tabledit({
            url: '<?=base_url('index.php/CrudMembresia/editarMembresia')?>',
            editButton: false,
            deleteButton: false,
            restoreButton: false,
            columns:
                {
                    identifier: [0, 'idMembresia'],
                    editable: [[1, 'nombreMembresia']]
                }
        });
        <?php
        }
        ?>

    });
    function eliminarMembresia(identificador, elemento) {

        Swal({

            title: 'Eliminar este registro?',

            text: "No se podran revertir los cambios!",

            type: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Si, borralo!'

        }).then((result) => {

            if (result.value) {

                $.post('<?=base_url('index.php/CrudMembresia/borrarMembresia')?>',
                    {idMembresia: identificador},
                    function (response) {
                        table.row($(elemento).closest('tr')).remove().draw();
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

</script>