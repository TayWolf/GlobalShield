<?php
if(!empty($permisos)) {
    $arregloPermisos = array();
    foreach ($permisos as $permiso) {
        $arregloPermisos[intval($permiso['idModulo'])] = $permiso;
    }
    ?>
    <!-- START LEFT SIDEBAR NAV-->

    <aside id="left-sidebar-nav" class="nav-expanded nav-lock nav-collapsible">
        <div class="brand-sidebar">
            <h1 class="logo-wrapper">
                <a href="tablero" class="brand-logo darken-1" >
                    <img src="<?= base_url('assets/globalShield.png') ?>" alt="materialize logo" style="width: 100%; height: 100%;">
                </a>
                <a class="navbar-toggler">
                    <i class="material-icons">radio_button_checked</i>
                </a>
            </h1>
        </div>
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="no-padding">
                <ul class="collapsible" data-collapsible="accordion">
                    <li class="bold" id="listItemAdministracion">
                        <a class="collapsible-header waves-effect waves-cyan ">
                            <span class="nav-text"><b style="color: #f2f2f2">Administración</b></span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <?php

                                if(isset($arregloPermisos[0])&&$arregloPermisos[0]['mostrar'])
                                {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('Crudtipou/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right
                                                share</i>
                                            <span style="color:#FFFFFF;">Tipos de usuarios</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[1])&&$arregloPermisos[1]['mostrar'])
                                {
                                    ?>

                                    <li onclick="limpiarSecciones();loadUrl('Crudusuarios/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right people</i>
                                            <span style="color:#FFFFFF;">Usuarios</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[2])&&$arregloPermisos[2]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudCaja/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right lock</i>
                                            <span style="color:#FFFFFF;">Cajas</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[12])&&$arregloPermisos[12]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudSeguro/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right monetization_on</i>
                                            <span style="color:#FFFFFF;">Seguro</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[3])&&$arregloPermisos[3]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudMembresia/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right contacts</i>
                                            <span style="color:#FFFFFF;">Membresías</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[9])&&$arregloPermisos[9]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudSucursal/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right business</i>
                                            <span style="color:#FFFFFF;">Sucursal</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[10])&&$arregloPermisos[10]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudMundoCaja/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right view_module</i>
                                            <span style="color:#FFFFFF;">Mundo de cajas</span>

                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[13])&&$arregloPermisos[13]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudMantenimiento/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right build</i>
                                            <span style="color:#FFFFFF;">Técnicos (Mantenimiento)</span>
                                        </a>
                                    </li>
                                    <?php
                                }


                                ?>
                            </ul>
                        </div>
                    </li>
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-cyan active">
                            <span class="nav-text"><b style="color: #f2f2f2">Contratos</b></span>
                        </a>
                        <div class="collapsible-body">
                            <ul>
                                <?php
                                if(isset($arregloPermisos[6])&&$arregloPermisos[6]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudClienteExterno/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right person</i>
                                            <span style="color:#FFFFFF;">Clientes</span>
                                        </a>
                                    </li>
                                    <?php
                                }

                                if(isset($arregloPermisos[7])&&$arregloPermisos[7]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudContrato/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right description</i>
                                            <span style="color:#FFFFFF;">Contrato</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[14])&&$arregloPermisos[14]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudContrato/contratosTerminados')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right archive</i>
                                            <span style="color:#FFFFFF;">Contratos terminados</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[11])&&$arregloPermisos[11]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudMoroso/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right receipt</i>
                                            <span style="color:#FFFFFF;">Morosos</span>

                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($arregloPermisos[15])&&$arregloPermisos[15]['mostrar']) {
                                    ?>
                                    <li onclick="limpiarSecciones();loadUrl('CrudFactura/')">
                                        <a>
                                            <i class="material-icons" style="color:#F2F2F2;">keyboard_arrow_right insert_drive_file</i>
                                            <span style="color:#FFFFFF;">Facturación</span>

                                        </a>
                                    </li>
                                    <?php
                                } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
        <a data-activates="slide-out"
           class="sidebar-collapse btn-floating btn waves-effect waves-light hide-on-large-only gradient-45deg-indigo-light-blue gradient-shadow">
        </a>
    </aside>
    <script>
        function limpiarSecciones() {
            $("#content").html('');
            $("#contenido").html('');
        }
    </script>


    <!-- END LEFT SIDEBAR NAV-->
    <?php
}?>