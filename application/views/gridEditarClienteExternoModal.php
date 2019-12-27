<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Edición de cliente</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form id="formularioClienteExterno">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <select name="idTipoCliente" id="idTipoCliente" required disabled>
                                <option value="">Seleccione un tipo de cliente </option>
                                <option value="1">Cliente físico</option>
                                <option value="2">Cliente moral</option>
                            </select>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input form="formularioClienteExterno" type="text" name="nombre" id="nombre" value="<?=$detalles['nombre']?>" required>
                            <label for="nombre">Nombre del cliente *</label>
                        </div>
                        <div class="col s12 input-field">
                            <input form="formularioClienteExterno" type="email" name="usuario" id="usuario" value="<?=$detalles['usuario']?>" required>
                            <label for="usuario">Correo para ingresar al sistema *</label>
                        </div>
                    </div>
                    <div class="row">
                    <?php
                    //cliente fisico
                    if($idTipo==1)
                    {

                        print "
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"referencia1\" id=\"referencia1\" value='".$detalles['referencia1']."' >
                       <label for=\"referencia1\">Referencia personal</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"referencia2\" id=\"referencia2\" value='".$detalles['referencia2']."' >
                       <label for=\"referencia2\">Referencia personal</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"calle1\" id=\"calle1\" form='formularioClienteExterno' value='".$detalles['calleParticular']."' required>
                       <label for=\"calle1\">Calle (domicilio particular) *</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numero1\" id=\"numero1\" value='".$detalles['numeroParticular']."' type=\"text\" form='formularioClienteExterno' required>
                       <label for=\"numero1\">Número exterior (domicilio particular) *</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numeroInterior1\" id=\"numeroInterior1\" value='".$detalles['numeroInteriorParticular']."' type=\"text\" form='formularioClienteExterno' >
                       <label for=\"numeroInterior1\">Número interior (domicilio particular) </label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select class=\"estado\" name=\"estado1\" id=\"estado1\" onchange=\"cargarMunicipios(1)\" required form='formularioClienteExterno'>
                       ";
                        foreach ($estados as $estado)
                        {
                            print "<option value='".$estado['idEstado']."'>".$estado['nombreEstado']."</option>";
                        }
                        print"
                       </select>
                       <label class='select-label' for=\"estado1\">Estado (domicilio particular) *</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"municipio1\" id=\"municipio1\" onchange=\"cargarColonias(1)\" required form='formularioClienteExterno'>
                       ";
                        foreach ($municipiosEstado1 as $municipio)
                        {
                            print "<option value='".$municipio['idMunicipio']."'>".$municipio['nombreMunicipio']."</option>";
                        }
                        print "
                       </select>
                       <label class='select-label' for=\"municipio1\">Municipio (domicilio particular) *</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"colonia1\" id=\"colonia1\" required form='formularioClienteExterno'>";
                       foreach ($coloniasMunicipio1 as $colonia)
                       {
                           print "<option value=\"".$colonia['idRegion']."\">".$colonia['nombreRegion']." C.P. ".$colonia['codigoPostal']."</option>";
                       }
                        print "
                       </select>
                       <label class='select-label' for=\"colonia1\">Colonia (domicilio particular) *</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"calle2\" id=\"calle2\" value='".$detalles['calleFiscal']."'  form='formularioClienteExterno'>
                       <label for=\"calle2\">Calle (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numero2\" id=\"numero2\" value='".$detalles['numeroFiscal']."' type=\"text\"  form='formularioClienteExterno'>
                       <label for=\"numero2\">Número exterior (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numeroInterior2\" id=\"numeroInterior2\" value='".$detalles['numeroInteriorFiscal']."' type=\"text\"  form='formularioClienteExterno'>
                       <label for=\"numeroInterior2\">Número interior (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select class=\"estado\" name=\"estado2\" id=\"estado2\" onchange=\"cargarMunicipios(2)\"  form='formularioClienteExterno'>";
                        foreach ($estados as $estado)
                        {
                            print "<option value='".$estado['idEstado']."'>".$estado['nombreEstado']."</option>";
                        }
                       print " 
                       </select>
                       <label class='select-label' for=\"estado2\">Estado (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"municipio2\" id=\"municipio2\" onchange=\"cargarColonias(2)\"  form='formularioClienteExterno'>";
                        foreach ($municipiosEstado2 as $municipio)
                        {
                            print "<option value='".$municipio['idMunicipio']."'>".$municipio['nombreMunicipio']."</option>";
                        }
                      print "
                       </select>
                       <label class='select-label' for=\"municipio2\">Municipio (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"colonia2\" id=\"colonia2\"  form='formularioClienteExterno'>";
                        foreach ($coloniasMunicipio2 as $colonia)
                        {
                            print "<option value=\"".$colonia['idRegion']."\">".$colonia['nombreRegion']." C.P. ".$colonia['codigoPostal']."</option>";
                        }
                       print "
                        </select>
                       <label class='select-label' for=\"colonia2\">Colonia (domicilio fiscal)</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input name=\"telefonoLocal\" id=\"telefonoLocal\" type=\"tel\" value='".$detalles['telefonoLocal']."'  form='formularioClienteExterno'>
                       <label for=\"telefonoLocal\">Teléfono local</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input name=\"telefonoCelular\" id=\"telefonoCelular\" type=\"tel\" value='".$detalles['telefonoCelular']."'  form='formularioClienteExterno'>
                       <label for=\"telefonoCelular\">Celular</label>
                    </div>";

                    }
                    else
                    {
                    print "
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"referencia1\" id=\"referencia1\" value='".$detalles['referencia1']."'>
                       <label for=\"referencia1\">Referencia comercial</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"referencia2\" id=\"referencia2\" value='".$detalles['referencia2']."'>
                       <label for=\"referencia2\">Referencia comercial</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"calle2\" id=\"calle2\" value='".$detalles['calleFiscal']."' required form='formularioClienteExterno'>
                       <label for=\"calle2\">Calle (domicilio fiscal) *</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numero2\" id=\"numero2\" value='".$detalles['numeroFiscal']."' required form='formularioClienteExterno'>
                       <label for=\"numero2\">Número exterior (domicilio fiscal) *</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numeroInterior2\" id=\"numeroInterior2\" value='".$detalles['numeroInteriorFiscal']."'  form='formularioClienteExterno'>
                       <label for=\"numeroInterior2\">Número interior (domicilio fiscal) </label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select class=\"estado\" name=\"estado2\" id=\"estado2\" onchange=\"cargarMunicipios(2)\" required form='formularioClienteExterno'>";
                        foreach ($estados as $estado)
                        {
                            print "<option value='".$estado['idEstado']."'>".$estado['nombreEstado']."</option>";
                        }
                        print "
                        </select>
                       <label class='select-label' for=\"estado2\">Estado (domicilio fiscal) *</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"municipio2\" id=\"municipio2\" onchange=\"cargarColonias(2)\" required form='formularioClienteExterno'>";
                        foreach ($municipiosEstado2 as $municipio)
                        {
                            print "<option value='".$municipio['idMunicipio']."'>".$municipio['nombreMunicipio']."</option>";
                        }
                        print "
                        </select>
                       <label class='select-label' for=\"municipio2\">Municipio (domicilio fiscal) *</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"colonia2\" id=\"colonia2\" required form='formularioClienteExterno'>";
                        foreach ($coloniasMunicipio2 as $colonia)
                        {
                            print "<option value=\"".$colonia['idRegion']."\">".$colonia['nombreRegion']." C.P. ".$colonia['codigoPostal']."</option>";
                        }
                        print "
                        </select>
                       <label class='select-label' for=\"colonia2\">Colonia (domicilio fiscal) *</label>
                    </div>";
                        print "

                    <div class=\"col s12 input-field\">
                       <input type=\"text\" name=\"nombreRepresentante\" id=\"nombreRepresentante\" value='".$detalles['nombreRepresentanteLegal']."'  form='formularioClienteExterno'>
                       <label for=\"nombreRepresentante\">Nombre del representante legal</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input type=\"text\" name=\"calle1\" id=\"calle1\" value='".$detalles['calleRepresentanteLegal']."'  form='formularioClienteExterno'>
                       <label for=\"calle1\">Calle (representante legal)</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numero1\" id=\"numero1\" value='".$detalles['numeroRepresentanteLegal']."'  form='formularioClienteExterno'>
                       <label for=\"numero1\">Número exterior (representante legal)</label>
                    </div>
                    <div class=\"col s12 m3 input-field\">
                       <input name=\"numeroInterior1\" id=\"numeroInterior1\" value='".$detalles['numeroInteriorRepresentanteLegal']."'  form='formularioClienteExterno'>
                       <label for=\"numeroInterior1\">Número interior (representante legal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select class=\"estado\" name=\"estado1\" id=\"estado1\" onchange=\"cargarMunicipios(1)\"  form='formularioClienteExterno'>
                       ";
                        foreach ($estados as $estado)
                        {
                            print "<option value='".$estado['idEstado']."'>".$estado['nombreEstado']."</option>";
                        }
                        print "
                       </select>
                       <label class='select-label' for=\"estado1\">Estado (representante legal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"municipio1\" id=\"municipio1\" onchange=\"cargarColonias(1)\"  form='formularioClienteExterno'>";
                        foreach ($municipiosEstado1 as $municipio)
                        {
                            print "<option value='".$municipio['idMunicipio']."'>".$municipio['nombreMunicipio']."</option>";
                        }
                        print"
                       </select>
                       <label class='select-label' for=\"municipio1\">Municipio (representante legal)</label>
                    </div>
                    <div class=\"col s12 m4 input-field\">
                       <select name=\"colonia1\" id=\"colonia1\"  form='formularioClienteExterno'>";
                        foreach ($coloniasMunicipio1 as $colonia)
                        {
                            print "<option value=\"".$colonia['idRegion']."\">".$colonia['nombreRegion']." C.P. ".$colonia['codigoPostal']."</option>";
                        }
                        print "</select>
                       <label class='select-label' for=\"colonia1\">Colonia (representante legal)</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input name=\"telefonoLocal\" id=\"telefonoLocal\" type=\"tel\" value='".$detalles['telefonoLocal']."'  form='formularioClienteExterno'>
                       <label for=\"telefonoLocal\">Teléfono local</label>
                    </div>
                    <div class=\"col s12 m6 input-field\">
                       <input name=\"telefonoCelular\" id=\"telefonoCelular\" type=\"tel\" value='".$detalles['telefonoCelular']."'  form='formularioClienteExterno'>
                       <label for=\"telefonoCelular\">Celular</label>
                    </div>";
                    }
                    ?>
                    </div>
                    <div class="row">
                        <div class="col s10 offset-s1 m6 input-field">
                            <a onclick="verificar()" class="btn waves-effect waves-light right" name="action">Cambiar password
                                <i class="material-icons right">lock_open</i>
                            </a>
                        </div>
                        <div class="input-field col s10 m6">
                            <button form="formularioClienteExterno" class="btn   waves-effect waves-light right" type="submit" name="action">Guardar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <label class="col s12">NOTA: Los campos marcados con asterisco son obligatorios</label>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="contenedorPassModal">

</div>
<script>
    $(document).ready(function ()
    {
        $("#idTipoCliente").val(parseInt(<?=$idTipo?>));
        $("#rfc").val('<?=$detalles['rfc']?>');
        $("#razonSocial").val('<?=$detalles['razonSocial']?>');
        $("#estado1").val('<?=$estado1['idEstado']?>');
        $("#estado2").val('<?=$estado2['idEstado']?>');
        $("#municipio1").val('<?=$municipio1['idMunicipio']?>');
        $("#municipio2").val('<?=$municipio2['idMunicipio']?>');
        $("#colonia1").val('<?=$colonia1['idRegion']?>');
        $("#colonia2").val('<?=$colonia2['idRegion']?>');
        <?php
        if($idTipo==1)
        {
            ?>

        $("#calle1").val('<?=$detalles['calleParticular']?>');
        $("#numero1").val('<?=$detalles['numeroParticular']?>');
        $("#numeroInterior1").val('<?=$detalles['numeroInteriorParticular']?>');

        $("#calle2").val('<?=$detalles['calleFiscal']?>');
        $("#numero2").val('<?=$detalles['numeroFiscal']?>');
        $("#numeroInterior2").val('<?=$detalles['numeroInteriorFiscal']?>');

        <?php
        }
        else
        {
            ?>


        $("#calle1").val('<?=$detalles['calleRepresentanteLegal']?>');
        $("#numero1").val('<?=$detalles['numeroRepresentanteLegal']?>');
        $("#numeroInterior1").val('<?=$detalles['numeroInteriorRepresentanteLegal']?>');

        $("#calle2").val('<?=$detalles['calleFiscal']?>');
        $("#numero2").val('<?=$detalles['numeroFiscal']?>');
        $("#numeroInterior2").val('<?=$detalles['numeroInteriorFiscal']?>');
        <?php
        }
        ?>

        $("select").material_select();
        $("label").addClass("active");
        $(".select-label").removeClass("active");
    });
    $("#formularioClienteExterno").submit(function (e) {
        e.preventDefault();
        console.log("ok")
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/comprobarExistenciaUsuarioEditar/'.rawurlencode($detalles['usuario']))?>/'+encodeURIComponent($("#usuario").val()),
            dataType:'html',
            success: function (data) {
                //el usuario ya existe
                if(parseInt(data)>0)
                    swal("Error", "El correo del usuario ya existe en el sistema.\n Intenta colocar otro correo", "warning");
                else
                {
                  var form=$("#formularioClienteExterno");
                  $.ajax({
                      url: '<?=base_url('index.php/CrudClienteExterno/updateCliente/' . $idUsuario . "/" . $idTipo)?>',
                      type: 'POST',
                      data: form.serialize(),
                      success: function (response) {
                          swal("Exito", "Se ha actualizado el cliente", "success");
                          //Por alguna razón el swal esta mostrando un select. esta linea lo quita
                          $(".swal2-select").remove();
                          editarClienteAutocomplete('<?=$idUsuario?>',$("#nombre").val());

                          $(".modal").modal('close');

                      }
                  });
                }
            }
        });
    });
    var ingresoPass=0;
    function verificar()
    {
      if (!ingresoPass) {
        Swal.fire({
            title: 'Ingrese la contraseña de un administrador para cambiar la contraseña del usuario',
            input: 'text',
            inputAttributes:
                {
                    autocapitalize: 'off'
                },
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                return fetch(`//api.github.com/users/${login}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Ingrese Contraseña`
                        )
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                var parametros={
                    "password" : result.value.login }
                $.ajax({

                    url : "<?=base_url('index.php/CrudClienteExterno/verificarContrasena/')?>",
                    type: "POST",
                    data:parametros,
                    dataType: "JSON",
                    success: function(data)
                    {
                      if (data>0)
                      {
                        ingresoPass=1;
                        Swal.fire('Autorizado', 'Permiso autorizado', 'success');
                         
                        abrirSwalCambioPass();
                      }else
                        Swal.fire('ERROR', 'Contraseña incorrecta', 'error');
                    }
                });
            }
        });
      }else{
        abrirSwalCambioPass();
      }
        $(".swal2-input").attr("type", "password");
      
    }
    function abrirSwalCambioPass(){
       Swal.mixin({
        input: 'password',
        confirmButtonText: 'Continuar &rarr;',
        showCancelButton: true,
        progressSteps: ['1', '2']
      }).queue([
        {
          title: 'Ingresa la nueva contraseña'
        },
        'Confirma la contraseña anterior'
      ]).then((result) => {
        if (result.value) 
        {
          var passwordUs = result.value[0];
          var passwordConf = result.value[1];
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

          if(passwordUs==passwordConf)
          {
              $.ajax({
                  url : "<?=base_url('index.php/CrudClienteExterno/cambiarContrasena/'.$idUsuario)?>",
                  type: "POST",
                  data:{password: passwordUs},
                  dataType: "html",
                  success: function(data)
                  {
                      swal("¡Exito!", "Se ha actualizado la contraseña del usuario", "success");
                      //$(".modal").modal('close');

                  }
              });
          }
            else
              swal("Precaución!", "Las contraseñas no coinciden", "warning");
         }
      })
    }
    function cambiarPassword() {
        
        if($("#password1").val()==$("#password2").val())
        {
            $.ajax({
                url : "<?=base_url('index.php/CrudClienteExterno/cambiarContrasena/'.$idUsuario)?>",
                type: "POST",
                data:{password: $("#password1").val()},
                dataType: "html",
                success: function(data)
                {
                    swal("¡Exito!", "Se ha actualizado la contraseña del usuario", "success");
                    $(".modal").modal('close');

                }
            });
        }
        else
            swal("Precaución!", "Las contraseñas no coinciden", "warning");
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
</script>