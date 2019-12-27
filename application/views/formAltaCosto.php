
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12"><h4 class="header">Nuevo costo para la membresía <?=$nombreMembresia?></h4></div>

        </div>

        <div align="center">

            <a class='btn waves-light waves-effect' onclick="loadUrl('CrudCosto/verCostos/<?=$idMembresia?>')">Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <form class="col s12" id="formulario">

                            <div class="row">
                                <div class="col s12 m4 input-field">
                                    <input id="anio" name="anio" type="number" step="1" value="0" min="0" required>
                                    <label class="active" for="anio">Años que cubre el costo</label>
                                </div>
                                <div class="col s12 m4 input-field">
                                    <input id="mes" name="mes" type="number" step="1" value="0" min="0" max="12" required>
                                    <label class="active" for="mes">Meses que cubre el costo</label>
                                </div>
                                <div class="col s12 m4 input-field">
                                    <input id="dia" name="dia" type="number" step="1" value="0" min="0" max="31" required>
                                    <label class="active" for="dia">Días que cubre el costo</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m6 input-field">
                                    <select id="caja" name="caja" required>
                                        <option value="">Seleccione una opción</option>
                                        <?php
                                        foreach ($cajas as $caja)
                                        {
                                            print "<option value='".$caja['idCaja']."'>".$caja['nombreCaja']."</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="caja">Caja</label>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <input id="costo" name="costo" type="number" step="0.01" required>
                                    <label for="costo">Costo (MXN)</label>
                                </div>
                            </div>


                            <div class="row">

                                <div class="input-field col s9">

                                    <button class="btn waves-effect waves-light right" type="submit" name="action">Guardar

                                        <i class="material-icons right">send</i>

                                    </button>

                                </div>

                            </div>

                    </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function () {
        $("select").material_select();
    });
    $("#formulario").on('submit', function (e)
    {
        e.preventDefault();
        var periodo=parseInt($("#anio").val())+parseInt($("#mes").val())+parseInt($("#dia").val());
        //si se especificó periodo:
        if(periodo>0)
        {
            $.ajax({
                url: '<?=base_url('index.php/CrudCosto/insertCosto/'.$idMembresia)?>',
                dataType: 'JSON',
                type: 'POST',
                data: {caja:$("#caja").val(), anio:$("#anio").val(), mes:$("#mes").val(), dia:$("#dia").val(), costo:$("#costo").val() },
                success: function (data) {
                    swal("¡Exito!", "El costo ha sido registrado!", "success");
                    loadUrl('CrudCosto/verCostos/<?=$idMembresia?>');
                }
            });
        }
        else
        {
            swal("Error", "Especifique un periodo!", "error");
        }

    });

</script>



 
    




