<!-- START FOOTER -->



<script>

    function enviarCorreos()
    {
        $.ajax({
            url: '<?=base_url('index.php/Tablero/envioCorreos')?>',
            dataType: 'JSON',
            success: function (data) {

                console.table(data);
            }
        });
    }
    function loadUrl(URL, mismaPagina)
    {
        enviarCorreos();
        $("#content").html(
            "<div class = \"progress\">" +
            "         <div class = \"indeterminate\"></div>" +
            "      </div>");
        if(mismaPagina)
        {
            $("#content").remove();
            $("#seccionGeneral").append("<section id='content'>"+
                "<div class = \"progress\">" +
                "         <div class = \"indeterminate\"></div>" +
                "      </div>"+
                "</section>");
        }
        $.post(

            {

                url: '<?=base_url('index.php/')?>'+URL,

                dataType: 'HTML',

                success: function (informacion)

                {

                    $("#content").html(informacion);

                }

            }

        );


    }

    function loadEmbedUrl(URL)
    {
        $("#content").html("");
        $.post(
            {
                url: '<?=base_url('index.php/')?>'+URL,
                dataType: 'HTML',
                success: function (informacion)
                {
                    $("#contenido").html(informacion);
                }
            }
        );
    }
    function establecerAutocomplete(idSeleccionado, elemento)
    {
        /*
         * Del elemento autocomplete que se seleccionó, se busca el atributo autocomplete-target.
         * El atributo autocomplete-target fue agregado de manera personalizada, pues materialize.js no tiene funciones para establecer un id.
         * El atributo autocomplete-target contiene el id de un contenedor donde se almacena el ID del elemento que acaba de ser seleccionado
         * Cuando un elemento del autocomplete se selecciona, se busca el atributo autocomplete-target y se le coloca el valor que se seleccionó.
         * Posteriormente, se activa el evento "onChange" del target para que ejecute una función en caso de tenerla
          * */
        $("#"+$(elemento).attr("autocomplete-target")).val(idSeleccionado).trigger('change');
    }
</script>
</main>
<footer class="page-footer gradient-45deg-purple-deep-orange">

    <div class="footer-copyright">

        <div class="container">

            <span>©

              <script type="text/javascript">

                document.write(new Date().getFullYear());

              </script><a class="grey-text text-lighten-4" href="https://www.cointic.com.mx" target="_blank"> Global Shield.</a> Todos los derechos reservados.</span>

            <span class="right hide-on-small-only"> Diseñado y desarrollado por <a class="grey-text text-lighten-4" target="_blank" href="https://www.cointic.com.mx">Cointic</a></span>

        </div>

    </div>

</footer>



<!-- END FOOTER -->

<!-- ================================================

Scripts

================================================ -->



<!-- jQuery Library -->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/jquery-3.2.1.min.js"></script>

<script type="text/javascript" src="<?=base_url('assets/')?>js/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/dataTables.fixedColumns.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/materialize.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/jquery-modal-video.min.js"></script>

<!--prism-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- chartjs -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/plugins.js"></script>
<script type="text/javascript" src="<?=base_url('assets/')?>js/scripts/advanced-ui-modals.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/custom-script.js"></script>
<!--<script type="text/javascript" src="<?=base_url('assets/')?>js/scripts/dashboard-ecommerce.js"></script>-->
<script type="text/javascript" src="<?=base_url('assets/')?>js/jquery.tabledit.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js"></script>
<!--Fileinput-->
<script type="text/javascript" src="<?=base_url('assets/')?>vendors/dropify/js/dropify.min.js"></script>
</body>

</html>

