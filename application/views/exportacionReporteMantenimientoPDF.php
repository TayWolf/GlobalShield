<!-- 
1. Información(consulta de cajas en manyenimiento que puede ver el usuario) de php
2. Generar los encabezados de la tabla
3. Dar estilo a la tabla
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?=base_url('assets/')?>css/custom/custom.css" type="text/css" rel="stylesheet">
    <title>Reporte de Cajas en Mantenimiento</title>
    
    <style>
    body {
        height: 100%;
    }
    table {     
        margin: 450px;     
        width: 100%; 
        text-align: center;    
        border-collapse: collapse; 
    }
    table th {
        background-color: #1E4FB3;
        border-left: 1px solid #1E4FB3; 
        border-right: 1px solid #1E4FB3; 
        border-top: 1px solid #1E4FB3; 
        text-align: center;
        font-size: 1em;
        color: #fff; 
    }
    table td {
        text-align: center;
        font-size: 1em;
        border-left: 1px solid #111111; 
        border-right: 1px solid #111111; 
        border-top: 1px solid #111111; 
        border-bottom: 1px solid #111111; 
    }
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
    h1{
        text-align: center;
        background: #223E8E;
        font-size: 2em;
        font-family: fantasy;
    }
    </style>
</head>
<body>
    

    <label class="centrado" style="min-width: 100% !important; line-height: 0">
        <div class="centrado">
            <img width="150px" height="50px" src="<?=base_url('assets/globalShield.png')?>">
        </div>
        <br class="espacioExtraPequeñoLabel">
        <b class="letraGrande centrado">BÓVEDAS MULTIBLINDADAS S.A. DE C.V.</b>
        <br class="espacioPequeño">
        <br class="espacioPequeño">     
        <b class="letraMediana" align="right">FECHA DEL REPORTE: <?=date("Y-m-d")?></b>
    </label>
    <h1>Cajas en mantenimiento</h1>
     
     <div style="overflow-x:auto;">
                 
        <table cellpadding="8" >
            <thead>
                <tr>
                    <th style="width: 20%"><strong>Sucursal</strong></th>
                    <th style="width: 6%"><strong>Caja</strong></th>
                    <th style="width: 14%"><strong>Tipo de caja</strong></th>
                    <th style="width: 43%"><strong>Motivo</strong></th>
                    <th style="width: 17%"><strong>Fecha de Solicitud</strong></th>
                </tr>
            </thead>
            <tbody class="celda">
                <?php
                    foreach ($cajasMantenimiento as $caja) 
                    {
                        $sucursal =$caja['nombreSucursal'];
                        $pasillo  =$caja['pasillo'];
                        $numCaja  =$caja['numeroCaja'];
                        $tipoCaja =$caja['nombreCaja'];
                        $motivo   =$caja['motivo'];
                        $fechaSol =$caja['fechaSolicitud'];

                        echo "  <tr>
                            <td style=\"width: 20%\">$sucursal</td>
                            <td style=\"width: 6%\">$pasillo - $numCaja</td>
                            <td style=\"width: 14%\">$tipoCaja</td>
                            <td style=\"width: 43%\">$motivo</td>
                            <td style=\"width: 17%\">$fechaSol</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
     </div>   
</body>
</html>
