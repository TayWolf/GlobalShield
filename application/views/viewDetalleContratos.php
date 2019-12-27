
<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Detalles del contrato</h4>
        </div>
        <div class="row" align="center">
            <div class="col s12 m4 offset-m4">
                <a class='btn waves-light waves-effect '  onclick="loadUrl('CrudContrato/')">Regresar</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <form autocomplete="off">
                    <ul class="collapsible popout" data-collapsible = "expandable">
                        <!--Acordeón del titular-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">person</i>Titular
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col s12 m4 input-field">
                                        <input id="titular0" name="titular0" type="text" class="autocomplete-clientes" value="<?=$contrato['nombreCliente']?>" required>
                                        <label class="active" for="titular0">Titular</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón del titular-->
                        <!--Acordeón del cotitular-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">person_outline</i>Cotitular
                            </div>
                            <div class="collapsible-body" id="cotitularesCollapsible">
                                <div class="row" >
                                    <div class="col offset-m2 s12 m10 card-panel" id="cotitulares">
                                        <?php
                                        foreach ($cotitulares as $cotitular)
                                        {
                                            print "<div class=\"col s12 input-field\">
                                                   <input class=\"autocomplete-clientes\" value='".$cotitular['nombreCliente']."' required>
                                                   <label class='active'>Cotitular</label>
                                               </div>";

                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <!--Fin del Acordeón del cotitular-->
                        <!--Acordeón del contrato-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">description</i>Contrato
                            </div>
                            <div class="collapsible-body" id="contratoCollapsible">
                                <div class="row" >
                                    <div class="col s12 m3 input-field">
                                        <select id="idSucursal" name="idSucursal" required>
                                            <option value="<?=$contrato['idSucursal']?>"><?=$contrato['nombreSucursal']?></option>
                                        </select>
                                        <label for="idSucursal">Sucursal</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select  id="idMembresia" name="idMembresia" onchange="cargarCajasMembresia();" required>
                                            <option value=""><?=$contrato['nombreMembresia']?></option>
                                        </select>
                                        <label  for="idMembresia">Membresía</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idTipoCajaContrato" name="idTipoCajaContrato" onchange="cargarPeriodos();">
                                            <option value="<?=$contrato['idCaja']?>"><?=$contrato['nombreCaja']?></option>
                                        </select>
                                        <label for="idTipoCajaContrato">Tipo de caja</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idPeriodo" name="idPeriodo" onchange="cargarCosto()" required>
                                            <?php
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
                                            print "<option>$nombrePeriodo</option>";
                                            ?>
                                        </select>
                                        <label for="idPeriodo">Vigencia</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m3 input-field">
                                        <input readonly id="costoContrato" name="costoContrato" value="<?=$contrato['costoCaja']?>" required>

                                        <label class="active" for="costoContrato">Costo (MXN)</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <input id="depositoGarantia" name="depositoGarantia" type="number" value="<?=$contrato['depositoGarantia']?>" required>
                                        <label class="active" for="depositoGarantia">Depósito en garantía (MXN)</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idSeguro" name="idSeguro" required>

                                            <?php
                                            if(!empty($contrato['proteccion']))
                                                print "<option>Hasta $".$contrato['proteccion']." (USD) por ".$contrato['costoAnual']."(MXN)</option>";
                                            else
                                                print "<option>N/A</option>";
                                            ?>
                                        </select>
                                        <label for="idSeguro">Seguro adicional</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="formaPago" name="formaPago" required readonly>
                                            <?php
                                            if($contrato['formaPago']==1)
                                                print "<option>Efectivo</option>";
                                            else if($contrato['formaPago']==2)
                                                print "<option>Transferencia</option>";
                                            else
                                                print "<option>Tarjeta</option>";

                                            ?>
                                        </select>
                                        <label for="formaPago">Forma de pago</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" align="center">
                                        <a class="btn waves-effect waves-light" onclick="cargarCajasPasillo();abrirModalSeleccionCaja()">Mapa de cajas</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón del contrato-->
                        <!--Acordeón de Tarjetas-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">card_membership</i>Tarjetas
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="card-panel col s12" id="tarjeta">
                                        <?php
                                        $contadorTarjetas=1;
                                        foreach ($tarjetas as $tarjeta)
                                        {
											if($tarjeta['FolioFacturacion']!=null)
												$check='Checked';
											else
												$check='';
											
                                            print '<div class="row valign-wrapper">
                                                    <div class="col s1 m1 offset-m3 offset-s3">
                                                       <label class="active" for="contador"><h5 class="labelTarjeta">'.$contadorTarjetas.'</h5></label>
                                                   </div>
                                                    <div class="col s1 m1">
                                                       <input id="cbox'.$contadorTarjetas.'" name="cbox'.$contadorTarjetas.'" type="checkbox" '.$check.' class="filled-in" disabled>
                                                        <label for="cbox'.$contadorTarjetas.'"></label>
                                                   </div>
                                                    <div class="col s12 m3 input-field">
                                                       <input id="Folio'.$contadorTarjetas.'" name="Folio'.$contadorTarjetas.'" type="text" value="'.$tarjeta['FolioTarjeta'].'">
                                                        <label class="active" for="Folio'.$contadorTarjetas.'">Folio</label>
                                                   </div>
                                                   <div class="col s6 m2 offset-s2 input-field">
                                                    </div>
                                            </div>';
                                            $contadorTarjetas++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón de tarjetas-->
                        <!--Acordeón de beneficiarios-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">account_box</i>Personas autorizadas en caso de invalidez o fallecimiento
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="card-panel col s12" id="beneficiarios">
                                        <?php
                                        foreach ($beneficiarios as $beneficiario)
                                        {
                                            print '<div class="row" id="beneficiario" align="center">
                                               <div class="col s12 m4 input-field">
                                                   <input id="beneficiario" name="beneficiario" type="text" value="'.$beneficiario['nombreBeneficiario'].'" required>
                                                   <label class="active" for="beneficiario">Beneficiario</label>
                                               </div>
                                               <div class="col s12 m4 input-field">
                                                   <input id="fechaNacimientoBeneficiario" name="fechaNacimientoBeneficiario" type="date" value="'.$beneficiario['fechaNacimiento'].'" required>
                                                   <label for="fechaNacimientoBeneficiario" class="active">Fecha de nacimiento</label>
                                               </div>
                                               <div class="col s12 m4 input-field">
                                                   <input id="telefonoBeneficiario" name="telefonoBeneficiario" type="tel" value="'.$beneficiario['telefono'].'" required>
                                                   <label class="active" for="telefonoBeneficiario">Teléfono</label>
                                               </div>
                                            </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón del contrato-->
                    </ul>
                </form>
            </div>
        </div>

    </div>
</div>

<div id="modalAuxiliar" class="modal" style="width: 95% !important; max-height: 85% !important;">
    <div class="modal-content">
        <div class="row" id="datosClienteExternoTitular">

        </div>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>



<div id="modalSeleccionCaja" class="modal">
    <div class="modal-content">
        <div class="row" id="seleccionCaja">
            <div class="col s12 m4 input-field">
                <select id="idPasillo" name="idPasillo" >
                    <option value="<?=$contrato['pasillo']?>"><?=$contrato['pasillo']?></option>
                </select>
                <label for="idPasillo">Pasillo</label>
            </div>
            <div class="row col s12" id="contenedorCajas"></div>
        </div>
    </div>
</div>
<script>

    

    $(document).ready(function () {

        $('.collapsible').collapsible({
            accordion: false
        });
        $(".modal").modal();
        $("input").attr("readonly", "readonly");
        $("select").attr("disabled", "disabled");
        $("select").material_select();
    });


    function cargarCajasPasillo()
    {
        $("#contenedorCajas").empty();
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/cargarCajasPasillo/')?>',
            type: 'POST',
            dataType: 'JSON',
            data: {idSucursal: $("#idSucursal").val(), idTipoCaja: $("#idTipoCajaContrato").val(), idPasillo: $("#idPasillo").val()},
            success: function (data)
            {
                var pasillo;
                var numeroCaja;
                var status;
                var attrOnClick;
                var colorClass;
                var text;
                var idMundoCaja;
                for(var i=0; i<data.length; i++)
                {
                    idMundoCaja=data[i]['idMundoCaja'];
                    pasillo=data[i]['pasillo'];
                    numeroCaja=data[i]['numeroCaja'];
                    status=data[i]['status'];
                    //status disponible
                    if(status==0)
                    {
                        colorClass="light green disponibles";
                        text="Disponible";
                    }
                    else
                    {
                        colorClass="red";
                        text="Ocupada";
                    }
                    if(idMundoCaja==<?=$contrato['idMundoCaja']?>)
                    {
                        text="Seleccionada";
                        colorClass="yellow accent-3";
                    }
                    /*
                    * Ocupada: Class="card red"
                    * Disponible: Class="card light green"
                    * Seleccionada: Class="card yellow accent-3"
                    * */

                    $("#contenedorCajas").append(' '+
                        '' +
                        '  <div class="center-align center">' +
                        '    <div class="col s12 m3">' +
                        '      <div class="card '+colorClass+'" style="cursor: pointer;">' +
                        '        <div class="card-content white-text">' +
                        '          <span class="card-title">'+pasillo+'-'+numeroCaja+'</span>' +
                        '          <p>'+text+'</p>' +
                        '        </div>' +
                        '      </div>' +
                        '    </div>' +
                        '  </div>' +
                        '            ');

                }
                resetSelects();
                $("#modalSeleccionCaja").modal('open');
            }
        });
    }
    function abrirModalSeleccionCaja()
    {
        $("#modalSeleccionCaja").modal('open');
    }
    function resetSelects() {
        $("select").material_select();
    }
</script>



 
    




