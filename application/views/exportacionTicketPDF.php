<style>
    .centrado{
        width: 100% !important;
        text-align: center ;
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;
    }
    .justificado{
        width: 100% !important;
        text-align: justify !important;
        padding-top: 0 !important;
        padding-left: 0px !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;
    }
    .right{
        right: 20px;
        text-align: right !important;
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-bottom: 0 !important;
        padding-right: 0 !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
        margin-bottom: 0 !important;
        margin-right: 0 !important;

    }
    .letraPequena{
        font-size: 6px !important;
        line-height: 6px !important;

    }
    .letraPequenaMediana{
        font-size: 7px !important;
        line-height: 6.5px !important;

    }
    .letraMediana{
        font-size: 8px;
        line-height: 12px !important;
    }
    .letraGrande{
        font-size: 12px;
        line-height: 6px !important;


    }
    .espacioXXPequeño
    {
        line-height: 0 !important;
        padding: 0 0 0 0 !important;
        margin: 0 0 0  0 !important;
    }
    .espacioExtraPequeño
    {
        line-height: 4px !important;
    }
    .espacioExtraPequeñoLabel
    {
        line-height: 6px !important;
    }
    .espacioPequeño
    {
        line-height: 8px !important;
    }
    .espacioMediano
    {
        line-height: 10px !important;
    }
    .espacioGrande
    {
        line-height: 12px !important;
    }
    .instrucciones
    {
        text-transform: uppercase;
    }
    ul
    {
        list-style-type: none;
        overflow: hidden;
    }
</style>
<label class="centrado" style="min-width: 100% !important; line-height: 0">
    <div class="centrado"><img width="150px" height="50px" src="<?=base_url('assets/globalShield.png')?>"></div><br class="espacioExtraPequeñoLabel">
    <b class="letraMediana centrado">BÓVEDAS MULTIBLINDADAS S.A. DE C.V.</b><br class="espacioPequeño">
    <b class="letraPequenaMediana centrado">FOLIO: <?=str_replace("-", "", $contrato['fechaRegistro']).$renovaciones[sizeof($renovaciones)-1]['idHistorial']?></b><br class="espacioPequeño">
    <b class="letraPequena" >R.F.C.: BMU0809261G1</b>     <b class="letraPequena" align="right">FECHA: <?=date("Y-m-d")?></b><br class="espacioPequeño">
    <label class="letraPequena" ><?=($datosSucursal['calle']." No. ".$datosSucursal['numero']." Col. ".$datosSucursal['nombreRegion']."  C.P. ".$datosSucursal['codigoPostal']." ".$datosSucursal['nombreMunicipio'].", ".$datosSucursal['nombreEstado']); ?></label><br class="espacioExtraPequeño">
    <label class="letraPequena" >Tel.: <?=$datosSucursal['telefono1']." / ".$datosSucursal['telefono2']?></label><br class="espacioPequeño">
</label>
<div class="espacioExtraPequeño">
    <div class="espacioExtraPequeño centrado">
    </div>
    <div class="espacioXXPequeño centrado" >
        <b class="letraPequenaMediana">Titular: </b><label class="letraPequenaMediana"><?=$contrato['nombreCliente']?></label><br class="espacioExtraPequeñoLabel">
        <b class="letraPequena centrado"></b><label class="letraPequena"><?=$datosCliente['calle']." No. ".$datosCliente['numero']." Col. ".$datosCliente['nombreRegion']." C.P. ".$datosCliente['codigoPostal']." <br>".$datosCliente['nombreMunicipio'].", ".$datosCliente['nombreEstado'];?></label>
    </div>
    <div class="espacioXXPequeño centrado">

        <b class="letraMediana centrado"><?=mb_strtoupper($contrato['nombreMembresia'], 'UTF-8')?></b>
    </div>
    <label class="letraPequena centrado"><?=$contrato['nombreCaja']?></label> <b class="letraPequena"><?=$contrato['pasillo'].$contrato['numeroCaja']?></b><br class="espacioPequeño">
    <div class="espacioXXPequeño centrado">
        <label class="letraPequena">Precio: $<?php
            setlocale(LC_ALL, 'es_MX');
            echo number_format( $contrato['costoCaja'],2, '.', ','); ?> M.N. <br class="espacioExtraPequeñoLabel">(<?php
            //si esta linea marca error: agregar a php.ini la siguiente linea: extension=ext/php_intl.dll
            $f = new \NumberFormatter("es_MX", NumberFormatter::SPELLOUT);
            echo mb_strtoupper($f->format((int)$contrato['costoCaja']), 'UTF-8');
            $centavos = explode(".", number_format( $contrato['costoCaja'],2, '.', ','))[1];

            ?> PESOS <?=$centavos?>/100 M.N.)</label><br class="espacioExtraPequeñoLabel">
        <b class="letraPequena">Forma de pago:</b><label class="letraPequena"> <?php
            if($contrato['formaPago']==1)
                print "Efectivo";
            else if($contrato['formaPago']==2)
                print "Transferencia";
            else
                print "Tarjeta";
            ?></label>
    </div>

    <b class="letraPequena centrado"><?=($numeroRenovaciones>1)?"Renovación:":"Vigencia:"?></b><label class="letraPequena"> <?php

        //Si el servidor no soporta el locale 'esp' tratar con la siguiente linea:
        //setlocale(LC_TIME, 'es_MX');
        //Si sigue marcando mal el locale, investigar los locales soportados por el sistema operativo del servidor
        $nombrePeriodo="";
        if($contrato['numeroAnios']>0)
        {
            $nombrePeriodo.=$contrato['numeroAnios']." año (s) ";
            if($contrato['numeroMeses']!='0')
                $nombrePeriodo.=", ";
        }
        if($contrato['numeroMeses']!='0')
        {
            $nombrePeriodo.=$contrato['numeroMeses']." meses ";
            if($contrato['numeroDias']!='0')
                $nombrePeriodo.=", ";
        }
        if($contrato['numeroDias']!='0')
        {
            $nombrePeriodo.=$contrato['numeroDias']." días";
        }
        echo ("$nombrePeriodo");
        ?></label>

    <label class="letraPequena" >Del <?php
        setlocale(LC_ALL, 'es_MX');
        $date = DateTime::createFromFormat("Y-m-d", $contrato['fechaRegistro']);
        $mes=strftime("%B",$date->getTimestamp());
        $dia=strftime("%d",$date->getTimestamp());
        $anio=strftime("%Y",$date->getTimestamp());
        print mb_strtolower("$dia de $mes de $anio", 'UTF-8');
        ?></label><label class="letraPequena" > al <?php
        $date = DateTime::createFromFormat("Y-m-d", $contrato['fechaTermino']);
        $mes=strftime("%B",$date->getTimestamp());
        $dia=strftime("%d",$date->getTimestamp());
        $anio=strftime("%Y",$date->getTimestamp());
        print mb_strtolower("$dia de $mes de $anio", 'UTF-8');
        ?></label><br>

</div>
<div class="espacioExtraPequeño centrado" >
    <label class="letraPequena">Este documento es una nota de remisión y no tiene validez fiscal.</label>
    <div class="row">
        <div class="espacioExtraPequeño letraPequena">
            <b class="instrucciones centrado">Instrucciones de facturación</b>
            <br>
            <div class="letraPequena">
                <label>1. Ingresa a nuestra página<strong> https://www.globalshield.com.mx/clientes</strong></label>
                <br>
                <label>2. Inicia sesión con el correo y contraseña que nos propocionaste</label>
                <br>
                <label>3. Ve al apartado de facturas e ingresa tu folio</label>
                <br>
                <label>4. Genera tu factura</label> 
            </div>
        </div>
    </div>
</div>