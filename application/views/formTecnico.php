
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12 m4"><h4 class="header">Nuevo Técnico</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('CrudMantenimiento/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <form class="col s12" id="formulario">

                            <div class="row">

                                <div class="input-field col s12 m6">

                                    <input id="nombreTecnico" id="nombreTecnico" type="text" required>

                                    <label for="nombreTecnico">Nombre del Técnico</label>

                                </div>

                                <div class="input-field col s12 m6">

                                    <input id="correoTecnico" id="correoTecnico" type="email" required>

                                    <label for="correoTecnico">Correo del Técnico</label>

                                </div>

                            </div>

                            <div class="row">

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

            $.post('<?=base_url('index.php/CrudMantenimiento/nuevoTec')?>',

            {
                nombreTecnico: $("#nombreTecnico").val(),
                correoTecnico: $("#correoTecnico").val()
            },

                function(response){

                    swal('Exito', 'Se guardó el nuevo registro', 'success');
                    loadUrl('CrudMantenimiento')
                }

            );

        });

    </script>


