<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="GlobalShield">
        <meta name="keywords" content="Panel de administración GlobalShield">
        <title>GlobalShield</title>
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
                background: url(../assets/background_login.jpg) 50% 50%;
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
                text-align: justify;   
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
                <form class="login-form" id="formulario">
                    <div class="col s12">
                        <div class="input-field col s12 m12 l12 xl12" align="center">
                            <img src="<?=base_url('/assets/globalShield.png')?>" alt="" class="responsive-img valign">
                        </div>
                    </div>

        			<div class="row">
        	            <div class="input-field col s12 m12 l12 xl12">
        	                <div class="field">
        	                    <p><strong>Recuperación de contraseña</strong></p>
        	                    <p>Escriba la dirección de correo electrónico que esté asociada a su cuenta de GlobalShield.
        	                    </p>
        	                </div>
        	            </div>
        	            <div class="input-field col s12 m12 l12 xl12" style="display:flex;">
        	                <div class="input-field col s1">
        	                	<img src="<?=base_url()?>/assets/images/icon/3.png" style="max-width: 500%; margin-right: 10px;">
        	                </div>
        	                <div class="input-field col s9 m9 l9 xl9">
        	                    <input id="correoU" name="correoU" type="email" placeholder="Correo" required>
        	                    <label for="correoU" class="center-align"></label>
        	                </div>
        	            </div>
                    </div>
                    
                    <div class="row" style="display:flex;" align="center">
                        <div class="input-field col s12 m12 l12 xl12">
                            <a id="log" href="<?=base_url()?>" class="btn waves-effect waves-light">Regresar</a>
                        </div>
                            <div class="input-field col s12 m12 l12 xl12">
                            	<input type="submit" id="sendpass" class="btn waves-effect waves-light" value="Enviar">
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="<?=base_url('assets/vendors/jquery-3.2.1.min.js')?>"></script>

    <script type="text/javascript">	
    	$("#formulario").submit(function (e)
            {
            e.preventDefault();
            if ($('#correoU').val())
                $.post('<?=base_url('index.php/Crudusuarios/confPassword')?>',
                    {
                        correoU: $("#correoU").val()
                    },
                    function(response){
                        let timerInterval
                        Swal.fire({
                          type: 'success',  
                          title: 'Éxito!',
                          html: 'Se mandó un correo con el link de recuperación de contraseña',
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
                ); 
            });
    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?=base_url('assets/js/materialize.min.js')?>"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?=base_url('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?=base_url('assets/js/plugins.js')?>"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?=base_url('assets/js/custom-script.js')?>"></script>
</html>