<style>
    /*Estilo que se necesita debido a que el swal suele aparecer detras de
    los modales de materialize. No siempre pasa, pero es molesto*/
    .swal2-container {
        z-index: 10000;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Edición del contrato</h4>
        </div>
        <div class="row" align="center">
            <div class="col s12 m4 offset-m4">
                <a class='btn waves-light waves-effect '  onclick="loadUrl('CrudContrato/')">Regresar</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <form id="formContrato" autocomplete="off">
                    <input id="idContrato" name="idContrato" value="<?=$idContrato?>" type="hidden">
                    <input id="titularRegistrado" name="titularRegistrado" type="hidden">
                    <input id="numeroCotitulares" name="numeroCotitulares" type="hidden">
                    <input id="numeroBeneficiarios" name="numeroBeneficiarios" type="hidden">
                    <input id="numeroTarjeta" name="numeroTarjeta" type="hidden">
                    <input id="numeroTarjetasAnteriores" name="numeroTarjetasAnteriores" type="hidden">

                    <ul class="collapsible popout" data-collapsible = "expandable">
                        <!--Acordeón del titular-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">person</i>Titular
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col s12 m4 input-field">
                                        <input id="idTitular0" name="idTitular0" type="hidden" onchange="getDatosTitular(0)" required>
                                        <input id="idTipoTitular0" name="idTipoTitular0" type="hidden" required>

                                        <input id="titular0" name="titular0" type="text" class="autocomplete-clientes" autocomplete-target="idTitular0" required>
                                        <label class="active" for="titular0">Titular</label>
                                    </div>
                                    <?php
                                    if($permisos['alta']) {
                                        ?>
                                        <div class="col s12 m1 input-field">
                                            <a onclick="abrirRegistroCliente(0)"
                                               class="btn small btn-small waves-effect waves-light"><i
                                                        class="material-icons">group_add</i></a>
                                        </div>
                                        <?php
                                    }
                                    if($permisos['editar']) {

                                        ?>
                                        <div class="col s12 right">
                                            <a onclick="abrirModalTitular(0)"
                                               class="btn waves-light waves-effect right">Editar</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
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

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 center">
                                        <a class="btn waves-effect waves-effect" onclick="agregarCotitular()">Agregar</a>
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
                                        <select id="idSucursal" onchange="cambiarFormularioContrato()" name="idSucursal" disabled  required>

                                            <?php
                                            foreach ($sucursales as $sucursal)
                                            {
                                                print "<option value='".$sucursal['idSucursal']."'>".$sucursal['nombreSucursal']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <label class="not-active" for="idSucursal">Sucursal</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idMembresia" name="idMembresia" onchange="cargarCajasMembresia();" disabled  required>
                                            <option value="">Seleccione una opción</option>
                                            <?php
                                            foreach ($membresias as $membresia)
                                            {
                                                print "<option value='".$membresia['idMembresia']."'>".$membresia['nombreMembresia']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <label class="not-active" for="idMembresia">Membresía</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idTipoCajaContrato" name="idTipoCajaContrato" disabled  onchange="cargarPeriodos();">
                                            <option value="">Seleccione una opción</option>
                                        </select>
                                        <label class="not-active" for="idTipoCajaContrato">Tipo de caja</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idPeriodo" name="idPeriodo" disabled onchange="cargarCosto()" required>
                                            <option value="">Seleccione una opción</option>
                                        </select>
                                        <label class="not-active" for="idPeriodo">Vigencia</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m3 input-field">
                                        <input readonly id="costoContrato" name="costoContrato" required>
                                        <label class="active" for="costoContrato">Costo (MXN)</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <input id="depositoGarantia" name="depositoGarantia" type="number" required>
                                        <label class="active" for="depositoGarantia">Depósito en garantía (MXN)</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="idSeguro" name="idSeguro" required>
                                            <?php
                                            foreach ($seguros as $seguro)
                                            {
                                                print "<option value='".$seguro['idSeguro']."'>Hasta $".$seguro['proteccion']." (USD) por ".$seguro['costoAnual']."(MXN)</option>";
                                            }
                                            ?>
                                        </select>
                                        <label class="not-active" for="idSeguro">Seguro adicional</label>
                                    </div>
                                    <div class="col s12 m3 input-field">
                                        <select id="formaPago" name="formaPago" required>
                                            <option <?php if($contrato['formaPago']==1) echo "selected"; ?> value="1">Efectivo</option>
                                            <option <?php if($contrato['formaPago']==2) echo "selected"; ?> value="2">Transferencia</option>
                                            <option <?php if($contrato['formaPago']==3) echo "selected"; ?> value="3">Tarjeta</option>
                                        </select>
                                        <label class="not-active" for="formaPago">Forma de pago</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" align="center">
                                        <a class="btn waves-effect waves-light" onclick="abrirModalSeleccionCaja()">Mapa de cajas</a>
                                        <input type="hidden" id="cajaSeleccionada" name="cajaSeleccionada" value="<?=$mundoCaja['idMundoCaja']?>" required>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón del contrato-->
                        <!--Acordeón de Tarjetas-->
                        <?php
                        if(!empty($permisosTarjetas['mostrar'])) {
                            ?>
                            <li>
                                <div class="collapsible-header">
                                    <i class="material-icons">card_membership</i>Tarjetas
                                    <div class="col s7 m3">
                                        <label for="FolioFacturacion" class="folioFacturaTarjeta" hidden>
                                            <h6>
                                                <?php
                                                $idU=$_SESSION['idUser'];
                                                $fechaRegistro=date("Y-m-d");
                                                echo "Facturación: " . str_replace("-", "", $fechaRegistro) . "-" . $idU . "-" . $FolioFT;
                                                print "<input name='nuevoFolioFacturacion' value='" . str_replace("-", "", $fechaRegistro) . "-" . $idU . "-" . $FolioFT . "' type='hidden'>";
                                                ?>
                                            </h6>
                                        </label>
                                    </div>
                                </div>
                                <div class="collapsible-body">
                                    <div class="row">
                                        <div class="card-panel col s12" id="Tarjetas">

                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($permisosTarjetas['alta'])) {
                                        ?>
                                        <div class="row">
                                            <div class="col s12" align="center">
                                                <a class="btn waves-light waves-effect" onclick="agregarTarjetas()">Agregar</a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                        <!--Fin del Acordeón de tarjetas-->
                        <!--Acordeón de beneficiarios-->
                        <li>
                            <div class="collapsible-header">
                                <i class="material-icons">account_box</i>Personas autorizadas en caso de invalidez o fallecimiento
                            </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="card-panel col s12" id="beneficiarios">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" align="center">
                                        <a class="btn waves-light waves-effect" onclick="agregarBeneficiario()">Agregar</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--Fin del Acordeón del contrato-->
                    </ul>
                    <div class="row">
                        <div class="col s6 offset-s3 m12">
                            <button type="submit" class='right btn waves-light waves-effect'>Guardar <i class="material-icons right">send</i></button>
                        </div>
                    </div>
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
                <select id="idPasillo" name="idPasillo" onchange="cargarCajasPasillo();">
                    <option value="">Seleccione un pasillo</option>
                </select>
                <label  class="not-active" for="idPasillo">Pasillo</label>
            </div>
            <div class="row col s12" id="contenedorCajas"></div>
        </div>
    </div>
</div>
<script>
    var numeroTitulares=1;
    var idSucursal=parseInt('<?=$mundoCaja['idSucursal']?>');
    var numeroBeneficiarios=0;
    var numeroTarjeta=0;
    var dataAutoCompleteClientes=[<?php foreach ($clientes as $cliente) { print "{id: ".$cliente['idClienteExterno'].", text: '".$cliente['nombreCliente']."'}, "; } ?>];
    $(document).ready(function () {
        $('.collapsible').collapsible({
            accordion: false
        });
        $( ".autocomplete-clientes" ).autocomplete2({
            data: dataAutoCompleteClientes
        });

        $(".modal").modal();
        $("select").material_select();

        cargaDatos();

    });
    function cambiarFormularioContrato()
    {
        if($("#idSucursal").val()==idSucursal)
        {
            return;
        }
        $("#cajaSeleccionada").val('');
        idSucursal=$("#idSucursal").val();
    }
    function cargaDatos()
    {
        cargarTitular();
        cargarCotitulares();
        cargarContrato();
        cargarBeneficiarios();
        <?php
        if($permisosTarjetas['mostrar'])
        {
        ?>
        cargarTarjetas();
        <?php
        }
        ?>
    }
    function agregarActive()
    {
        $("label").addClass("active");
        $(".not-active").removeClass("active");

    }
    function cargarContrato()
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getContrato/'.$idContrato)?>',
            dataType: 'JSON',
            success: function (data)
            {
                $("#idSucursal").val(data['idSucursal']);
                $("#idMembresia").val(data['idMembresia']);
                $("#idMembresia").change();
                $("#idTipoCajaContrato").val(data['idCaja']);
                $("#idTipoCajaContrato").change();
                $("#idPeriodo").val(data['idCosto']);
                $("#idSeguro").val(data['idSeguro']);
                if(!data['depositoGarantia']) data['depositoGarantia']=0;
                $("#depositoGarantia").val(data['depositoGarantia']);
                $("#costoContrato").val(data['costoCaja']);
                resetSelects();
                agregarActive();
            }

        });
    }
    function cargarBeneficiarios()
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getBeneficiariosContrato/'.$idContrato)?>',
            dataType: 'JSON',
            success: function (data)
            {
                var numero;
                for (var i=0; i<data.length; i++)
                {
                    numero=agregarBeneficiario();

                    $("#nombreBeneficiario"+numero).val(data[i]['nombreBeneficiario']);
                    $("#fechaNacimientoBeneficiario"+numero).val(data[i]['fechaNacimiento']);
                    $("#telefonoBeneficiario"+numero).val(data[i]['telefono']);

                }
                agregarActive();
            }

        });
    }
    <?php
    if(!empty($permisosTarjetas['mostrar']))
    {
    ?>
    function cargarTarjetas() {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getTarjeta/' . $idContrato)?>',
            dataType: 'JSON',
            success: function (data) {
                var numero;
                for (var i = 0; i < data.length; i++) {
                    numero = agregarTarjetasAnteriores();

                    $("#FolioTarjetaAnterior" + numero).val(data[i]['FolioTarjeta']);
                    if (data[i]['FolioFacturacion']) {
                        $("#cboxAnterior" + numero).prop("checked", true);
                    }
                    else {
                        $("#cboxAnterior" + numero).prop("checked", false);
                    }

                }
                agregarActive();
            }

        });
    }
    <?php
    }
    ?>

    function cargarCotitulares()
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getCotitularesContrato/'.$idContrato)?>',
            dataType: 'JSON',
            success: function (data)
            {
                var numero;
                for (var i=0; i<data.length; i++)
                {
                    numero=agregarCotitular();

                    $("#idTitular"+numero).val(data[i]['idClienteExterno']);
                    $("#titular"+numero).val(data[i]['nombreCliente']);
                    getDatosTitular(numero);
                }
                agregarActive();
            }

        });
    }

    function cargarTitular()
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getDatosTitular/'.$idContrato)?>',
            dataType: 'JSON',
            success: function (data)
            {

                $("#idTitular0").val(data['idClienteExterno']);
                $("#titular0").val(data['nombreCliente']);
                getDatosTitular(0);
                agregarActive();
            }

        });
    }

    $("#formContrato").submit(function (e)
    {
        e.preventDefault();
        if(!validarFoliosTarjetas())
        {
            return;
        }
        if(!$("#cajaSeleccionada").val())
        {
            swal('Faltan datos!', 'Por favor seleccione una caja', 'warning');
            return;
        }
        $("#numeroCotitulares").val(numeroTitulares);
        $("#numeroBeneficiarios").val(numeroBeneficiarios);
        $("#numeroTarjeta").val(numeroTarjeta);
        $("#numeroTarjetasAnteriores").val(numeroTarjetasAnteriores);
        var form=$(this);
        var url='<?=base_url('index.php/CrudContrato/updateContrato/')?>';
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                swal('¡Exito!', 'Se modificó el contrato!', 'success');
                loadUrl('CrudContrato');

            },
            error: function (jqXHR, status, error) {
                let jsonError=JSON.parse(jqXHR['responseText']);
                try{
                    Swal.fire({
                        title: 'Error',
                        type: 'error',
                        html: jsonError['message'],
                        showCancelButton: false,
                        confirmButtonText: "Aceptar"
                    });
                }
                catch(e)
                {

                }
            }
        });
    });
    function validarFoliosTarjetas() {
        let arrayFolios=[];
        let noRepetido=true;
        $( ".folioTarjeta" ).each(function( index ) {
            if(arrayFolios[$(this).val()])
            {
                Swal.fire({
                    title: 'Error',
                    type: 'warning',
                    html: 'Los folios de las tarjetas deben ser únicos',
                    confirmButtonText: 'Aceptar',
                    showCancelButton: false
                });
                noRepetido=false;
                return;
            }
            else
            {
                arrayFolios[$(this).val()]=1;
            }
        });
        return noRepetido;
    }
    function guardarContrato()
    {
        $("#formContrato").submit();
    }

    function seleccionarCaja(elemento, idMundoCaja, claseAnterior, pasillo, numeroCaja)
    {
        var cajaSeleccionada="yellow accent-3";
        //Quita la clase cajaSeleccionada de todas las cajas
        $(".disponibles").attr("class", "card disponibles "+claseAnterior);
        $(elemento).removeClass("yellow accent-3");
        $(elemento).removeClass(claseAnterior);

        $(elemento).addClass(cajaSeleccionada);

        Swal.fire({
            title: '¿Seleccionar la caja?',
            text: "Se seleccionará la caja "+pasillo+"-"+numeroCaja,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si, apartar caja',
            cancelButtonText: 'Cancelar',
        }).then((result) =>
        {
            if (result.value)
            {
                $("#cajaSeleccionada").val(idMundoCaja);
                swal("Bien!", "Se seleccionó la caja "+pasillo+"-"+numeroCaja, 'success');
                $(".modal").modal('close');
                cajaCambiada=1;
            }
        })

    }
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
                var status, statusReparacion;
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
                    statusReparacion=data[i]['statusReparacion'];
                    //status disponible
                    if(status==0)
                    {
                        colorClass="light green disponibles";
                        attrOnClick="onClick='seleccionarCaja(this, "+idMundoCaja+", \"light green\", \""+pasillo+"\", "+numeroCaja+")'";
                        text="Disponible";
                    }
                    else
                    {
                        colorClass="red";
                        attrOnClick="";
                        text="Ocupada";
                    }
                    if(statusReparacion==1)
                    {
                        colorClass="orange darken-1";
                        attrOnClick="";
                        text="Mantenimiento";
                    }
                    if(cajaCambiada==0&&idMundoCaja==<?=$mundoCaja['idMundoCaja']?>)
                    {
                        colorClass="yellow accent-3 disponibles";
                        attrOnClick="";
                        text="Seleccionada";
                    }
                    /*
                    * Ocupada: Class="card red"
                    * Disponible: Class="card light green"
                    * Seleccionada: Class="card yellow accent-3"
                    * Matenimiento: Class="card orange darken-1"
                    * */

                    $("#contenedorCajas").append(' '+
                        '' +
                        '  <div class="center-align center">' +
                        '    <div class="col s12 m3">' +
                        '      <div '+attrOnClick+' class="card '+colorClass+'" style="cursor: pointer;">' +
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
    var cajaCambiada=0;
    function abrirModalSeleccionCaja()
    {
        if($("#idMembresia").val()&&$("#idTipoCajaContrato").val()&&$("#idPeriodo").val()&&$("#costoContrato").val()&&$("#depositoGarantia").val()&&$("#idTitular0").val())
        {
            let idSucursal=$("#idSucursal").val();
            let idTipoCaja=$("#idTipoCajaContrato").val();

            $.ajax({
                url: '<?=base_url('index.php/CrudContrato/getPasillos/')?>'+idSucursal+'/'+idTipoCaja,
                dataType: 'JSON',
                success: function (data) {
                    $("#idPasillo").empty();
                    $("#idPasillo").append("<option>Seleccione un pasillo</option>");
                    $("#contenedorCajas").empty();
                    for(var i=0; i<data.length; i++)
                    {
                        $("#idPasillo").append("<option value='"+data[i]['pasillo']+"'>"+data[i]['pasillo']+"</option>");

                    }
                    if(cajaCambiada==0)
                    {
                        $("#idPasillo").val('<?=$mundoCaja['pasillo']?>');
                        $("#idPasillo").change();
                    }
                    resetSelects();
                    $("#modalSeleccionCaja").modal('open');
                }
            });

        }
        else
        {
            swal('Error', 'Llena todos los campos antes de seguir', 'error');
        }

    }
    function cargarCosto()
    {
        var idCosto=$("#idPeriodo").val();
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/cargarCosto/')?>'+idCosto,
            dataType: 'JSON',
            success: function (data)
            {
                $("#costoContrato").val(data['costo']);
            }
        });
    }
    function cargarCajasMembresia()
    {
        var idMembresia=$("#idMembresia").val();
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/cargarCajaMembresia/')?>'+idMembresia,
            dataType: 'JSON',
            async: false,
            success: function (data)
            {

                $("#idTipoCajaContrato").empty();
                $("#costoContrato").empty();
                $("#idPeriodo").empty();
                $("#idTipoCajaContrato").append('<option>Seleccione una caja</option>');
                for(var i=0; i<data.length; i++)
                {
                    $("#idTipoCajaContrato").append("<option value='"+data[i]['idCaja']+"'>"+data[i]['nombreCaja']+"</option>");

                }
                resetSelects();
            }
        });
    }
    function cargarPeriodos()
    {
        var idMembresia=$("#idMembresia").val();
        var idTipoCaja=$("#idTipoCajaContrato").val();
        $("#costoContrato").empty();

        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getPeriodos/')?>'+idMembresia+'/'+idTipoCaja,
            dataType: 'JSON',
            async: false,
            success: function (data)
            {
                $("#idPeriodo").empty();
                $("#idPeriodo").append("<option>Seleccione un periodo</option>");
                for (var i=0; i<data.length; i++)
                {
                    var nombrePeriodo="";
                    if(data[i]['numeroAnios']>0)
                    {
                        nombrePeriodo+=data[i]['numeroAnios']+" año (s) ";
                        if(data[i]['numeroMeses']!='0')
                            nombrePeriodo+=", ";
                    }
                    if(data[i]['numeroMeses']!='0')
                    {
                        nombrePeriodo+=data[i]['numeroMeses']+" meses ";
                        if(data[i]['numeroDias']!='0')
                            nombrePeriodo+=", ";
                    }
                    if(data[i]['numeroDias']!='0')
                    {
                        nombrePeriodo+=data[i]['numeroDias']+" días";
                    }
                    $("#idPeriodo").append("<option value='"+data[i]['idCosto']+"'>"+nombrePeriodo+"</option>");
                }
                resetSelects();
            }
        });
    }
    var contadorTarjetas=1;

    function contarTarjetas()
    {
        var contador = 1;
        $('.checkboxTarjeta').not('.anterior').prop("checked", false);
        $(".folioFacturaTarjeta").hide();

        $( ".labelTarjeta" ).each(function( index ) {
            $(this ).html(contador++);
            // console.log (index);
        });

        $( ".checkboxTarjeta" ).each(function( index ) {
            if (index > 1)
            {
                if(!$(this ).prop("disabled"))
                {
                    $(this ).prop("checked", true);
                    $(".folioFacturaTarjeta").show();
                }

            }
            // console.log (index);
        });
    }
    function verFolioFacturacion(elemento) {
        if($(elemento).prop("checked"))
            $(".folioFacturaTarjeta").show();
    }
    function agregarTarjetas()
    {
        $("#Tarjetas").append(' ' +
            '<div class="row valign-wrapper" id="tarjeta'+numeroTarjeta+'" align="center">' +
            '   <div class="col s1 m1">' +
            '       <label for="contador'+numeroTarjeta+'"><h5 class="labelTarjeta">'+(contadorTarjetas++)+'</h5></label>' +
            '   </div>' +
            '   <div class="col s1 m1">' +
            '       <input id="cbox'+numeroTarjeta+'" name="cbox'+numeroTarjeta+'" type="checkbox" onchange="verFolioFacturacion(this)" class="filled-in checkboxTarjeta">' +
            '       <label for="cbox'+numeroTarjeta+'"></label>' +
            '   </div>' +
            '   <div class="col s12 m3 input-field">' +
            '       <input class="folioTarjeta" id="Folio'+numeroTarjeta+'" name="Folio'+numeroTarjeta+'" type="text" required>' +
            '       <label for="Folio'+numeroTarjeta+'" class="active">Folio</label>' +
            '   </div>' +
            '   <div class="col s6 m2 offset-s2 input-field">' +
            '       <a onclick="eliminarTarjeta('+numeroTarjeta+')" class="btn waves-light waves-effect right"><i class="material-icons">delete</i></a>' +
            '   </div>' +
            '</div>');
        var numero=numeroTarjeta++;
        contarTarjetas();
        return numero;
    }
    var numeroTarjetasAnteriores=0;
    <?php
    if(!empty($permisosTarjetas['mostrar']))
    {
    ?>
    function agregarTarjetasAnteriores() {
        $("#Tarjetas").append(' ' +
            '<div class="row valign-wrapper" id="tarjetaAnterior' + numeroTarjetasAnteriores + '" align="center">' +
            '   <div class="col s1 m1">' +
            '       <label><h5 id="idLabelTarjetaAnterior' + numeroTarjetasAnteriores + '" class="labelTarjeta">' + (contadorTarjetas++) + '</h5></label>' +
            '   </div>' +
            '   <div class="col s1 m1">' +
            '       <input id="cboxAnterior' + numeroTarjetasAnteriores + '" name="cboxAnterior' + numeroTarjetasAnteriores + '" type="checkbox" class="filled-in checkboxTarjeta anterior" disabled>' +
            '       <label for="cboxAnterior' + numeroTarjetasAnteriores + '"></label>' +
            '   </div>' +
            '   <div class="col s12 m3 input-field">' +
            '       <input class="folioTarjeta" id="FolioTarjetaAnterior' + numeroTarjetasAnteriores + '" name="FolioTarjetaAnterior' + numeroTarjetasAnteriores + '" type="text" readonly required>' +
            '       <input id="tarjetaAnteriorActiva' + numeroTarjetasAnteriores + '" name="tarjetaAnteriorActiva' + numeroTarjetasAnteriores + '" type="hidden" readonly value="1" required>' +
            '       <label for="FolioTarjetaAnterior' + numeroTarjetasAnteriores + '" class="active">Folio</label>' +
            '   </div>' +
            '   <div class="col s6 m2 offset-s2 input-field">' +
            <?php
            if(!empty($permisosTarjetas['eliminar']))
            {
            ?>
            '       <a onclick="eliminarTarjetaAnterior(' + numeroTarjetasAnteriores + ')" class="btn waves-light waves-effect right"><i class="material-icons">delete</i></a>' +
            <?php
            }
            ?>
            '   </div>' +
            '</div>');
        var numero = numeroTarjetasAnteriores++;
        contarTarjetas();
        return numero;
    }
    <?php
    }
    ?>
    function eliminarTarjeta(numeroTarjeta) {
        $("#tarjeta"+numeroTarjeta).remove();
        contarTarjetas();
    }
    <?php
    if(!empty($permisosTarjetas['eliminar']))
    {
    ?>
    function eliminarTarjetaAnterior(numeroTarjeta) {
        Swal.fire({
            title: '¡Advertencia!',
            type: 'warning',
            html: '<p>Esta tarjeta se eliminará incluso si no guardas cambios. <br>Esta acción no se podrá revertir. ¿Continuar?</p>',
            confirmButtonText: 'Eliminar del sistema',
            cancelButtonText: 'Cancelar',
            showCancelButton: true

        }).then(function (result) {
            if (result.value) {
                //TODO: MANDAR A ELIMINAR ESTA TARJETA
                $.ajax({
                    url: '<?=base_url('index.php/CrudContrato/eliminarTarjetaContrato')?>',
                    type: 'POST',
                    data: {folioTarjeta: $("#FolioTarjetaAnterior" + numeroTarjeta).val()},
                    success: function (data) {

                    }
                });

                $("#tarjetaAnterior" + numeroTarjeta).remove();
                //$("#tarjetaAnterior"+numeroTarjeta).hide();
                //$("#cboxAnterior"+numeroTarjeta).removeClass("checkboxTarjeta");
                //$("#tarjetaAnteriorActiva"+numeroTarjeta).val("0");
                //$("#idLabelTarjetaAnterior"+numeroTarjeta).removeClass("labelTarjeta");


                contarTarjetas();
            }
        });

    }
    <?php
    }
    ?>
    function agregarBeneficiario()
    {
        $("#beneficiarios").append(' ' +
            '<div class="row" id="beneficiario'+numeroBeneficiarios+'" align="center">' +
            '   <div class="col offset-m1 s12 m3 input-field">' +
            '       <input id="nombreBeneficiario'+numeroBeneficiarios+'" name="nombreBeneficiario'+numeroBeneficiarios+'" type="text" required>' +
            '       <label for="nombreBeneficiario'+numeroBeneficiarios+'">Beneficiario</label>' +
            '   </div>' +
            '   <div class="col s12 m3 input-field">' +
            '       <input id="fechaNacimientoBeneficiario'+numeroBeneficiarios+'" name="fechaNacimientoBeneficiario'+numeroBeneficiarios+'" type="date" max="<?php echo date('Y-m-d', strtotime("-18 year", strtotime(date("y-m-d")))); ?>"  required>' +
            '       <label for="fechaNacimientoBeneficiario'+numeroBeneficiarios+'" class="active">Fecha de nacimiento</label>' +
            '   </div>' +
            '   <div class="col s12 m3 input-field">' +
            '       <input id="telefonoBeneficiario'+numeroBeneficiarios+'" name="telefonoBeneficiario'+numeroBeneficiarios+'" type="tel" required>' +
            '       <label for="telefonoBeneficiario'+numeroBeneficiarios+'">Teléfono</label>' +
            '   </div>' +
            '   <div class="col s6 m2 offset-s2 input-field">' +
            '       <a onclick="eliminarBeneficiario('+numeroBeneficiarios+')" class="btn waves-light waves-effect right"><i class="material-icons">delete</i></a>' +
            '   </div>' +
            '</div>');
        var numero=numeroBeneficiarios;
        numeroBeneficiarios++;
        return numero;
    }
    function eliminarBeneficiario(numeroBeneficiario) {
        $("#beneficiario"+numeroBeneficiario).remove();
    }
    function agregarCotitular()
    {
        $("#cotitulares").append(' ' +
            '<div class="row" id="cotitular'+numeroTitulares+'" align="center">' +
            '   <div class="col offset-m1 s12 m4 input-field">' +
            '       <input id="idTitular'+numeroTitulares+'" name="idTitular'+numeroTitulares+'" type="hidden" onchange="getDatosTitular('+numeroTitulares+')" required>' +
            '       <input id="idTipoTitular'+numeroTitulares+'" name="idTipoTitular'+numeroTitulares+'" type="hidden" required>' +
            '       <input id="titular'+numeroTitulares+'" name="titular'+numeroTitulares+'" type="text" class="autocomplete-clientes" autocomplete-target="idTitular'+numeroTitulares+'" required>' +
            '       <label for="titular'+numeroTitulares+'">Cotitular</label>' +
            '   </div>' + <?php if($permisos['alta']) { ?>
            '   <div class="col s12 m2 input-field">' +
            '       <a onclick="abrirRegistroCotitular('+numeroTitulares+')" class="btn small btn-small waves-effect waves-light"><i class="material-icons">group_add</i></a>' +
            '   </div>' + <?php } if($permisos['editar']) { ?>
            '   <div class="col s12 m2 input-field">' +
            '       <a onclick="abrirModalTitular('+numeroTitulares+')" class="btn waves-light waves-effect right"><i class="material-icons">edit</i></a>' +
            '   </div>' + <?php } ?>
            '   <div class="col s12 m2 input-field">' +
            '       <a onclick="eliminarTitular('+numeroTitulares+')" class="btn waves-light waves-effect right"><i class="material-icons">delete</i></a>' +
            '   </div>' +
            '</div>');
        $( "#titular"+numeroTitulares).autocomplete2({
            data: dataAutoCompleteClientes
        });
        var numero=numeroTitulares;
        numeroTitulares++;
        return numero;

    }
    function getDatosTitular(numeroTitular)
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/getTipoCliente/')?>',
            type: 'POST',
            data: {idClienteExterno: $("#idTitular"+numeroTitular).val()},
            success: function (data)
            {
                $("#idTipoTitular"+numeroTitular).val(data);
            }
        });
    }
    function abrirModalTitular(numeroTitular) {
        if($("#idTitular"+numeroTitular).val()&&$("#idTipoTitular"+numeroTitular).val())
        {

            $.ajax({
                url: '<?=base_url('index.php/CrudClienteExterno/editarClienteExternoModal/')?>'+$("#idTitular"+numeroTitular).val()+'/'+$("#idTipoTitular"+numeroTitular).val(),
                success:function (data)
                {
                    $("#titularRegistrado").val(numeroTitular);
                    $("#datosClienteExternoTitular").html(data);
                    $("#modalAuxiliar").modal('open');
                }
            });

        }
    }
    function eliminarTitular(numeroTitular)
    {
        $("#cotitular"+numeroTitular).remove();
    }
    function abrirRegistroCliente(numeroTitular)
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/formAltaClienteModal/')?>',
            dataType: 'HTML',
            success: function (data)
            {
                $("#titularRegistrado").val(numeroTitular);
                $("#datosClienteExternoTitular").html(data);
                $("#modalAuxiliar").modal('open');
            }
        });

    }
    //Esta función sirve para agregar el cotitular del contrato. Se para un 0 para indicar que no es un registro de titular
    function abrirRegistroCotitular(numeroTitular) {
        $.ajax({
            url: '<?=base_url('index.php/CrudClienteExterno/formAltaClienteModal/0')?>',
            dataType: 'HTML',
            success: function (data) {
                $("#titularRegistrado").val(numeroTitular);
                $("#datosClienteExternoTitular").html(data);
                $("#modalAuxiliar").modal('open');
            }
        });

    }
    function registrarClienteAutocomplete(idUsuario, nombreUsuario)
    {
        var numeroTitular=$("#titularRegistrado").val();
        $("#idTitular"+numeroTitular).val(idUsuario);
        $("#titular"+numeroTitular).val(nombreUsuario);
        $("#idTitular"+numeroTitular).trigger("change");
        actualizarAutocomplete();
    }
    function editarClienteAutocomplete(idUsuario, nombreUsuario) {
        var numeroTitular=$("#titularRegistrado").val();
        $("#idTitular"+numeroTitular).val(idUsuario);
        $("#titular"+numeroTitular).val(nombreUsuario);
        $("#idTitular"+numeroTitular).trigger("change");
        actualizarAutocomplete();
    }
    function actualizarAutocomplete()
    {
        $.ajax({
            url: '<?=base_url('index.php/CrudContrato/actualizarAutocomplete/')?>',
            dataType:'JSON',
            success: function (data) {
                var nuevoAutocomplete = [];
                for (var i = 0; i < data.length; i++)
                {
                    nuevoAutocomplete.push({
                        id: data[i]['idClienteExterno'],
                        text: data[i]['nombreCliente']
                    })
                }
                dataAutoCompleteClientes=nuevoAutocomplete;
                //Limpia y actualiza

                //$("#autocomplete-clientes").val(nombreSeleccionado);
                $(".autocomplete-content").remove();
                $( ".autocomplete-clientes" ).autocomplete2({
                    data: nuevoAutocomplete
                });

            }
        });
    }

    function resetSelects() {
        $("select").material_select();
    }
</script>



 
    




