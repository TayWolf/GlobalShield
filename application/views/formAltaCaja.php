
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12 m4"><h4 class="header">Nueva caja</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudCaja')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <form class="col s12" id="formulario">

                            <div class="row">
                                <div class="col s12 input-field">
                                    <input id="nombreCaja" name="nombreCaja" type="text" required>
                                    <label for="nombreCaja">Nombre de la caja</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 input-field">
                                    <textarea class="materialize-textarea" id="especificaciones" name="especificaciones"></textarea>
                                    <label for="especificaciones">Especificaciones técnicas</label>
                                </div>
                            </div>



                            <div class="row">

                                <div class="input-field col s12">

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

    $("#formulario").on('submit', function (e)
    {

        e.preventDefault();

        $.post('<?=base_url('index.php/CrudCaja/nuevaCaja')?>',
            {
                nombre: $("#nombreCaja").val(),
                especificaciones: $("#especificaciones").val()
            },
            function(response){
                swal('Exito', 'Se guardó la nueva caja', 'success');
                loadUrl('CrudCaja')
            }

        );

    });

</script>



 
    




