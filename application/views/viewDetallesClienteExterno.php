<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Detalles del cliente</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12" align="center">
            <a class="btn waves-light waves-effect" onclick="loadUrl('CrudClienteExterno')">Regresar</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form id="formulario">
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
                            <input type="text" name="nombre" id="nombre" value="<?=$detalles['nombre']?>" required readonly>
                            <label for="nombre">Nombre del cliente</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="rfc" id="rfc" value="<?=$detalles['rfc']?>" required readonly>
                            <label for="rfc">RFC *</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" name="razonSocial" id="razonSocial" value="<?=$detalles['razonSocial']?>" readonly>
                            <label for="razonSocial" id="labelRazonSocial">Razón social</label>
                        </div>
                        <div class="col s12 input-field">
                            <input type="text" name="usuario" id="usuario" value="<?=$detalles['usuario']?>" required readonly>
                            <label for="usuario">Correo para ingresar al sistema</label>
                        </div>
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
                   <input type=\"text\" name=\"calle1\" id=\"calle1\" value='".$detalles['calleParticular']."' required>
                   <label for=\"calle1\">Calle (domicilio particular)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numero1\" id=\"numero1\" value='".$detalles['numeroParticular']."' required>
                   <label for=\"numero1\">Número exterior (domicilio particular)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numeroInterior1\" id=\"numeroInterior1\" value='".$detalles['numeroInteriorParticular']."' required>
                   <label for=\"numeroInterior1\">Número interior (domicilio particular)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select class=\"estado\" name=\"estado1\" id=\"estado1\" onchange=\"cargarMunicipios(1)\" required><option value='".$estado1['idEstado']."'>".$estado1['nombreEstado']."</option></select>
                   <label class='select-label' for=\"estado1\">Estado (domicilio particular)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"municipio1\" id=\"municipio1\" onchange=\"cargarColonias(1)\" required><option value=\"\">".$municipio1['nombreMunicipio']."</option></select>
                   <label class='select-label' for=\"municipio1\">Municipio (domicilio particular)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"colonia1\" id=\"colonia1\" required><option value=\"\">".$colonia1['nombreRegion']." C.P. ".$colonia1['codigoPostal']."</option></select>
                   <label class='select-label' for=\"colonia1\">Colonia (domicilio particular)</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input type=\"text\" name=\"calle2\" id=\"calle2\" value='".$detalles['calleFiscal']."' required>
                   <label for=\"calle2\">Calle (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numero2\" id=\"numero2\" value='".$detalles['numeroFiscal']."' required>
                   <label for=\"numero2\">Número exterior (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numeroInterior2\" id=\"numeroInterior2\" value='".$detalles['numeroInteriorFiscal']."' required>
                   <label for=\"numeroInterior2\">Número interior (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select class=\"estado\" name=\"estado2\" id=\"estado2\" onchange=\"cargarMunicipios(2)\" required><option value=\"\">".$estado2['nombreEstado']."</option></select>
                   <label class='select-label' for=\"estado2\">Estado (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"municipio2\" id=\"municipio2\" onchange=\"cargarColonias(2)\" required><option value=\"\">".$municipio2['nombreMunicipio']."</option></select>
                   <label class='select-label' for=\"municipio2\">Municipio (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"colonia2\" id=\"colonia2\" required><option value=\"\">".$colonia2['nombreRegion']." C.P. ".$colonia2['codigoPostal']."</option></select>
                   <label class='select-label' for=\"colonia2\">Colonia (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input name=\"telefonoLocal\" id=\"telefonoLocal\" type=\"tel\" value='".$detalles['telefonoLocal']."' required>
                   <label for=\"telefonoLocal\">Teléfono local</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input name=\"telefonoCelular\" id=\"telefonoCelular\" type=\"tel\" value='".$detalles['telefonoCelular']."' required>
                   <label for=\"telefonoCelular\">Celular</label>
                </div>";
                           
                        }
                        else
                        {
                            print "
                <div class=\"col s12 m6 input-field\">
                   <input type=\"text\" name=\"referencia1\" id=\"referencia1\" value='".$detalles['referencia1']."' required>
                   <label for=\"referencia1\">Referencia comercial</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input type=\"text\" name=\"referencia2\" id=\"referencia2\" value='".$detalles['referencia2']."' required>
                   <label for=\"referencia2\">Referencia comercial</label>
                </div>
                <div class=\"col s12 input-field\">
                   <input type=\"text\" name=\"nombreRepresentante\" id=\"nombreRepresentante\" value='".$detalles['nombreRepresentanteLegal']."' required>
                   <label for=\"nombreRepresentante\">Nombre del representante legal</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input type=\"text\" name=\"calle1\" id=\"calle1\" value='".$detalles['calleRepresentanteLegal']."' required>
                   <label for=\"calle1\">Calle (representante legal)</label>
                </div>
                <div class=\"col s3 input-field\">
                   <input name=\"numero1\" id=\"numero1\" value='".$detalles['numeroRepresentanteLegal']."' required>
                   <label for=\"numero1\">Número exterior (representante legal)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numeroInterior1\" id=\"numeroInterior1\" value='".$detalles['numeroInteriorRepresentanteLegal']."' required>
                   <label for=\"numeroInterior1\">Número interior (representante legal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select class=\"estado\" name=\"estado1\" id=\"estado1\" onchange=\"cargarMunicipios(1)\" required><option value='".$estado1['idEstado']."'>".$estado1['nombreEstado']."</option></select>
                   <label class='select-label' for=\"estado1\">Estado (representante legal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"municipio1\" id=\"municipio1\" onchange=\"cargarColonias(1)\" required><option value=\"\">".$municipio1['nombreMunicipio']."</option></select>
                   <label class='select-label' for=\"municipio1\">Municipio (representante legal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"colonia1\" id=\"colonia1\" required><option value=\"\">".$colonia1['nombreRegion']." C.P. ".$colonia1['codigoPostal']."</option></select>
                   <label class='select-label' for=\"colonia1\">Colonia (representante legal)</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input type=\"text\" name=\"calle2\" id=\"calle2\" value='".$detalles['calleFiscal']."' required>
                   <label for=\"calle2\">Calle (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numero2\" id=\"numero2\" value='".$detalles['numeroFiscal']."' required>
                   <label for=\"numero2\">Número exterior (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m3 input-field\">
                   <input name=\"numeroInterior2\" id=\"numeroInterior2\" value='".$detalles['numeroInteriorFiscal']."' required>
                   <label for=\"numeroInterior2\">Número interior (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select class=\"estado\" name=\"estado2\" id=\"estado2\" onchange=\"cargarMunicipios(2)\" required><option value=\"\">".$estado2['nombreEstado']."</option></select>
                   <label class='select-label' for=\"estado2\">Estado (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"municipio2\" id=\"municipio2\" onchange=\"cargarColonias(2)\" required><option value=\"\">".$municipio2['nombreMunicipio']."</option></select>
                   <label class='select-label' for=\"municipio2\">Municipio (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m4 input-field\">
                   <select name=\"colonia2\" id=\"colonia2\" required><option value=\"\">".$colonia2['nombreRegion']." C.P. ".$colonia2['codigoPostal']."</option></select>
                   <label class='select-label' for=\"colonia2\">Colonia (domicilio fiscal)</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input name=\"telefonoLocal\" id=\"telefonoLocal\" type=\"tel\" value='".$detalles['telefonoLocal']."' required>
                   <label for=\"telefonoLocal\">Teléfono local</label>
                </div>
                <div class=\"col s12 m6 input-field\">
                   <input name=\"telefonoCelular\" id=\"telefonoCelular\" type=\"tel\" value='".$detalles['telefonoCelular']."' required>
                   <label for=\"telefonoCelular\">Celular</label>
                </div>";
                        }
                        ?>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function ()
    {
        $("#idTipoCliente").val(parseInt(<?=$idTipo?>));

        $("select").attr("disabled", "disabled");
        $("input").attr("readonly", "readonly");

        $("label").addClass("active");
        $(".select-label").removeClass("active");
        $("select").material_select();
    });
</script>