<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Seguros</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudSeguro/altaSeguro')"
                   data-target='dropdown1'>Nuevo Seguro</a>
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
                            <th>Costo Anual</th>
                            <th>Protección</th>
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

                        $contador = 1;

                        foreach ($infoSeguro as $row) {

                            $clase = ($contador++ % 2 == 0) ? 'odd' : 'even';

                            echo "<tr class='$clase' role='row'>
                                    <td id='indice" . $row['idSeguro'] . "' style=\"display: none;\">" . $row['idSeguro'] . "</td>
                                    <td>" . $row['costoAnual'] . "</td>
                                    <td>" . $row['proteccion'] . "</td>";
                            if ($permisos['eliminar'])
                                echo "<td><a href='#' onclick='borrar(" . $row['idSeguro'] . ", this)'>Eliminar</a></td>";
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
        }
        ?>
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

                url: '<?=base_url('index.php/CrudSeguro/editarSeguro')?>',

                columns: {

                    identifier: [0, 'idSeguro'],

                    editable: [[1, 'costoAnual'],[2, 'proteccion']]

                }

            });
            
                $("input[name*='proteccion']").attr("type",'number');
                $("input[name*='costoAnual']").attr("type",'number');
            <?php
            }
            ?>

        } );

    </script>

    <script>
        <?php
        if($permisos['eliminar'])
        { ?>
            function borrar(identificador, elemento) {

            Swal({

                title: 'Eliminar este seguro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Si, borralo!'

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/CrudSeguro/borrarSeguro')?>',

                        {idSeguro: identificador},

                        function (response) {

                            //console.log(response);

                            tabla.row($(elemento).closest('tr')).remove().draw();

                            Swal(
                                'Borrado!',

                                'El seguro fue eliminado',

                                'success'
                            );

                        }
                    );


                }

            })

        }
        <?php
        } ?>

    </script>