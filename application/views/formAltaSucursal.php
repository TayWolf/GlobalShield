<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Alta de sucursal</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12" align="center">
            <a class="btn waves-light waves-effect" onclick="loadUrl('CrudSucursal')">Regresar</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form id="formulario">
                <div class="card-panel">
                    <div class="row">
                        <div class="col s12 m4 input-field">
                            <input type="text" name="nombreSucursal" id="nombreSucursal" required>
                            <label for="nombreSucursal">Nombre de la sucursal</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" name="calleSucursal" id="calleSucursal" required>
                            <label for="calleSucursal">Calle</label>
                        </div>
                        <div class="col s12 m2 input-field">
                            <input type="text" name="numeroSucursal" id="numeroSucursal" required>
                            <label for="numeroSucursal">Número exterior</label>
                        </div>
                        <div class="col s12 m2 input-field">
                            <input type="text" name="numeroInterior" id="numeroInterior">
                            <label for="numeroInterior">Número interior</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 input-field">
                            <select name="estado" id="estado" onchange="cargarMunicipios()" required>
                                <option value="">Seleccione una estado</option>
                                <?php
                                foreach ($estados as $estado)
                                {
                                    print "<option value='".$estado['idEstado']."'>".$estado['nombreEstado']."</option>";
                                }
                                ?>
                            </select>
                            <label for="estado">Estado</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select name="municipio" id="municipio" onchange="cargarColonias()" required>
                                <option value="">Seleccione un municipio</option>
                            </select>
                            <label for="municipio">Municipio</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select name="colonia" id="colonia" required>
                                <option value="">Seleccione una colonia</option>
                            </select>
                            <label for="colonia">Colonia</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m3 input-field">
                            <input type="text" name="RazonSocial" id="RazonSocial" required>
                            <label for="RazonSocial">Razón Social</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="text" name="RFC" id="RFC" maxlength="13" required>
                            <label for="RFC">RFC</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="tel" name="telefono1" id="telefono1">
                            <label for="telefono1">Teléfono</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="tel" name="telefono2" id="telefono2">
                            <label for="telefono2">Teléfono</label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col s12 m4 input-field">
                            <input type="text" name="idCuenta" id="idCuenta"  placeholder="Este id se encuentra desde el panel de Openpay" required>
                            <label for="idCuenta">Id de cuenta </label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" name="primaryKey" id="primaryKey" placeholder="Esta llave se encuentra desde panel de Openpay" required>
                            <label for="primaryKey">Llave privada</label>
                        </div>

                        <div class="col s12 m4 input-field">
                            <input type="text" name="publicKey" id="publicKey" placeholder="Esta llave se encuentra desde panel de Openpay">
                            <label for="publicKey">Llave pública</label>

                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button form="formulario" class="btn waves-effect waves-light right" type="submit" name="action">Guardar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("select").material_select();
    });
    function cargarMunicipios()
    {
        var idEstado=$("#estado").val();
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/getMunicipios/')?>'+idEstado,
            dataType: 'JSON',
            success: function (data)
            {
                $("#municipio").empty();
                $("#municipio").append('<option value="">Seleccione un municipio</option>')

                for(var i=0; i<data.length; i++)
                {
                    $("#municipio").append('<option value="'+data[i]['idMunicipio']+'">'+data[i]['nombreMunicipio']+'</option>')
                }
                $('select').material_select();
            }, complete:function () {
                cargarColonias();
            }

        });

    }
    function cargarColonias()
    {
        var idMunicipio=$("#municipio").val();
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/getColonias/')?>'+idMunicipio,
            dataType: 'JSON',
            success: function (data)
            {
                $("#colonia").empty();
                $("#colonia").append('<option value="">Seleccione una colonia</option>')

                for(var i=0; i<data.length; i++)
                {
                    $("#colonia").append('<option value="'+data[i]['idRegion']+'">'+data[i]['nombreRegion']+'. C.P. '+data[i]['codigoPostal']+'</option>')
                }
                $('select').material_select();
            }

        });

    }
    $("#formulario").submit(function (e)
    {
        e.preventDefault();
        var formulario=new FormData(document.getElementById("formulario"));
        $.ajax({
            url: '<?=base_url('index.php/CrudSucursal/insertSucursal')?>',
            data: formulario,
            type: 'POST',
            processData: false,
            contentType: false,
            success:function (data) {
                swal("¡Exito!", "Se ha registrado la nueva sucursal", "success");
                loadUrl('CrudSucursal');
            }

        });
    });
</script>