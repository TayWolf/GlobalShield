<meta charset='utf-8'>
<style>
    table, tr, th, td{
        border: black solid 1px;
    }
    th{
        text-align: center;

    }

</style>
<h3 style="text-align: center" align="center">"GLOBAL SHIELD"</h3>
<u><?=mb_strtoupper($contrato['nombreMembresia'], 'UTF-8')?></u>
<p>Titular: <?=$contrato['nombreCliente']?></p>
<?php
if(!empty($cotitulares)) {
    ?>
    Co-titular(es): <br>
    <?php
    foreach ($cotitulares as $cotitular) {
        print $cotitular['nombreCliente'] . " <br>
    ";
    }
}
    ?>

<p>Pasillo No. "<?=$contrato['pasillo']?>" Caja No: <?=$contrato['numeroCaja']?></p>
<p>Medida: <?=$contrato['nombreCaja']?></p>
Costo. Lista de Precios:
    <ol>
        <li><?php
            setlocale(LC_TIME, 'es_MX');
            echo "Costo de la membresía: ".number_format( $contrato['costoCaja'],2, '.', ','); ?> M.N. (<?php
            //si esta linea marca error: agregar a php.ini la siguiente linea: extension=ext/php_intl.dll
            $f = new \NumberFormatter("es_MX", NumberFormatter::SPELLOUT);
            echo mb_strtoupper($f->format((int)$contrato['costoCaja']), 'utf-8');

            $centavos = explode(".", number_format( $contrato['costoCaja'],2, '.', ','))[1];

            ?> PESOS <?=$centavos?>/100 M.N.)</li>
        <li><?php
            if(!$contrato['depositoGarantia']) $contrato['depositoGarantia']=0;
            echo "Depósito en garantía: ".number_format( $contrato['depositoGarantia'],2, '.', ','); ?> M.N. (<?php
            //si esta linea marca error: agregar a php.ini la siguiente linea: extension=ext/php_intl.dll
            $f = new \NumberFormatter("es_MX", NumberFormatter::SPELLOUT);
            echo mb_strtoupper($f->format((int)$contrato['depositoGarantia']), 'utf-8');

            $centavos = explode(".", number_format( $contrato['depositoGarantia'],2, '.', ','))[1];

            ?> PESOS <?=$centavos?>/100 M.N.)</li>
        <?php
        if($contrato['costoAnual'])
        {
            echo "<li>Seguro: " . number_format($contrato['costoAnual'], 2, '.', ','); ?> M.N. (<?php
            //si esta linea marca error: agregar a php.ini la siguiente linea: extension=ext/php_intl.dll
            $f = new \NumberFormatter("es_MX", NumberFormatter::SPELLOUT);
            echo mb_strtoupper($f->format((int)$contrato['costoAnual']), 'utf-8');
            $centavos = explode(".", number_format($contrato['costoAnual'], 2, '.', ','))[1];
            ?> PESOS <?= $centavos ?>/100 M.N.)
        <?php
            echo "</li>";
        }
        ?>
        <li><?php
            $costoTotal=(int)$contrato['costoAnual']+(int)$contrato['depositoGarantia']+(int)$contrato['costoCaja'];
            echo "Total: ".number_format( $costoTotal,2, '.', ','); ?> M.N. (<?php
            //si esta linea marca error: agregar a php.ini la siguiente linea: extension=ext/php_intl.dll
            $f = new \NumberFormatter("es_MX", NumberFormatter::SPELLOUT);
            echo mb_strtoupper($f->format($costoTotal), 'utf-8');

            $centavos = explode(".", number_format( $costoTotal,2, '.', ','))[1];

            ?> PESOS <?=$centavos?>/100 M.N.)</li>
    </ol>
<p>Forma de pago: <?php
    if($contrato['formaPago']==1)
        echo "Efectivo";
    else if($contrato['formaPago']==2)
        echo "Transferencia";
    else if($contrato['formaPago']==3)
        echo "Tarjeta";
    ?></p>
<table>
    <thead>
    <tr>
        <th>Vigencía</th>
        <th>Fecha de inicio</th>
        <th>Fecha de termino</th>
    </tr>

    </thead>
    <tbody>
    <?php
    //Esta linea solo funciona en windows
    setlocale(LC_TIME, 'esp');
    //Si el servidor no soporta el locale 'esp' tratar con la siguiente linea:
    setlocale(LC_TIME, 'es_MX');
    //Si sigue marcando mal el locale, investigar los locales soportados por el sistema operativo del servidor
    foreach ($historialesRenovacion as $historial)
    {

        $fechaInicio=strtotime($historial['fechaInicio']);
        $fechaFin=strtotime($historial['fechaFin']);
        $seconds = $fechaFin-$fechaInicio;
        $days = floor($seconds / 86400);
        if($days==1)
            $days=$days." día";
        else
            $days=$days." días";


        echo "<tr><td>".$days."</td><td>".$historial['fechaInicio']."</td><td>".$historial['fechaFin']."</td></tr>";


    }
    ?>
    </tbody>
</table>


<p>Personas autorizadas en caso de invalidez o fallecimiento: </p>
<label align="center" style="font-size: small"><?=$datosSucursal['nombreMunicipio']?>, <?=$datosSucursal['nombreEstado']?> a <?php
    $date = DateTime::createFromFormat("Y-m-d", $contrato['fechaRegistro']);
    $mes=strftime("%B",$date->getTimestamp());
    $dia=strftime("%d",$date->getTimestamp());
    $anio=strftime("%Y",$date->getTimestamp());
    print "$dia de $mes de $anio";
    ?></label>

<div>
    <table>
        <thead>
        <tr>
			<!--<th align="center">Nombre de la persona autorizada</th>-->
            <th align="center">Nombre del beneficiario</th>
            <th align="center">Fecha de nacimiento</th>
            <th align="center">Teléfono</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($beneficiarios as $beneficiario)
        {
            print "     <tr>
                    <td>".$beneficiario['nombreBeneficiario']."</td>
                    <td>".$beneficiario['fechaNacimiento']."</td>
                    <td>".$beneficiario['telefono']."</td>
                </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<div>
    <table >
        <tbody>
        <tr>
            <td align="center"><br><br><br>_________________________<br>"EL CLIENTE"<br><br>_________________________<br>"CO-TITULAR"</td>
            <td align="center"><br><br><br><br><br>_________________________<br>"GLOBAL-SHIELD"<br>por medio de su representante legal</td>
        </tr>
        </tbody>
    </table>
</div>