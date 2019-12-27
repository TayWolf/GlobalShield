<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="col s11"><h4 class="header">FACTURAS EMITIDAS</h4></div>
        </div>
    </div>
    <?php
    if($permisos['alta'])
    {
        ?>
        <div class="row">
            <div class="col s12 center">
                <a class="btn waves-effect waves-light" onclick="abrirModalBusquedaFolio()">Nueva factura</a>
            </div>
        </div>
        <?php
    }
    if($permisos['mostrar'])
    {
        ?>
        <div class="row">
            <div class="col s12">
                <table class="highlight">
                    <thead>
                    <th>Nombre del cliente</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Descargar PDF</th>
                    <th>Descargar XML</th>
                    <th>Enviar por correo</th>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($facturas as $factura) {
                        $nombre = $factura['nombreCliente'];
                        $folio = $factura['folioFactura'];
                        $fecha = $factura['fecha'];
                        $hora = $factura['hora'];
                        $pdf = $urlCliente . ('/assets/Facturacion/' . $factura['archivoPDF']);
                        $XML = $urlCliente . ('/assets/Facturacion/' . $factura['archivoXML']);

                        print "
                        <tr>
                        <td>$nombre</td>
                        <td>$folio</td>
                        <td>$fecha</td>
                        <td>$hora</td>
                        <td><a download href='$pdf'><i class='material-icons'>picture_as_pdf</i></a></td>
                        <td><a download href='$XML'><i class='material-icons'>code</i></a></td>
                        <td><a style='cursor: pointer' onclick='abrirModalFacturaCorreo($folio)'><i class='material-icons'>email</i></a></td>   
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }?>
</div>
<div id="modalEnvioCorreoFactura" class="modal">
    <form id="formularioFacturaCorreo">
        <input type="hidden" id="folioFacturaCorreo" name="folioFacturaCorreo" >
        <div class="modal-content">
            <h4>Enviar factura por correo</h4>

            <div class="row">

                <div class="input-field col s12">
                    <i class="material-icons prefix">email</i>
                    <input id="emailFactura" name="emailFactura" type="email" class="validate" required>
                    <label for="emailFactura">Correo</label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <input type="submit" value="Enviar" class="modal-action modal-close waves-effect waves-green btn-flat">
        </div>
    </form>
</div>
<div id="modalFactura" class="modal">
    <form id="formularioFactura">
        <div class="modal-content">
            <h4>Facturar por folio</h4>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">search</i>
                    <input id="folioFacturacion" name="folioFacturacion" type="number" class="validate" required>
                    <label for="folioFacturacion">Folio del ticket</label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <input type="submit" value="Facturar" class="modal-action modal-close waves-effect waves-green btn-flat">
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $("table").DataTable({
            language:{
                url: '<?=base_url('assets/i18n/Spanish.json')?>'
            }
        });
        $(".modal").modal();
    });
    function abrirModalFacturaCorreo(folioFactura)
    {
        $("#folioFacturaCorreo").val(folioFactura);
        $("#modalEnvioCorreoFactura").modal('open');
    }
    $("#formularioFacturaCorreo").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Procesando...',
            onBeforeOpen: () => {
                Swal.showLoading();
            }});
        $.ajax({
            url: '<?=base_url('/index.php/CrudFactura/enviarFacturaCorreo/')?>',
            data: $("#formularioFacturaCorreo").serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                Swal.close();
                swal(data[0], data[1], data[2]);
            }
        })
    });
    $("#formularioFactura").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Procesando...',
            onBeforeOpen: () => {
                Swal.showLoading();
            }});
        $.ajax({
            url: '<?=base_url('/index.php/CrudFactura/facturar')?>',
            data: $("#formularioFactura").serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                Swal.close();
                swal(data[0], data[1], data[2]);
                $("#folioFacturacion").empty();
                loadUrl('CrudFactura/')
            }
        });
    })
    function abrirModalBusquedaFolio() {
        $("#modalFactura").modal('open');

    }
</script>