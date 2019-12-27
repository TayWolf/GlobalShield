
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">USUARIOS REGISTRADOS</h4></div>
        </div>
        <?php
        if($permisos['alta']) {
            ?>
            <div align="center">
                <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudusuarios/altaUsuarios')" data-target='dropdown1'>Nuevo Usuario</a>
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
                    <th>NickName</th>                    
                    <th>Tipo de Usuario</th>
                    <th>Correo</th>
                    <th>Status</th>
                    <th>Sucursales</th>
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
                $contador = 1;
                foreach ($Usuario as $row) {
                    $idUser = $row["idUsuario"];
                    $nombreUser = $row["nombreUsuario"];
                    $nickName = $row["nickname"];
                    $nombreTipo = $row["nombreTipoUsuario"];
                    $correoUsuario = $row["correoUsuario"];
                    $Status = $row['status'];
                    $status = ($Status==1)?'checked':'';

                    $clase = ($contador % 2 == 0) ? 'odd' : 'even';
                    echo "<tr class='$clase' role='row'>
                        <td id='indice" . $row['idUsuario'] . "' style='display:none'>$idUser</td>
                        <td>$nombreUser</td>
                        <td>$nickName</td>                        
                        <td>$nombreTipo</td>
                        <td>$correoUsuario</td>
                        <td>
                        <div class=\"switch\">
                            <label>
                              <input type=\"checkbox\" id='activado".$idUser."' ".$status." onclick='activarUsuario(" .$row['idUsuario']. ")'>
                              <span class=\"lever\"></span>
                            </label>
                        </div>
                        </td> 
                        <td><a id='click$idUser' onclick='verSucursales($idUser)'>Sucursales</a></td>";

                    if($permisos['eliminar'])
                        echo "<td><a href='#' onclick='borrar(" . $row['idUsuario'] . ", this)'>Eliminar</a></td>";
                    echo "</tr>";
                    $contador++;
                }
                ?>
                </tbody>

            </table>
        </div>


    </div>
</div>

<!-- Modal Structure -->
<div id="modalSucursales" class="modal">
    <div class="modal-content">
        <h4>Sucursales a las que pertenece el usuario <data id="nombreUsuario"></data> </h4>
        <div class="row col s12">
           <!--  <textarea class="materialize-textarea" id="nombreSucursal"></textarea> -->
            <input type="hidden" id="idUsuarioSeleccionado" name="idUsuarioSeleccionado">
            <div class="col s12" id="contenidoEmpresas">
                <?php
                foreach ($sucursal as $sucursal)
                {
                    echo "<div class='col s12'><input class='sucursalCheck' type=\"checkbox\" onChange='cambiarStatusSucursalUsuario(".$sucursal['idSucursal'].")' id=\"cboxSucursal".$sucursal['idSucursal']."\" value=\"".$sucursal['idSucursal']."\"><label for=\"cboxSucursal".$sucursal['idSucursal']."\">".$sucursal['nombreSucursal']."</label></div>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat" <?php if($permisos['editar']){?>  <?php }?>>Guardar & cerrar</a>

    </div>
</div>



    <?php
    }?>
    <script>

        var tabla;

        $(document).ready( function ()
        {

            tabla=$("table").DataTable({"language": {"url": "<?=base_url('assets/i18n/Spanish.json')?>"}});

            $(".modal").modal();

            var TipoU = <?php print json_encode($TipoU); ?>;
            var tip = '{ ';
            TipoU.forEach(function (element) {
                tip += '"'+element.idTipoUsuario+'": "'+element.nombreTipoUsuario+'",';
            });
            var lastIndexT = tip.lastIndexOf(",");
            var JSONTip = tip.substring(0,lastIndexT)+"}"
            

            <?php
            if($permisos['editar'])
            {
            ?>
            $('table').Tabledit({
                editButton: false,
                deleteButton: false,
                restoreButton: false,
                url: '<?=base_url('index.php/Crudusuarios/editaDatos')?>',
                columns: {
                    identifier: [0, 'idUsuario'],
                    editable: [[1, 'nombreUsuario'], [2, 'nickname'], [3, 'idTipoUsuario', JSONTip], [4, 'correoUsuario']]
                }

            });
            
            <?php
            }?>

        } );

    </script>

    <script>
        <?php
        if($permisos['eliminar'])
        {
        ?>

        function borrar(identificador, elemento) {

            Swal({

                title: 'Eliminar este registro?',

                text: "No se podran revertir los cambios!",

                type: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Si, borralo!'

            }).then((result) => {

                if (result.value) {

                    $.post('<?=base_url('index.php/Crudusuarios/borrarUser')?>',

                        {idUsuario: identificador},

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

    <script >   
        function establecerUsuarioSeleccionado(idUser)
            {

                $( ".sucursalCheck" ).prop({
                    checked: false
                });

                $("#idUsuarioSeleccionado").val(idUser);
                console.log("limpiar");
            } 

        function verSucursales(idUser)
            {         
                establecerUsuarioSeleccionado(idUser);
                $.ajax({
                    url: '<?=base_url('index.php/Crudusuarios/cargarSucusal/')?>'+idUser,
                    dataType: 'JSON',
                    success: function (data)
                    {
                        for(i=0; i<data.length; i++)
                        {
                            $("#cboxSucursal"+data[i]['idSucursal']).prop({
                                checked:true
                            });
                        }
                    },
                    complete: function () {
                        $('#modalSucursales').modal('open');
                    }
                });
            

            }
        <?php
        if($permisos['editar'])
        {?>

        function cambiarStatusSucursalUsuario(idSucursal)
            {
                if($("#cboxSucursal"+idSucursal).prop("checked"))
                    $.ajax({url: '<?=base_url('index.php/Crudusuarios/asignarSucursalUsuario')?>/'+idSucursal+'/'+$("#idUsuarioSeleccionado").val()});
                else
                    $.ajax({url: '<?=base_url('index.php/Crudusuarios/eliminarSucursalUsuario')?>/'+idSucursal+'/'+$("#idUsuarioSeleccionado").val()});
            }

        function activarUsuario(idUser)
            {
                if($("#activado"+idUser).prop("checked"))
                    $.ajax({url: '<?=base_url('index.php/Crudusuarios/activarStatusUsuario')?>/'+idUser});
                else
                    $.ajax({url: '<?=base_url('index.php/Crudusuarios/desactivarStatusUsuario')?>/'+idUser});
            }    
            

        <?php
        
        }?>
    </script>