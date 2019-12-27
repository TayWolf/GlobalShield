<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12 m11"><h4 class="header">Tipos de usuarios</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudtipou/altaTipo')"
                   data-target='dropdown1'>Nuevo Tipo</a>
            </div>
            <?php
        }?>
        <?php
        if($permisos['mostrar']) {
            ?>
            <div class="col s12">
                <div class="col s12 ">
                    <table class="highlight" id="tabla">
                        <thead>
                        <tr>
                            <th style="display: none;">ID</th>
                            <th>Tipo</th>
                            <?php
                            if ($permisosPermisos['mostrar']) {
                                ?>
                                <th>Permisos</th>
                                <?php
                            }
                            if ($permisos['eliminar']) {
                                ?>
                                <th>Eliminar</th>
                                <?php
                            } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $contador = 1;

                        foreach ($infoTipo as $row) {

                            $clase = ($contador++ % 2 == 0) ? 'odd' : 'even';

                            echo "<tr class='$clase' role='row'>
                                    <td id='indice" . $row['idTipoUsuario'] . "' style=\"display: none;\">" . $row['idTipoUsuario'] . "</td>
                                    <td>" . $row['nombreTipoUsuario'] . "</td>";
                            if ($permisosPermisos['mostrar'])
                                echo "<td><a onclick='loadUrl(\"CrudPermisos/verPermisos/" . $row['idTipoUsuario'] . "\")'>Permisos</a></td>";
                            if ($permisos['eliminar'])
                                echo "<td><a href='#' onclick='borrar(" . $row['idTipoUsuario'] . ", this)'>Eliminar</a></td>";
                            echo "</tr>";

                        }

                        ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php
        }?>
    </div>
    <script>

        var tabla;

        $(document).ready( function ()
        {
            tabla=$("#tabla").DataTable({
                language:{
                    url: "<?=base_url('assets/i18n/Spanish.json')?>"
                }
            });
            <?php
            if($permisos['editar'])
            {
                ?>
            $('#tabla').Tabledit({

                editButton: false,

                deleteButton: false,

                restoreButton: false,

                url: '<?=base_url('index.php/Crudtipou/editarTipo')?>',

                columns: {

                    identifier: [0, 'idTipoUsuario'],

                    editable: [[1, 'nombreTipoUsuario']]

                }

            });
            <?php
                }?>

        } );

    </script>

    <script>
        <?php
        if($permisos['eliminar'])
        {?>
            function borrar(identificador, elemento) {

            Swal({

                title: 'Eliminar este registro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Si, borralo!'

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/Crudtipou/borrarTipo')?>',

                        {idTipoUsuario: identificador},

                        function (response) {

                            //console.log(response);

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

    </script>