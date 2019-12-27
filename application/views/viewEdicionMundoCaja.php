
<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Edición de la caja <?=$mundoCaja['pasillo'].$mundoCaja['numeroCaja']?></h4>
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

                <form id="formulario" >
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
                            <input type="text" id="pasillo" name="pasillo" value="<?=$mundoCaja['pasillo']?>" required>
                            <label class="active" for="pasillo">Pasillo</label>
                        </div>
                        <div class="col s12 m3 input-field">
                            <input type="text" id="numeroCaja" name="numeroCaja" value="<?=$mundoCaja['numeroCaja']?>" required>
                            <label class="active" for="numeroCaja">Número de caja</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button form="formulario" class="btn waves-effect waves-light right" type="submit" name="action">Guardar <i class="material-icons right">send</i></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#idSucursal").val('<?=$mundoCaja['idSucursal']?>');
        $("#tipoCaja").val('<?=$mundoCaja['idTipoCaja']?>');
        $("select").material_select();
    });
    $("#formulario").submit(function (e)
    {
        e.preventDefault();
        var formulario=new FormData(document.getElementById("formulario"));
        $.ajax({
            url: '<?=base_url('index.php/CrudMundoCaja/updateMundoCaja/').$mundoCaja['idMundoCaja']?>',
            data: formulario,
            type: 'POST',
            processData: false,
            contentType: false,
            success:function (data) {
                if(data==1)
                {
                    swal("¡Exito!", "Se ha modificado la nueva caja", "success");
                    loadUrl('CrudMundoCaja');
                }
                else
                {
                    swal("La caja ya existe", "El pasillo y número de caja ya existen en el sistema.\n intente con otra combinación", "error");
                }

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