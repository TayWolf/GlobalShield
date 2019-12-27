
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s12 m4"><h4 class="header">Nuevo Tipo</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudtipou/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <form class="col s12" id="formulario">

                            <div class="row">

                                <div class="input-field col s12">

                                    <input id="name" id="nombre" type="text" required>

                                    <label for="name">Nombre del Tipo</label>

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

            $.post('<?=base_url('index.php/Crudtipou/nuevoTipp')?>',

                {nombre: $("#name").val()},

                function(response){

                    swal('Exito', 'Se guardó el nuevo registro', 'success');
                    loadUrl('Crudtipou')
                }

            );

        });

    </script>


