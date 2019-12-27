<style>
    p{
        margin: 0px !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s12"><h4 class="header">Permisos para <?=$nombreTipoUsuario?></h4></div>
        </div>
        <div class="col s12" align="center">
            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudtipou/')" data-target='dropdown1'>Regresar</a>
        </div>
        <div class="col s12">
            <?php
            if($permisos['mostrar']) {
                ?>
                <div class="col s12 ">
                    <table class="highlight" id="tabla">
                        <thead>
                        <tr>
                            <!--<th>ID MODULO</th>-->
                            <th>Módulo</th>
                            <th>Mostrar</th>
                            <th>Alta</th>
                            <th>Detalles</th>
                            <th>Edición</th>
                            <th>Eliminación</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>Tipos de usuario</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo0" name="mostrarModulo0"
                                           onChange="mostrar(0);"/>
                                    <label for="mostrarModulo0"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo0" name="altaModulo0" onChange="alta(0);"/>
                                    <label for="altaModulo0"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo0" name="detallesModulo0"
                                           onChange="detalles(0);"/>
                                    <label for="detallesModulo0"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo0" name="edicionModulo0"
                                           onChange="editar(0);"/>
                                    <label for="edicionModulo0"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo0" name="eliminacionModulo0"
                                           onChange="eliminar(0);"/>
                                    <label for="eliminacionModulo0"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Usuarios</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo1" name="mostrarModulo1"
                                           onChange="mostrar(1);"/>
                                    <label for="mostrarModulo1"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo1" name="altaModulo1" onChange="alta(1);"/>
                                    <label for="altaModulo1"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo1" name="detallesModulo1"
                                           onChange="detalles(1);"/>
                                    <label for="detallesModulo1"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo1" name="edicionModulo1"
                                           onChange="editar(1);"/>
                                    <label for="edicionModulo1"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo1" name="eliminacionModulo1"
                                           onChange="eliminar(1);"/>
                                    <label for="eliminacionModulo1"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Cajas</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo2" name="mostrarModulo2"
                                           onChange="mostrar(2);"/>
                                    <label for="mostrarModulo2"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo2" name="altaModulo2" onChange="alta(2);"/>
                                    <label for="altaModulo2"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo2" name="detallesModulo2"
                                           onChange="detalles(2);"/>
                                    <label for="detallesModulo2"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo2" name="edicionModulo2"
                                           onChange="editar(2);"/>
                                    <label for="edicionModulo2"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo2" name="eliminacionModulo2"
                                           onChange="eliminar(2);"/>
                                    <label for="eliminacionModulo2"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Membresías</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo3" name="mostrarModulo3"
                                           onChange="mostrar(3);"/>
                                    <label for="mostrarModulo3"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo3" name="altaModulo3" onChange="alta(3);"/>
                                    <label for="altaModulo3"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo3" name="detallesModulo3"
                                           onChange="detalles(3);"/>
                                    <label for="detallesModulo3"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo3" name="edicionModulo3"
                                           onChange="editar(3);"/>
                                    <label for="edicionModulo3"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo3" name="eliminacionModulo3"
                                           onChange="eliminar(3);"/>
                                    <label for="eliminacionModulo3"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Contratos</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo4" name="mostrarModulo4"
                                           onChange="mostrar(4);"/>
                                    <label for="mostrarModulo4"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo4" name="altaModulo4" onChange="alta(4);"/>
                                    <label for="altaModulo4"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo4" name="detallesModulo4"
                                           onChange="detalles(4);"/>
                                    <label for="detallesModulo4"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo4" name="edicionModulo4"
                                           onChange="editar(4);"/>
                                    <label for="edicionModulo4"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo4" name="eliminacionModulo4"
                                           onChange="eliminar(4);"/>
                                    <label for="eliminacionModulo4"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Permisos de un tipo de usuario</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo5" name="mostrarModulo5"
                                           onChange="mostrar(5);"/>
                                    <label for="mostrarModulo5"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo5" name="altaModulo5" onChange="alta(5);"/>
                                    <label for="altaModulo5"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo5" name="detallesModulo5"
                                           onChange="detalles(5);"/>
                                    <label for="detallesModulo5"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo5" name="edicionModulo5"
                                           onChange="editar(5);"/>
                                    <label for="edicionModulo5"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo5" name="eliminacionModulo5"
                                           onChange="eliminar(5);"/>
                                    <label for="eliminacionModulo5"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Clientes</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo6" name="mostrarModulo6" onChange="mostrar(6);" />
                                    <label for="mostrarModulo6"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo6" name="altaModulo6" onChange="alta(6);" />
                                    <label for="altaModulo6"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo6" name="detallesModulo6" onChange="detalles(6);" />
                                    <label for="detallesModulo6"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo6" name="edicionModulo6" onChange="editar(6);" />
                                    <label for="edicionModulo6"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo6" name="eliminacionModulo6" onChange="eliminar(6);" />
                                    <label for="eliminacionModulo6"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Documentos de un cliente</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo7" name="mostrarModulo7" onChange="mostrar(7);" />
                                    <label for="mostrarModulo7"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo7" name="altaModulo7" onChange="alta(7);" />
                                    <label for="altaModulo7"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo7" name="detallesModulo7" onChange="detalles(7);" />
                                    <label for="detallesModulo7"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo7" name="edicionModulo7" onChange="editar(7);" />
                                    <label for="edicionModulo7"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo7" name="eliminacionModulo7" onChange="eliminar(7);" />
                                    <label for="eliminacionModulo7"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Costos de una membresía</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo8" name="mostrarModulo8" onChange="mostrar(8);" />
                                    <label for="mostrarModulo8"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo8" name="altaModulo8" onChange="alta(8);" />
                                    <label for="altaModulo8"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo8" name="detallesModulo8" onChange="detalles(8);" />
                                    <label for="detallesModulo8"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo8" name="edicionModulo8" onChange="editar(8);" />
                                    <label for="edicionModulo8"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo8" name="eliminacionModulo8" onChange="eliminar(8);" />
                                    <label for="eliminacionModulo8"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Sucursales</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo9" name="mostrarModulo9" onChange="mostrar(9);" />
                                    <label for="mostrarModulo9"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo9" name="altaModulo9" onChange="alta(9);" />
                                    <label for="altaModulo9"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo9" name="detallesModulo9" onChange="detalles(9);" />
                                    <label for="detallesModulo9"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo9" name="edicionModulo9" onChange="editar(9);" />
                                    <label for="edicionModulo9"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo9" name="eliminacionModulo9" onChange="eliminar(9);" />
                                    <label for="eliminacionModulo9"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Mundo de cajas</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo10" name="mostrarModulo10" onChange="mostrar(10);" />
                                    <label for="mostrarModulo10"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo10" name="altaModulo10" onChange="alta(10);" />
                                    <label for="altaModulo10"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo10" name="detallesModulo10" onChange="detalles(10);" />
                                    <label for="detallesModulo10"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo10" name="edicionModulo10" onChange="editar(10);" />
                                    <label for="edicionModulo10"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo10" name="eliminacionModulo10" onChange="eliminar(10);" />
                                    <label for="eliminacionModulo10"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Morosos</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo11" name="mostrarModulo11" onChange="mostrar(11);" />
                                    <label for="mostrarModulo11"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo11" name="altaModulo11" onChange="alta(11);" />
                                    <label for="altaModulo11"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo11" name="detallesModulo11" onChange="detalles(11);" />
                                    <label for="detallesModulo11"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo11" name="edicionModulo11" onChange="editar(11);" />
                                    <label for="edicionModulo11"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo11" name="eliminacionModulo11" onChange="eliminar(11);" />
                                    <label for="eliminacionModulo11"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Seguros</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo12" name="mostrarModulo12" onChange="mostrar(12);" />
                                    <label for="mostrarModulo12"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo12" name="altaModulo12" onChange="alta(12);" />
                                    <label for="altaModulo12"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo12" name="detallesModulo12" onChange="detalles(12);" />
                                    <label for="detallesModulo12"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo12" name="edicionModulo12" onChange="editar(12);" />
                                    <label for="edicionModulo12"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo12" name="eliminacionModulo12" onChange="eliminar(12);" />
                                    <label for="eliminacionModulo12"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Técnicos (Mantenimiento)</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo13" name="mostrarModulo13" onChange="mostrar(13);" />
                                    <label for="mostrarModulo13"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo13" name="altaModulo13" onChange="alta(13);" />
                                    <label for="altaModulo13"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo13" name="detallesModulo13" onChange="detalles(13);" />
                                    <label for="detallesModulo13"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo13" name="edicionModulo13" onChange="editar(13);" />
                                    <label for="edicionModulo13"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo13" name="eliminacionModulo13" onChange="eliminar(13);" />
                                    <label for="eliminacionModulo13"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Contratos terminados</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo14" name="mostrarModulo14" onChange="mostrar(14);" />
                                    <label for="mostrarModulo14"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo14" name="altaModulo14" onChange="alta(14);" />
                                    <label for="altaModulo14"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo14" name="detallesModulo14" onChange="detalles(14);" />
                                    <label for="detallesModulo14"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo14" name="edicionModulo14" onChange="editar(14);" />
                                    <label for="edicionModulo14"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo14" name="eliminacionModulo14" onChange="eliminar(14);" />
                                    <label for="eliminacionModulo14"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Facturación</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo15" name="mostrarModulo15" onChange="mostrar(15);" />
                                    <label for="mostrarModulo15"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo15" name="altaModulo15" onChange="alta(15);" />
                                    <label for="altaModulo15"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo15" name="detallesModulo15" onChange="detalles(15);" />
                                    <label for="detallesModulo15"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo15" name="edicionModulo15" onChange="editar(15);" />
                                    <label for="edicionModulo15"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo15" name="eliminacionModulo15" onChange="eliminar(15);" />
                                    <label for="eliminacionModulo15"></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Tarjetas de un contrato</td>
                            <td>
                                <p>
                                    <input type="checkbox" id="mostrarModulo16" name="mostrarModulo16" onChange="mostrar(16);" />
                                    <label for="mostrarModulo16"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="altaModulo16" name="altaModulo16" onChange="alta(16);" />
                                    <label for="altaModulo16"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="detallesModulo16" name="detallesModulo16" onChange="detalles(16);" />
                                    <label for="detallesModulo16"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="edicionModulo16" name="edicionModulo16" onChange="editar(16);" />
                                    <label for="edicionModulo16"></label>
                                </p>
                            </td>
                            <td>
                                <p>
                                    <input type="checkbox" id="eliminacionModulo16" name="eliminacionModulo16" onChange="eliminar(16);" />
                                    <label for="eliminacionModulo16"></label>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <?php
            }?>
        </div>
    </div>

    <script>

        $(document).ready( function (){
            $.ajax({
                url: '<?=base_url('/index.php/CrudPermisos/getPermisosUsuario/'.$idTipo)?>',
                type:'POST',
                dataType: 'JSON',
                success: function (data)
                {
                    var tipoUsuario=<?=$idTipo?>;
                    var permisoEditar=<?=$permisos['editar']?>;
                    for(i=0; i<data.length; i++)
                    {
                        $("#mostrarModulo"+data[i]['idModulo']).attr("checked",data[i]['mostrar']!="0");
                        $("#altaModulo"+data[i]['idModulo']).attr("checked", data[i]['alta']!="0");
                        $("#detallesModulo"+data[i]['idModulo']).attr("checked", data[i]['detalle']!="0");
                        $("#edicionModulo"+data[i]['idModulo']).attr("checked", data[i]['editar']!="0");
                        $("#eliminacionModulo"+data[i]['idModulo']).attr("checked", data[i]['eliminar']!="0");
                    }
                    if(tipoUsuario==1||permisoEditar==0)
                    {
                        $('input').attr("disabled", "disabled");
                    }
                },
                complete: function () {
                    $('.tooltipped').tooltip({delay: 30});

                    tabla=$("#tabla").DataTable({
                        language: {
                            url: '<?=base_url('assets/i18n/Spanish.json')?>'
                        }
                    });
                }
            });


        });
        <?php
        if($permisos['editar'])
        {
        ?>
        function mostrar(idModulo) {
            var url;
            if ($("#mostrarModulo" + idModulo).prop("checked"))
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/1/mostrar/" + idModulo;
            else
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/0/mostrar/" + idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    //console.log("Ahora el usuario tiene permisos de visualizar: "+data+" -> en el modulo"+idModulo)
                }
            });
        }

        function detalles(idModulo) {
            var url;
            if ($("#detallesModulo" + idModulo).prop("checked"))
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/1/detalle/" + idModulo;
            else
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/0/detalle/" + idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    //console.log("Ahora el usuario tiene permisos de ver detalles: "+data+" -> en el modulo"+idModulo);
                }
            });
        }

        function editar(idModulo) {
            var url;
            if ($("#edicionModulo" + idModulo).prop("checked"))
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/1/editar/" + idModulo;
            else
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/0/editar/" + idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    //console.log("Ahora el usuario tiene permisos de editar: "+data+" -> en el modulo"+idModulo);
                }
            });
        }

        function eliminar(idModulo) {
            var url;
            if ($("#eliminacionModulo" + idModulo).prop("checked"))
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/1/eliminar/" + idModulo;
            else
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/0/eliminar/" + idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    //console.log("Ahora el usuario tiene permisos de eliminar: "+data+" -> en el modulo"+idModulo)
                }
            });
        }

        function alta(idModulo) {
            var url;
            if ($("#altaModulo" + idModulo).prop("checked"))
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/1/alta/" + idModulo;
            else
                url = "<?=base_url('/index.php/CrudPermisos/asignarPermiso/' . $idTipo)?>/0/alta/" + idModulo;
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    //console.log("Ahora el usuario tiene permisos de alta: "+data+" -> en el modulo"+idModulo)
                }
            });
        }
        <?php
        }?>
    </script>

    <!--
    PERMISOS:
    0 - Tipos de usuario
    1 - Usuarios
    2 - Cajas
    3 - Membresias
    4 - Contratos
    5 - Permisos de un tipo de usuario
    6 - Clientes
    7 - Documentos de un cliente
    8 - Costos de membresias
    9 - Sucursales
    10 - Mundo de cajas
    11 - Moroso
    12 - Seguro
    13 - Mantenimiento
    14 - Contratos terminados
    15 - Facturación
    16 - Tarjetas de un contrato
    -->


