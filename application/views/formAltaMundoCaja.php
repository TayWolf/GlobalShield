<style>
    .invisible{
        display: none;
    }
    .visible{
        display: block;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Alta de cajas</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12" align="center">
            <a class="btn waves-light waves-effect" onclick="loadUrl('CrudMundoCaja')">Regresar</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">

            <div class="card-panel">
                <div class="row">
                    <div class="col s12 m4 input-field">
                        <select onchange="cambiarFormulario(this)">
                            <option value="1">Registro individual</option>
                            <option value="2">Registro múltiple</option>
                        </select>
                    </div>
                </div>
                <form id="formularioIndividual" class="visible">
                    <div class="row">
                        <div class="col s12 m3 input-field">
                            <select name="idSucursal" id="idSucursal" required>
                                <?php
                                foreach ($sucursales as $sucursal)
                                {
                                    print "<option value='".$sucursal['idSucursal']."'>".$sucursal['nombreSucursal']."</option>";
                                }
                                ?>
                            </select>
                            <label for="idSucursal">Sucursal</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <select id="tipoCaja" name="tipoCaja" required>
                                <?php
                                foreach ($tiposCaja as $tipoCaja)
                                {
                                    print "<option value='".$tipoCaja['idCaja']."'>".$tipoCaja['nombreCaja']."</option>";
                                }
                                ?>
                            </select>
                            <label for="tipoCaja">Tipo de caja</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="text" id="pasillo" name="pasillo" required>
                            <label for="pasillo">Pasillo</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="text" id="numeroCaja" name="numeroCaja" required>
                            <label for="numeroCaja">Número de caja</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button form="formularioIndividual" class="btn waves-effect waves-light right" type="submit" name="action">Guardar <i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
                <form id="formularioMultiple" class="invisible">
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <select name="idSucursal" id="idSucursal" required>
                                <?php
                                foreach ($sucursales as $sucursal)
                                {
                                    print "<option value='".$sucursal['idSucursal']."'>".$sucursal['nombreSucursal']."</option>";
                                }
                                ?>
                            </select>
                            <label for="idSucursal">Sucursal</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <select id="tipoCaja" name="tipoCaja" required>
                                <?php
                                foreach ($tiposCaja as $tipoCaja)
                                {
                                    print "<option value='".$tipoCaja['idCaja']."'>".$tipoCaja['nombreCaja']."</option>";
                                }
                                ?>
                            </select>
                            <label for="tipoCaja">Tipo de caja</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" id="pasillo" name="pasillo" required >
                            <label for="pasillo">Pasillo</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" id="numeroCajaInicio" name="numeroCajaInicio" required>
                            <label for="numeroCajaInicio">Inicio</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <input type="text" id="numeroCajaFin" name="numeroCajaFin" required>
                            <label for="numeroCajaFin">Fin</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button form="formularioMultiple" class="btn waves-effect waves-light right" id="btnGuardarMultiple" type="submit" name="action">Guardar <i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    function cambiarFormulario(elemento)
    {
        if($(elemento).val()==1)
        {
            $("#formularioIndividual").attr("class","visible");
            $("#formularioMultiple").attr("class","invisible");
        }
        else
        {
            $("#formularioMultiple").attr("class","visible");
            $("#formularioIndividual").attr("class","invisible");
        }



    }
    $(document).ready(function () {
        $("select").material_select();
    });
    $("#formularioIndividual").submit(function (e)
    {
        e.preventDefault();
        var formulario=new FormData(document.getElementById("formularioIndividual"));
        $.ajax({
            url: '<?=base_url('index.php/CrudMundoCaja/insertMundoCajaIndividual')?>',
            data: formulario,
            type: 'POST',
            processData: false,
            contentType: false,
            success:function (data) {

                swal("¡Exito!", "Se ha registrado la nueva caja", "success");
                loadUrl('CrudMundoCaja');
            }

        });
    });
    $("#formularioMultiple").submit(function (e)
    {
        e.preventDefault();

        $("#btnGuardarMultiple").addClass("disabled");
        Swal.fire({
            title: 'Procesando...',
            onBeforeOpen: () => {
                Swal.showLoading();
            }});
        var formulario=new FormData(document.getElementById("formularioMultiple"));
        $.ajax({
            url: '<?=base_url('index.php/CrudMundoCaja/insertMundoCajaMultiple')?>',
            data: formulario,
            type: 'POST',
            processData: false,
            contentType: false,
            success:function (data) {
                swal("¡Exito!", "Se han registrado las nuevas cajas", "success");
                loadUrl('CrudMundoCaja');
            }

        });
    });
</script>