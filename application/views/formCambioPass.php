<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="GlobalShield">
    <meta name="keywords" content="Panel de administración GlobalShield">
    <title>GlobalShield | Cambio de Contraseña</title>
    <!-- Favicons-->
    <link rel="icon" href="<?=base_url('assets/images/favicon/favico.png')?>">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="<?=base_url('assets/images/favicon/favicon-32x32.png')?>../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="<?=base_url('assets/css/themes/collapsible-menu/materialize.css')?>" type="text/css" rel="stylesheet">
    <link href="<?=base_url('assets/css/themes/collapsible-menu/style.css')?>" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <link href="<?=base_url('assets/css/custom/custom.css')?>" type="text/css" rel="stylesheet">
    <link href="<?=base_url('assets/css/layouts/page-center.css')?>" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="<?=base_url('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')?>" type="text/css" rel="stylesheet">
    <style type="text/css">
        body{
            top: -10%;
            right: -10%;
            bottom: -10%;
            left: -10%;
            width: auto;
            height: auto; */
            z-index: -2147483646;
            background: url(<?=base_url()?>assets/background_login.jpg) 50% 50%;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .redondeado{
            border-radius: 25px;
        }
        .field p {
            padding: 0;
            margin-top: 10px;
            margin-bottom: 0px;
            font-size: 3vh;
            text-align: center;
        }
        .field p:nth-child(2) {
            padding: 0;
            margin-top: 10px;
            margin-bottom: 0px;
            font-size: 1em;
            text-align: center;
        }
        .input-field input #email{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->
<div class="row">
    <div class="col s12 m8 offset-m2 l6 offset-l3 xl4 offset-xl4">
        <div class="col s12  m12 card-panel redondeado">
            <form method="POST" id="formulario" action="<?=base_url()?>">
                <div class="col s12">
                    <input type="hidden" name="encriptado" value="<?=$encriptado?>"></input>
                    <div class="input-field col s12 center">
                        <img src="<?=base_url('/assets/globalShield.png')?>" alt="" class="responsive-img valign">
                    </div>
                </div>
                <div class="field">
                    <p><strong>Recuperación de contraseña</strong></p>
                    <p>Escriba la nueva contraseña para entrar al sistema
                    </p>
                </div>
                <div class="input-field col s12" style="display: flex;">
                    <div class="input-field col s0 m1 l1 xl1">
                        <img src="<?=base_url()?>/assets/images/icon/2.png" style="max-width: 500%">
                    </div>
                    <div class="input-field col s12 m9 l9 xl9">
                        <input id="passwordUs" name="passwordUs" type="password" placeholder="Contraseña">
                        <label for="passwordUs"></label>
                    </div>

                </div>
                <div class="input-field col s12" style="display: flex;">
                    <div class="input-field col s0 m1 l1 xl1">
                        <img src="<?=base_url()?>/assets/images/icon/2.png" style="max-width: 500%">
                    </div>
                    <div class="input-field col s12 m9 l9 xl9">
                        <input id="passwordConf" name="passwordConf" type="password" placeholder="Confirmar Contraseña">
                        <label for="passwordConf"></label>
                    </div>

                </div>
                <div class="row">
                    <div class="input-field col s12" align="center">
                        <input type="submit" class="btn waves-effect waves-light" value="Cambiar Contraseña">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ================================================
Scripts
================================================ -->
<!-- jQuery Library -->
<script type="text/javascript" src="<?=base_url('assets/vendors/jquery-3.2.1.min.js')?>"></script>

<!--
=====================================================
Script function submit
-->
<script type="text/javascript">
    $("#formulario").submit(function (e)

    {
        e.preventDefault();
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

            swal('Error', 'Las contraseñas no coinciden', 'error');
            return;
        }
        var formulario = new FormData(document.getElementById('formulario'));
        $.ajax({
            url: '<?= base_url('index.php/Crudusuarios/cambioContrasena')?>',
            type: 'POST',
            data: formulario,
            processData: false,
            contentType: false,
            success: function(data){
                Swal.fire({
                    type: 'success',
                    title: 'Éxito!',
                    html: 'Se cambió la contraseña',
                    timer: 2000,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('strong')
                                .textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    onClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.timer
                    ) {
                        location.replace("<?=base_url()?>");
                    }
                })
            }
        });
    });
</script>
<!--Swal alert js-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="<?=base_url('assets/js/materialize.min.js')?>"></script>
<!--scrollbar-->
<script type="text/javascript" src="<?=base_url('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?=base_url('assets/js/plugins.js')?>"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="<?=base_url('assets/js/custom-script.js')?>"></script>
</body>
</html>

<!-- e.preventDefault();

            $.post('<?=base_url('index.php/Crudusuarios/editaDatos') ?>',

                {
                passwordUs: $("#passwordUs").val(),
                passwordConf: $("#passwordConf").val()
                },

                function(response){
                    let timerInterval
                    Swal.fire({
                      type: 'success',  
                      title: 'Éxito!',
                      html: 'El sistema restableció la contraseña para que pueda volver a acceder',
                      timer: 2000,
                      onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                          Swal.getContent().querySelector('strong')
                            .textContent = Swal.getTimerLeft()
                        }, 100)
                      },
                      onClose: () => {
                        clearInterval(timerInterval)
                      }
                    }).then((result) => {
                      if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.timer
                      ) {
                        location.replace("<?=base_url()?>");
                      }
                    })   
                }
            ); 
        }    -->