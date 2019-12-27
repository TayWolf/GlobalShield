<?php
if(!empty($permisos)&&$permisos['mostrar'])
{
  ?>


    <div class="container">
        <div class="row">
            <div class="col s12">
                <h4 class="header">Sucursales</h4>
            </div>
        </div>
        <?php
        if($permisos['alta'])
        {
            ?>
            <div class="row">

                <div class="col s12" align="center">
                    <a onclick="loadUrl('CrudSucursal/altaSucursal/')" class="btn waves-effect waves-light">Nueva sucursal</a>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col s12">
                <table class="highlight">
                    <thead>
                        <th>Sucursal</th>
                        <?php
                        if($permisos['detalle'])
                        {
                            ?>
                            <th>Detalles</th>
                            <?php
                        }
                        if($permisos['editar'])
                        {
                            ?>
                            <th>Editar</th>
                            <?php
                        }
                        if($permisos['eliminar'])
                        {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }
                        ?>
                    </thead>
                    <tbody>
                    <?php
                    $contador=1;
                    foreach ($sucursales as $sucursal)
                    {
                        $clase = ($contador % 2 == 0) ? 'odd' : 'even';
                        echo "<tr  class='$clase' role='row'>
                                <td>".$sucursal['nombreSucursal']."</td>";
                        if($permisos['detalle'])
                            print "<td><a onclick='loadUrl(\"CrudSucursal/verDetalleSucursal/".$sucursal['idSucursal']."\")'>Ver detalles</a></td>";
                        if($permisos['editar'])
                            print "<td><a onclick='loadUrl(\"CrudSucursal/editarSucursal/".$sucursal['idSucursal']."\")'>Editar</a></td>";
                        if($permisos['eliminar'])
                            print "<td><a onclick='eliminarSucursal(\"".$sucursal['idSucursal']."\", this)'>Eliminar</a></td>";
                        print "</tr>";
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
                    url: "<?=base_url('assets/i18n/Spanish.json')?>"
                }
            });
        });
    <?php
    if($permisos['eliminar'])
    {
        ?>
        function eliminarSucursal(identificador, elemento) {

            Swal({

                title: 'Eliminar este registro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Si, borralo!'

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/CrudSucursal/eliminarSucursal')?>',

                        {idSucursal: identificador},

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
    </script>
<?php
}
?>