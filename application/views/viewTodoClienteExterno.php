<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">Clientes</h4></div>
        </div>
    </div>
    <?php
    if($permisos['alta'])
    {
        ?>
        <div class="row">
            <div class="col s12 center-align" align="center">
                <a class="btn waves-effect waves-light" onclick="loadUrl('CrudClienteExterno/formAltaCliente')">Nuevo cliente</a>
            </div>
        </div>
        <?php
    }
    if($permisos['mostrar'])
    {
        ?>
        <div class="row">
            <div class="col s12 m4 input-field">
                <select name="idTipoCliente" id="idTipoCliente" onchange="cargarListadoClientes();">
                    <option value="1" selected>Físico</option>
                    <option value="2">Moral</option>
                </select>
                <label for="idTipoCliente">Tipo de cliente</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12" id="contenedorTabla">
                <table class="highlight">
                    <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Nombre</th>
                        <th>Documentos</th>
                        <?php
                        if($permisos['detalle']) {
                            ?>
                            <th>Detalles</th>
                            <?php
                        }
                        if($permisos['editar']) {
                            ?>
                            <th>Editar</th>
                            <?php
                        }
                        if($permisos['eliminar']) {
                            ?>
                            <th>Eliminar</th>
                            <?php
                        }?>
                    </tr>
                    </thead>
                    <tbody id="tablaBody">

                    </tbody>
                </table>
            </div>
        </div>
        <form id="documentos"></form>
        <!-- Modal Structure -->
        <div id="modalDocumentoCliente" class="modal">
            <div class="modal-content">
                <h4>Documentos del cliente</h4>
                <div class="row">
                    <div class="col s12" id="contenidoModal">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="guardarNuevosDocumentos()" class="modal-action modal-close waves-effect waves-green btn-flat">Guardar</a>
            </div>
        </div>

        <?php
    }?>
</div>
<script>
    $(document).ready(function(){
        $(".modal").modal();
        $('select').material_select();
        cargarListadoClientes();
    });
    var ajaxRequest;
    var tabla;
    function cargarListadoClientes() {
        if(ajaxRequest)
            ajaxRequest.abort();
        var tipoCliente=$("#idTipoCliente").val();
        $("#contenedorTabla").empty();
        ajaxRequest=$.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/getClientes/')?>'+tipoCliente,
            dataType: 'JSON',
            success: function (data) {
                var contenidoTabla="";
                var permisoEditar=<?=$permisos['editar']?>;
                var permisoEliminar=<?=$permisos['eliminar']?>;
                var permisoDetalle=<?=$permisos['detalle']?>;
                for(var i=0; i<data.length; i++)
                {
                    contenidoTabla+=" " +
                        "<tr>" +
                        "   <td style='display: none;'>"+data[i]['idUsuario']+"</td>"+
                        "   <td>"+data[i]['usuario']+"</td>";
                    <?php
                    if($permisosDocumentos['mostrar'])
                    {
                    ?>
                    contenidoTabla+= "<td><a onclick='verDocumentos("+data[i]['idUsuario']+")'>Ver documentos</a></td>";
                    <?php
                    }?>
                    if(permisoDetalle==1)
                        contenidoTabla+=" " +
                            "<td><a onclick='loadUrl(\"CrudClienteExterno/detallesClienteExterno/"+data[i]['idUsuario']+"/"+tipoCliente+"\")'>Detalles</a></td>";
                    if(permisoEditar==1)
                        contenidoTabla+=" " +
                        "   <td><a onclick='loadUrl(\"CrudClienteExterno/editarClienteExterno/"+data[i]['idUsuario']+"/"+tipoCliente+"\")'>Editar</a></td>";
                    if(permisoEliminar==1)
                        contenidoTabla+="" +
                        "   <td><a onclick='eliminar("+data[i]['idUsuario']+", this)'>Eliminar</a></td>";
                    contenidoTabla+="" +
                        "</tr>";
                }
                var encabezados="<th style=\"display: none\">ID</th><th>Nombre</th>";
                <?php if($permisosDocumentos['mostrar'])
                {?>
                encabezados+='<th>Documentos</th>';
                <?php
                }
                if($permisos['detalle'])
                {
                ?>
                encabezados += '<th>Detalles</th>';
                <?php
                }
                if($permisos['editar'])
                {
                ?>
                encabezados+='<th>Editar</th>';
                <?php
                }
                if($permisos['eliminar'])
                {?>
                encabezados+='<th>Eliminar</th>';
                <?php
                }?>
                $("#contenedorTabla").html('' +
                    '<table class="highlight">' +
                    '   <thead>' +
                    '       <tr>' +encabezados+
                    '       </tr>' +
                    '   </thead>' +
                    '   <tbody id="tablaBody">' + contenidoTabla+
                    '   </tbody>' +
                    '</table>');
            },
            complete: function () {
                tabla=$('table').DataTable({
                    language: {
                        url: '<?=base_url('assets/i18n/Spanish.json')?>'
                    }
                });
            }
            });
    }
    function eliminar(id, elemento) {
        Swal({
            title: '¿Eliminar este cliente?',
            text: "Se eliminaran sus documentos y no se podran revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, borralo!'
        }).then((result) => {
            if (result.value) {
                $.post('<?=base_url('index.php/CrudClienteExterno/eliminarCliente')?>',

                    {idClienteExterno: id},

                    function (response) {
                        tabla.row($(elemento).closest('tr')).remove().draw();
                        Swal(
                            'Borrado!',
                            'El cliente fue eliminado',
                            'success'
                        );
                    }
                );


            }

        })

    }
    var numeroDocumentos;
    function verDocumentos(idUsuario)
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/obtenerListaDocumentos/')?>'+idUsuario,
            dataType:'JSON',
            success: function (response)
            {
                numeroDocumentos=0;
                $("#contenidoModal").html("<form class=\"col s12\" id=\"formulario\">" +
                    "<input type=\"hidden\" id=\"idClienteSeleccionado\" name=\"idClienteSeleccionado\" value=\""+idUsuario+"\">" +
                    "</form>");
                var link='<?=base_url('assets/fileUpload/documentosClientes/')?>';
                var observaciones;
                var idDiv;
                for(i=0; i<response.length; i++)
                {
                    if(response[i]['archivo'])
                    {
                        observaciones = (response[i]['observaciones']) ? "<p>Observaciones: " + response[i]['observaciones'] + "</p>" : "";
                        //documentos actuales
                        idDiv = response[i]['archivo'].split(".");
                        idDiv = idDiv[0].substring(1, idDiv[0].length);


                        $("#formulario").append("<div class='col s12 m6' align='center' id='" + idDiv + "'>" +
                            "<b>" + response[i]['nombreDocumentoCliente'] + "</b>" +
                            "<div class='col s12' align='center'>" +
                            "<input class='dropify' name='documentoEmpresa" + i + "' name='documentoEmpresa" + i + "' data-default-file='" + link + response[i]['archivo'] + "'>" +
                            observaciones +
                            "<a download href='" + link + response[i]['archivo'] + "'>Descargar</a>" +
                            "</div>" +
                            "</div>");
                    }
                }
                //nuevos documentos
                <?php
                if($permisosDocumentos['alta'])
                {
                ?>
                $("#contenidoModal").append("<div class='row' id=\"otrosDocumentos\"></div>" +
                    "<div class='col s12 m6' align='center'>" +
                    "<a href=\"#\" onclick=\"agregarOtrosDocumentos()\" class=\"btn waves-light waves-effect\">" +
                    "<i class=\"material-icons\">add_box</i> Agregar otros documentos</a>" +
                    "</div>");
                <?php

                }?>




                $('.dropify').dropify({
                    messages: {
                        'default': 'Arrastra y suelta un archivo o haz clic',
                        'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                        'remove':  'Remover',
                        'error':   'Ooops, ocurrió un error.'
                    }
                }).on('dropify.beforeClear', function(event, element)
                {
                    <?php
                    if($permisosDocumentos['eliminar'])
                    {
                    ?>

                    if (confirm("Realmente quiere borrar el archivo? \"" + element.filename + "\" ?"))
                        $.ajax({
                            url: '<?=base_url('index.php/CrudClienteExterno/borrarArchivo/')?>' + element.filename,
                            contentType: false,
                            processData: false,
                            cache: false,
                            dataType: 'HTML',
                            success: function () {
                                idDiv = element.filename.split(".");
                                idDiv = idDiv[0].replace("/", "");
                                $("#"+idDiv).remove()
                            }
                        });
                    <?php
                    }
                    ?>

                });
                $("#modalDocumentoCliente").modal('open');

            }
        });
    }
    function agregarOtrosDocumentos()
    {
        $("#otrosDocumentos").append("<div class=\"col s12 m6\">" +
            "        <input form='documentos' placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"input-field\" type=\"text\">" +
            "        <input form='documentos' type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\" data-allowed-file-extensions=\"pdf png jpg jpeg doc docx\" />" +
            "        <input form='documentos' placeholder='Observaciones' name=\"observacionOtroDocumento"+numeroDocumentos+"\" id=\"observacionOtroDocumento"+numeroDocumentos+"\" class=\"input-field\">" +
            "    </div>");
        $('#otroDocumento'+numeroDocumentos).dropify({
            messages: {
                'default': 'Arrastra y suelta un archivo o haz clic',
                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                'remove':  'Remover',
                'error':   'Ooops, ocurrió un error.'}});
        numeroDocumentos++;

    }
    function guardarNuevosDocumentos()
    {
        formdata=new FormData(document.getElementById("documentos"));
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/subirDocumentoOpcional/')?>'+$("#idClienteSeleccionado").val()+"/"+numeroDocumentos,
            data: formdata,
            type: 'POST',
            processData: false,
            contentType: false
        });

    }
</script>