<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Costos de la membresía</h4>
        </div>
        <div class="row">
            <div class="col s6 m3 offset-m3"  align="center">
                <a onclick="loadUrl('CrudMembresia')" class="btn waves-effect waves-light">Regresar</a>
            </div>
            <div class="col s6 m3" align="center">
                <?php
                if($permisos['alta']) {
                    ?>
                    <a onclick="loadUrl('CrudCosto/formAltaCosto/<?=$idMembresia?>')" class="btn waves-effect waves-light">Nuevo costo</a>
                    <?php
                }?>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <table class="highlight">
                <thead>
                <tr>
                    <th style="display: none">ID</th>
                    <th>Membresia</th>
                    <th>Caja</th>
                    <th>Años</th>
                    <th>Meses</th>
                    <th>Días</th>
                    <th>Costo (MXN)</th>
                    <?php
                    if($permisos['eliminar'])
                    {
                        ?>
                        <th>Eliminar</th>
                        <?php
                    }?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($costos as $costo)
                {
                    print "<tr>
                                <td style='display: none;'>".$costo['idCosto']."</td>
                                <td>".$costo['nombreMembresia']."</td>
                                <td>".$costo['nombreCaja']."</td>
                                <td>".$costo['numeroAnios']."</td>
                                <td>".$costo['numeroMeses']."</td>
                                <td>".$costo['numeroDias']."</td>
                                <td>".$costo['costo']."</td>";
                    if($permisos['eliminar'])
                        print "<td><a onclick='eliminar(".$costo['idCosto'].", this)'>Eliminar</a></td>";
                    print"</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var tabla;
    $(document).ready(function () {
        tabla=$("table").DataTable({
            language:{
                url: '<?=base_url('assets/i18n/Spanish.json')?>'
            }
        });
        var Catalogo = <?php print json_encode($cajas); ?>;
        var stringJSON= '{ ';
        Catalogo.forEach(function (element) {
            stringJSON += '"'+element.idCaja+'": "'+element.nombreCaja+'",';
        });
        var lastIndex = stringJSON.lastIndexOf(",");
        var JSON= stringJSON.substring(0,lastIndex)+"}";
        <?php
        if($permisos['editar'])
        {
        ?>
        $("table").Tabledit({
            url: '<?=base_url('index.php/CrudCosto/editarCosto/')?>',
            deleteButton: false,
            editButton: false,
            columns: {
                identifier: [0, 'idCosto'],
                editable: [[2, 'idCaja', JSON], [3, 'numeroAnios'], [4, 'numeroMeses'], [5, 'numeroDias'], [6, 'costo']]
            }
        });
        <?php
        }?>
    });
    <?php
    if($permisos['eliminar'])
    {
    ?>
        function eliminar(identificador, elemento) {

        Swal({

            title: 'Eliminar este registro?',

            text: "No se podran revertir los cambios!",

            type: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Si, borralo!'

        }).then((result) => {

            if (result.value) {

                $.post('<?=base_url('index.php/CrudCosto/eliminarCosto')?>',

                    {idCosto: identificador},

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
</script>