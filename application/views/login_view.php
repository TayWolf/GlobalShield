<!DOCTYPE html>
<html  lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            background: url(<?=base_url('/assets/background_login.jpg')?>) 50% 50%;
            background-repeat: no-repeat;
            background-size: cover;
        }       
        .redondeado{
            border-radius: 25px;
        }
        .cont {
            color: gray;   
        }
        a:hover
        {
            color: #5154C4; 
            text-decoration: underline gray;
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
<!-- End Page Loading--> 
<div class="row">
    <div class="col s12 m8 offset-m2 l6 offset-l3 xl4 offset-xl4">
    <div class="col s12  m12 card-panel redondeado">
        <form method="POST" action="<?=base_url()?>">
            <div class="col s12">
                <div class="input-field col s12 center">
                    <img src="<?=base_url('/assets/globalShield.png')?>" alt="" class="responsive-img valign">
                </div>
            </div>
            <div class="input-field col s12" style="display:flex;">
                <div class="input-field col s1">
                    <img src="<?=base_url()?>/assets/images/icon/1.png" style="max-width: 500%">
                </div>
                <div class="input-field col s10">
                    <input id="username" name="username" type="text" placeholder="Usuario">
                    <label for="username" class="center-align"></label>
                </div>

            </div>


            <div class="input-field col s12" style="display: flex;">
                <div class="input-field col s1">
                    <img src="<?=base_url()?>/assets/images/icon/2.png" style="max-width: 500%">
                </div>
                <div class="input-field col s10">
                    <input id="password" name="password" type="password" placeholder="Password">
                    <label for="password"></label>
                </div>

            </div>

            <div class="row " align="center">
                    <a href="<?=base_url('/Crudusuarios/cambioPassword')?>" class="cont">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="row">
                <div class="input-field col s12" align="center">
                    <input type="submit" class="btn waves-effect waves-light" value="Entrar">
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
