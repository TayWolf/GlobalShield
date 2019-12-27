<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Técnicos de mantenimiento</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudMantenimiento/altaTecnico')"
                   data-target='dropdown1'>Nuevo Técnico</a>
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
                            <th>Nombre del Técnico</th>
                            <th>Correo del Técnico</th>
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
                                $idTecnico = $row["idTecnico"];
                                $nombreTecnico = $row["nombreTecnico"];
                                $correoTecnico = $row["correoTecnico"];
                                
                                $clase = ($contador % 2 == 0) ? 'odd' : 'even';
                            echo "<tr  class='$clase' role='row'>
                                <td id='indice" . $row['idTecnico'] . "' style='display:none'>$idTecnico</td>
                                    <td>$nombreTecnico</td>
                                    <td>$correoTecnico</td>";

                            if ($permisos['eliminar'])
                                echo "<td><a href='#' onclick='borrar(" . $row['idTecnico'] . ", this)'>Eliminar</a></td>";
                            echo "</tr>";

                        }

                        ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
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

                url: '<?=base_url('index.php/CrudMantenimiento/editarTec')?>',

                columns: {

                    identifier: [0, 'idTecnico'],

                    editable: [[1, 'nombreTecnico'], [2, 'correoTecnico']]

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

                    $.post('<?=base_url('index.php/CrudMantenimiento/borrarTecnico')?>',

                        {idTecnico: identificador},

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