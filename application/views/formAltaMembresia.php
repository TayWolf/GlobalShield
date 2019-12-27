<div class="section">
    <div class="row">
        <div class="col s12">
            <div class="col  s4">
                <h4 class="header">Nueva membresía</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="col offset-s4 s4" align="center">
                <a class="btn waves-light waves-effect" onclick="loadUrl('CrudMembresia')">Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <form>
                    <div class="row">
                        <div class="col s12 input-field">
                            <input type="text" id="nombreMembresia" name="nombreMembresia">
                            <label for="nombreMembresia">Nombre de la nueva membresía</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s3 offset-s9">
                            <button class="btn waves-effect waves-light right" type="submit" name="action">Guardar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
    $("form").submit(function (e) {
       e.preventDefault();
       $.post(
           '<?=base_url('index.php/CrudMembresia/insertMembresia/')?>',
           {
               nombreMembresia: $("#nombreMembresia").val()
           },
           function (response) {
               swal("¡Exito!", "La nueva membresia ha sido registrada!", "success");
               loadUrl('CrudMembresia');
           }
       );
    });
</script>