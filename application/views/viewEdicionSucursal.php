<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Edición de la sucursal <?=$sucursal['nombreSucursal']?></h4>
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
                            <input type="text" name="nombreSucursal" id="nombreSucursal" value="<?=$sucursal['nombreSucursal']?>" required >
                            <label for="nombreSucursal" class="active">Nombre de la sucursal</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" name="calleSucursal" id="calleSucursal" value="<?=$sucursal['calle']?>" required >
                            <label for="calleSucursal" class="active">Calle</label>
                        </div>
                        <div class="col s12 m2 input-field">
                            <input type="text" name="numeroSucursal" id="numeroSucursal" value="<?=$sucursal['numero']?>" required >
                            <label for="numeroSucursal" class="active">Número exterior</label>
                        </div>
                        <div class="col s12 m2 input-field">
                            <input type="text" name="numeroInterior" id="numeroInterior" value="<?=$sucursal['numeroInterior']?>" >
                            <label for="numeroInterior" class="active">Número interior</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 input-field">
                            <select name="estado" id="estado" onchange="cargarMunicipios()" required >
                                <option value="">Seleccione un estado</option>
                                <?php
                                foreach ($estados as $est)
                                {
                                    print "<option value='".$est['idEstado']."'>".$est['nombreEstado']."</option>";
                                }
                                ?>
                            </select>
                            <label for="estado">Estado</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select name="municipio" id="municipio" onchange="cargarColonias()" required >
                                <option value="">Seleccione un municipio</option>
                                <?php
                                foreach ($municipiosEstado as $municipioEstado)
                                {
                                    print "<option value='".$municipioEstado['idMunicipio']."'>".$municipioEstado['nombreMunicipio']."</option>";
                                }
                                ?>
                            </select>
                            <label for="municipio">Municipio</label>
                        </div>
                        <div class="col s12  m4 input-field">
                            <select name="colonia" id="colonia" required >
                                <option value="">Seleccione una colonia</option>
                                <?php
                                foreach ($coloniasMunicipio as $coloniaMunicipio)
                                {
                                    print "<option value='".$coloniaMunicipio['idRegion']."'>".$coloniaMunicipio['nombreRegion']." C.P. ".$coloniaMunicipio['codigoPostal']."</option>";

                                }
                                ?>
                            </select>
                            <label for="colonia">Colonia</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m3 input-field">
                            <input type="text" name="RazonSocial" id="RazonSocial" value="<?=$sucursal['RazonSocial']?>" >
                            <label for="RazonSocial" class="active">Razón Social</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="text" name="RFC" id="RFC" value="<?=$sucursal['RFC']?>" >
                            <label for="RFC" class="active">RFC</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="tel" name="telefono1" id="telefono1" value="<?=$sucursal['telefono1']?>" >
                            <label for="telefono1" class="active">Teléfono</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="tel" name="telefono2" id="telefono2" value="<?=$sucursal['telefono2']?>" >
                            <label for="telefono2" class="active">Teléfono</label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col s12 m4 input-field">
                            <input type="text" name="idCuenta" id="idCuenta" placeholder="Este id se encuentra desde el panel de Openpay" value="<?=$sucursal['idCuenta']?>"  required>
                            <label for="idCuenta" class="active">Id de cuenta </label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" name="primaryKey" id="primaryKey" placeholder="Esta llave se encuentra desde panel de Openpay" value="<?=$sucursal['keyPrivada']?>" required>
                            <label for="RazonSocial" class="active">Llave privada</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" name="publicKey" id="publicKey" placeholder="Esta llave se encuentra desde panel de Openpay" value="<?=$sucursal['keyPublica']?>" >
                            <label for="publicKey" class="active">Llave pública</label>
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
        $("#estado").val('<?=$estado['idEstado']?>');
        $("#municipio").val('<?=$municipio['idMunicipio']?>');
        $("#colonia").val('<?=$region['idRegion']?>');
        $("select").material_select();
    });
    $("#formulario").submit(function (e)
    {
        e.preventDefault();
        var formulario=new FormData(document.getElementById("formulario"));
        $.ajax({
            url: '<?=base_url('index.php/CrudSucursal/updateSucursal/').$sucursal['idSucursal']?>',
            data: formulario,
            type: 'POST',
            processData: false,
            contentType: false,
            success:function (data) {
                swal("¡Exito!", "Se ha modificado la sucursal", "success");
                loadUrl('CrudSucursal');
            }

        });
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

</script>