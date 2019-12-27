
<div class="container">

    <div class="row">

        <div class="col s12">

            <div class="col s4"><h4 class="header">Nuevo Usuario</h4></div>

        </div>

        <div align="center">

            <a class='dropdown-trigger btn' href="#" onclick="loadUrl('Crudusuarios/')" data-target='dropdown1'>Regresar</a>

        </div>

        <div class="col s12">

            <div class="col s12 ">

                <div class="card-panel">

                    <div class="row">

                        <form class="col s12" id="formulario">

                            <div class="row">

                                <div class="input-field col s4">
                                    <input id="nameUser" id="nombreUser" type="text" required>
                                    <label for="name">Nombre del usuario</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="passwordUs" name="passwordUs" type="password">
                                    <label for="name">Password</label>
                                </div>
                                <div class="input-field col s4">
                                    <input id="passwordConf" name="passwordConf" type="password">
                                    <label for="name">Confirmar Password</label>
                                </div>
                                
                                <div class="input-field col s4">
                                    <input id="nickName" name="nickName" type="text" required>
                                    <label for="name">NickName</label>
                                </div>
                                <div class="col s12 m4">
                                  <label>Tipo</label>
                                  <select class="browser-default" id="idTipoUsuario" name="idTipoUsuario" required>
                                    <option value="" selected>Seleccione una opción</option>
                                    <?php 
                                    foreach ($TipoU as $row) {
                                        $idTipoUsuario=$row["idTipoUsuario"];
                                        $nombreTipoUsuario=$row["nombreTipoUsuario"];
                                        echo "<option value='$idTipoUsuario'>$nombreTipoUsuario</option>";
                                    }
                                     ?>
                                  </select>
                                </div>

                                <div class="input-field col s4">
                                    <input id="correoUsuario" name="correoUsuario" type="email" required>
                                    <label for="name">Correo de notificación</label>
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
        var passwordUs = document.getElementById("passwordUs").value;
        var passwordConf = document.getElementById("passwordConf").value;
        var espacios = false;
        var cont = 0;

        while (!espacios && (cont < passwordUs.length) || !espacios && (cont < passwordConf.length)) {
          if (passwordUs.charAt(cont) == " " || passwordConf.charAt(cont) == " ")
            espacios = true;
          cont++;
        }
         
        if (espacios) {
          swal('Error','La contraseña no puede contener espacios en blanco', 'error')
          return false;
        }
        
        if (passwordUs.length == 0 || passwordConf.length == 0) {
          swal('Error','Las contraseñas no pueden quedar vacias', 'error')
          return false;
        }

        if (passwordUs.length < 8 || passwordConf.length < 8) {
          swal('Error','Para una mayor seguridad las contraseñas deben tener al menos 8 caracteres', 'error')
          return false;
        }

        if (passwordUs != passwordConf) {
          swal('Error','Las contraseñas deben de coincidir', 'error')
          return false;

        }else {

           e.preventDefault();

            $.post('<?=base_url('index.php/Crudusuarios/nuevoUser')?>',

                {
                nameUser: $("#nameUser").val(),
                passwordUs: $("#passwordUs").val(),
                passwordConf: $("#passwordConf").val(),
                nickName: $("#nickName").val(),
                idTipoUsuario: $("#idTipoUsuario").val(),
                correoUsuario: $("#correoUsuario").val()
            },

                function(response){

                    
                }

            ).done(function() {
                swal('Exito', 'Se guardó el nuevo usuario', 'success');
                loadUrl('Crudusuarios')
            }).fail(function() {
                swal('Error','El nickname o el correo ya estan registrados en el sistema', 'error')
              }); 
        }
        
        });  

    </script>



 
    




