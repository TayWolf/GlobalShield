<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Registro de cliente</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form id="FormularioClienteExterno">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <select name="idTipoCliente" id="idTipoCliente" required onchange="agregarDomicilios();cambiarFormularioClienteExterno()">
                                <option value="" selected>Seleccione un tipo de cliente</option>
                                <option value="1">Cliente físico</option>
                                <option value="2">Cliente moral</option>
                            </select>
                            <label for="idTipoCliente">Tipo de cliente *</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="nombre" id="nombre" required>
                            <label for="nombre">Nombre del cliente *</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="rfc" id="rfc" required>
                            <label for="rfc">RFC *</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="razonSocial" id="razonSocial" required>
                            <label for="razonSocial" id="labelRazonSocial">Razón social *</label>
                        </div>

                        <div class="col s12 m4 input-field">
                            <input name="usuario" id="usuario" <?php
                            //Si es un cotitular, le genera un usuario y contraseña
                            if(!$esTitular)
                            {
                                echo  "type=\"hidden\" value=\"".uniqid('Cotitular-')."\" ";
                            }
                            else
                                echo "type=\"email\" ";
                            ?> required>
                            <?php
                            if($esTitular) {
                                ?>
                                <label for="usuario">Correo para ingresar al sistema *</label>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col s12 m4 input-field">

                            <input name="password" id="password" <?php
                            //Si es un cotitular, le genera un usuario y contraseña
                            $contrasena=uniqid();
                            if(!$esTitular)
                            {

                                echo  "type=\"hidden\" value=\"".$contrasena."\" ";
                            }
                            else
                                echo "type=\"password\"";
                            ?> required>
                            <?php
                            if($esTitular)
                            {
                                ?>
                                <label for="password">Contraseña *</label>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input name="password2" id="password2" <?php
                            //Si es un cotitular, le genera un usuario y contraseña
                            if(!$esTitular)
                            {
                                echo  "type=\"hidden\" value=\"".$contrasena."\" ";
                            }
                            else
                                echo "type=\"password\"";
                            ?> required>
                            <?php
                            if($esTitular)
                            {
                                ?>
                                <label for="password2">Confirmación de contraseña *</label>
                                <?php
                            }
                            ?>
                        </div>

                    </div>
                    <div class="row" id="datosDomicilio">

                    </div>
                    <div class="row" id="documentosClienteRequeridos">

                    </div>
                    <div class="row" id="documentosClienteExtras">

                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <a onclick="agregarOtrosDocumentos()" class="btn waves-effect waves-light">Agregar documento <i class="material-icons">add_box</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s10 ">
                            <button class="btn waves-effect waves-light right" type="submit" name="action">Guardar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <label class="input-field col s12">NOTA: Los campos marcados con asterisco son obligatorios</label>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    var estados=JSON.parse('<?=json_encode($estados)?>');
    $(document).ready(function ()
    {
        $("select").material_select();

    });

    function agregarDomicilios()
    {

        var tipoCliente=$("#idTipoCliente").val();
        $("#datosDomicilio").empty();
        //Es cliente físico
        if(tipoCliente==1)
        {
            $("#datosDomicilio").html(' ' +
                <?php
                    //si es titular, pide las referencias perosnales, si no entonces las omite
                if($esTitular)
                {
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="referencia1" id="referencia1" >' +
                '   <label for="referencia1">Referencia personal</label>' +
                '</div>' +
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="referencia2" id="referencia2" >' +
                '   <label for="referencia2">Referencia personal</label>' +
                '</div>' +
                <?php
                }
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="calle1" id="calle1" required>' +
                '   <label for="calle1">Calle (domicilio particular) *</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numero1" id="numero1" type="text" required>' +
                '   <label for="numero1">Número exterior (domicilio particular) *</label>' +
                '</div>'+
                '<div class="col s12 m3 input-field">' +
                '   <input name="numeroInterior1" id="numeroInterior1" type="text" >' +
                '   <label for="numeroInterior1">Número interior (domicilio particular)</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select class="estado" name="estado1" id="estado1" onchange="cargarMunicipios(1)" required><option value="">Seleccione un estado</option></select>' +
                '   <label for="estado1">Estado (domicilio particular) *</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select name="municipio1" id="municipio1" onchange="cargarColonias(1)" required><option value="">Seleccione un municipio</option></select>' +
                '   <label for="municipio1">Municipio (domicilio particular) *</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select name="colonia1" id="colonia1" required><option value="">Seleccione una colonia</option></select>' +
                '   <label for="colonia1">Colonia (domicilio particular) *</label>' +
                '</div>'+
                ' ' +
                    <?php
                if($esTitular)
                {
                ?>

                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="calle2" id="calle2" >' +
                '   <label for="calle2">Calle (domicilio fiscal)</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numero2" id="numero2" type="text" >' +
                '   <label for="numero2">Número exterior (domicilio fiscal)</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numeroInterior2" id="numeroInterior2" type="text" >' +
                '   <label for="numeroInterior2">Número interior (domicilio fiscal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select class="estado" name="estado2" id="estado2" onchange="cargarMunicipios(2)" ><option value="">Seleccione un estado</option></select>' +
                '   <label for="estado2">Estado (domicilio fiscal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select name="municipio2" id="municipio2" onchange="cargarColonias(2)" ><option value="">Seleccione un municipio</option></select>' +
                '   <label for="municipio2">Municipio (domicilio fiscal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select name="colonia2" id="colonia2" ><option value="">Seleccione una colonia</option></select>' +
                '   <label for="colonia2">Colonia (domicilio fiscal)</label>' +
                '</div>' +
                <?php
                }
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input name="telefonoLocal" id="telefonoLocal" type="tel">' +
                '   <label for="telefonoLocal">Teléfono local</label>' +
                '</div>'+
                '<div class="col s12 m6 input-field">' +
                '   <input name="telefonoCelular" id="telefonoCelular" type="tel">' +
                '   <label for="telefonoCelular">Celular</label>' +
                '</div>'
            );
        }
        else if(tipoCliente==2)
        {
            $("#datosDomicilio").html(' ' +
                <?php
                if($esTitular)
                {
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="referencia1" id="referencia1" >' +
                '   <label for="referencia1">Referencia comercial</label>' +
                '</div>' +
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="referencia2" id="referencia2" >' +
                '   <label for="referencia2">Referencia comercial</label>' +
                '</div>' +
                <?php
                }
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="calle2" id="calle2" required>' +
                '   <label for="calle2">Calle (domicilio fiscal) *</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numero2" id="numero2" type="text" required>' +
                '   <label for="numero2">Número exterior (domicilio fiscal) *</label>' +
                '</div>'+
                '<div class="col s12 m3 input-field">' +
                '   <input name="numeroInterior2" id="numeroInterior2" type="text">' +
                '   <label for="numeroInterior2">Número interior (domicilio fiscal)</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select class="estado" name="estado2" id="estado2" onchange="cargarMunicipios(2)" required><option value="">Seleccione un estado</option></select>' +
                '   <label for="estado2">Estado (domicilio fiscal) *</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select name="municipio2" id="municipio2" onchange="cargarColonias(2)" required><option value="">Seleccione un municipio</option></select>' +
                '   <label for="municipio2">Municipio (domicilio fiscal) *</label>' +
                '</div>'+
                '<div class="col s12 m4 input-field">' +
                '   <select name="colonia2" id="colonia2" required><option value="">Seleccione una colonia</option></select>' +
                '   <label for="colonia2">Colonia (domicilio fiscal) *</label>' +
                '</div>'+
                    <?php
                if($esTitular)
                {
                ?>
                '<div class="col s12 input-field">' +
                '   <input type="text" name="nombreRepresentante" id="nombreRepresentante" >' +
                '   <label for="nombreRepresentante">Nombre del representante legal</label>' +
                '</div>' +
                '<div class="col s12 m6 input-field">' +
                '   <input type="text" name="calle1" id="calle1" >' +
                '   <label for="calle1">Calle (representante legal)</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numero1" id="numero1" type="text" >' +
                '   <label for="numero1">Número exterior (representante legal)</label>' +
                '</div>' +
                '<div class="col s12 m3 input-field">' +
                '   <input name="numeroInterior1" id="numeroInterior1" type="text" >' +
                '   <label for="numeroInterior1">Número interior (representante legal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select class="estado" name="estado1" id="estado1" onchange="cargarMunicipios(1)" ><option value="">Seleccione un estado</option></select>' +
                '   <label for="estado1">Estado (representante legal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select name="municipio1" id="municipio1" onchange="cargarColonias(1)" ><option value="">Seleccione un municipio</option></select>' +
                '   <label for="municipio1">Municipio (representante legal)</label>' +
                '</div>' +
                '<div class="col s12 m4 input-field">' +
                '   <select name="colonia1" id="colonia1" ><option value="">Seleccione una colonia</option></select>' +
                '   <label for="colonia1">Colonia (representante legal)</label>' +
                '</div>' +
                ' ' +
                <?php
                }
                ?>
                '<div class="col s12 m6 input-field">' +
                '   <input name="telefonoLocal" id="telefonoLocal" type="tel">' +
                '   <label for="telefonoLocal">Teléfono local</label>' +
                '</div>'+
                '<div class="col s12 m6 input-field">' +
                '   <input name="telefonoCelular" id="telefonoCelular" type="tel">' +
                '   <label for="telefonoCelular">Celular</label>' +
                '</div>'
            );
        }
        for(var i=0; i<estados.length; i++)
        {
            $(".estado").append('<option value="'+estados[i]['idEstado']+'">'+estados[i]['nombreEstado']+'</option>');
        }
        $("select").material_select();

    }
    function cargarMunicipios(claseDomicilio)
    {
        var idEstado=$("#estado"+claseDomicilio).val();
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/getMunicipios/')?>'+idEstado,
            dataType: 'JSON',
            success: function (data)
            {
                $("#municipio"+claseDomicilio).empty();
                $("#municipio"+claseDomicilio).append('<option value="">Seleccione un municipio</option>')

                for(var i=0; i<data.length; i++)
                {
                    $("#municipio"+claseDomicilio).append('<option value="'+data[i]['idMunicipio']+'">'+data[i]['nombreMunicipio']+'</option>')
                }
                $('select').material_select();
            }, complete:function () {
                cargarColonias(claseDomicilio);
            }

        });

    }
    function cargarColonias(claseDomicilio)
    {
        var idMunicipio=$("#municipio"+claseDomicilio).val();
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/getColonias/')?>'+idMunicipio,
            dataType: 'JSON',
            success: function (data)
            {
                $("#colonia"+claseDomicilio).empty();
                $("#colonia"+claseDomicilio).append('<option value="">Seleccione una colonia</option>')

                for(var i=0; i<data.length; i++)
                {
                    $("#colonia"+claseDomicilio).append('<option value="'+data[i]['idRegion']+'">'+data[i]['nombreRegion']+'. C.P. '+data[i]['codigoPostal']+'</option>')
                }
                $('select').material_select();
            }

        });

    }
    function cambiarFormularioClienteExterno() {
        var tipoCliente=$("#idTipoCliente").val();
        $("#documentosClienteRequeridos").empty();
        //Es cliente físico
        if(tipoCliente==1)
        {
            $("#labelRazonSocial").html("Razón social");
            $("#razonSocial").prop("required", false);
            $("#documentosClienteRequeridos").html(' ' +
                '<div class="col s12 m6">' +
                '   <b>Identificación oficial (INE ó pasaporte)</b>' +
                '   <input class="dropify" type="file" name="identificacionOficial" id="identificacionOficial" >' +
                '</div>' +
                '<div class="col s12 m6">' +
                '   <b>Extranjero (Acredite legal estancia y pasaporte) (ID americana y FM2)</b>' +
                '   <input class="dropify" type="file" name="extranjero" id="extranjero" >' +
                '</div>'+
                '<div class="col s12 m6">' +
                '   <b>Comprobante de domicilio (no mayor a 2 meses)</b>' +
                '   <input class="dropify" type="file" name="comprobanteDomicilio" id="comprobanteDomicilio" >' +
                '</div>'
            );
        }
        else if(tipoCliente==2)
        {
            $("#labelRazonSocial").html("Razón social *");
            $("#razonSocial").prop("required", true);
            $("#documentosClienteRequeridos").html(' ' +
                '<div class="col s12 m6">' +
                '   <b>Acta constitutiva (Empresa)</b>' +
                '   <input class="dropify" type="file" name="actaConstutiva" id="actaConstutiva" >' +
                '</div>' +
                '<div class="col s12 m6">' +
                '   <b>Poder notarial (Representante legal)</b>' +
                '   <input class="dropify" type="file" name="poderNotarial" id="poderNotarial" >' +
                '</div>'+
                '<div class="col s12 m6">' +
                '   <b>Identificación oficial (INE ó pasaporte)</b>' +
                '   <input class="dropify" type="file" name="identificacionOficial" id="identificacionOficial" >' +
                '</div>'+
                '<div class="col s12 m6">' +
                '   <b>RFC</b>' +
                '   <input class="dropify" type="file" name="rfc" id="rfc" >' +
                '</div>'+
                '<div class="col s12 m6">' +
                '   <b>Comprobante de domicilio (no mayor a 2 meses)</b>' +
                '   <input class="dropify" type="file" name="comprobanteDomicilio" id="comprobanteDomicilio" >' +
                '</div>'
            );
        }

        $('.dropify').dropify({
            messages: {
                'default': 'Arrastra y suelta un archivo o haz clic',
                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                'remove':  'Remover',
                'error':   'Ooops, ocurrió un error.'
            }
        });

    }
    var numeroDocumentos=0;
    function agregarOtrosDocumentos()
    {

        $("#documentosClienteExtras").append("<div class=\"col s12 m6\">" +
            "        <input placeholder='Nombre del documento' name=\"nombreOtroDocumento"+numeroDocumentos+"\" id=\"nombreOtroDocumento"+numeroDocumentos+"\" class=\"input-field\" type=\"text\" ></input>" +
            "        <input type=\"file\" class=\"dropify\" id=\"otroDocumento"+numeroDocumentos+"\" name=\"otroDocumento"+numeroDocumentos+"\" data-allowed-file-extensions=\"pdf png jpg jpeg doc docx\" />" +
            "        <input placeholder='Observaciones' name=\"observacionOtroDocumento"+numeroDocumentos+"\" id=\"observacionOtroDocumento"+numeroDocumentos+"\" class=\"input-field\">" +
            "    </div>");
        $('#otroDocumento'+numeroDocumentos).dropify({
            messages: {
                'default': 'Arrastra y suelta un archivo o haz clic',
                'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                'remove':  'Remover',
                'error':   'Ooops, ocurrió un error.'}});
        numeroDocumentos++;
        console.log(numeroDocumentos+" documento agregado");
    }
    $("#FormularioClienteExterno").submit(function (e) {
        e.preventDefault();
        var passwordUs = document.getElementById("password").value;
        var passwordConf = document.getElementById("password2").value;
        var espacios = false;
        var cont = 0;

        while (!espacios && (cont < passwordUs.length) || !espacios && (cont < passwordConf.length)) {
            if (passwordUs.charAt(cont) == " " || passwordConf.charAt(cont) == " ")
                espacios = true;
            cont++;
        }

        if (espacios) {
            swal('Precaución!','La contraseña no puede contener espacios en blanco', 'warning')
            return false;
        }

        if (passwordUs.length == 0 || passwordConf.length == 0) {
            swal('Precaución!','Las contraseñas no pueden quedar vacias', 'warning')
            return false;
        }

        if (passwordUs.length < 8 || passwordConf.length < 8) {
            swal('Precaución!','Para una mayor seguridad las contraseñas deben tener al menos 8 caracteres', 'warning')
            return false;
        }
        if($("#password").val()==$("#password2").val())
        {
            $.ajax({
                url: '<?=base_url('index.php/CrudClienteExterno/comprobarExistenciaUsuario/')?>'+encodeURIComponent($("#usuario").val()),
                dataType:'html',
                success: function (data) {
                    //el usuario ya existe
                    if(parseInt(data)>0)
                        swal("Error", "El correo del usuario ya existe en el sistema.\n Intenta colocar otro correo", "warning");
                    else
                        ejecutarAlta()

                }
            });
        }
        else
        {
            swal("Precaución!", "Las contraseñas no coinciden", "warning");
        }

    });
    function ejecutarAlta() {
        Swal.fire({
            title: 'Procesando...',
            onBeforeOpen: () => {
                Swal.showLoading();
            }});
        formData=new FormData(document.getElementById("FormularioClienteExterno"));
        var idCliente;
        $.ajax({
                url: '<?=base_url('index.php/CrudClienteExterno/insertCliente/')?>'+numeroDocumentos,
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response)
                {
                    idCliente=response;
                    swal("Exito", "Se ha registrado al cliente", "success");
                    //Por alguna razón el swal esta mostrando un select. esta linea lo quita
                    $(".swal2-select").remove();
                    $(".modal").modal('close');
                },complete: function ()
                {
                    registrarClienteAutocomplete(idCliente, $("#nombre").val());
                }
            }
        );
    }
    $('.initialized').on('contentChanged', function() {
        $(this).material_select();
    });
</script>
