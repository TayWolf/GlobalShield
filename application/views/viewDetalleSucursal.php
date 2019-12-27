<div class="container">
    <div class="row">
        <div class="col s12">
            <h4 class="header">Detalle de la sucursal <?=$sucursal['nombreSucursal']?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12" align="center">
            <a class="btn waves-light waves-effect" onclick="loadUrl('CrudSucursal')">Regresar</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">

            <div class="card-panel">
                <div class="row">
                    <div class="col s12 m4 input-field">
                        <input type="text" name="nombreSucursal" id="nombreSucursal" value="<?=$sucursal['nombreSucursal']?>" required disabled>
                        <label for="nombreSucursal" class="active">Nombre de la sucursal</label>
                    </div>
                    <div class="col s12 m4 input-field">
                        <input type="text" name="calleSucursal" id="calleSucursal" value="<?=$sucursal['calle']?>" required disabled>
                        <label for="calleSucursal" class="active">Calle</label>
                    </div>
                    <div class="col s12 m2 input-field">
                        <input type="text" name="numeroSucursal" id="numeroSucursal" value="<?=$sucursal['numero']?>" required disabled>
                        <label for="numeroSucursal" class="active">Número exterior</label>
                    </div>

                    <div class="col s12 m2 input-field">
                        <input type="text" name="numeroInterior" id="numeroInterior" value="<?=$sucursal['numeroInterior']?>" required disabled>
                        <label for="numeroInterior" class="active">Número interior</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 input-field">
                        <select name="estado" id="estado" onchange="cargarMunicipios()" required disabled>
                            <option value=""><?=$estado['nombreEstado']?></option>
                        </select>
                        <label for="estado">Estado</label>
                    </div>
                    <div class="col s12 m4 input-field">
                        <select name="municipio" id="municipio" onchange="cargarColonias()" required disabled>
                            <option value=""><?=$municipio['nombreMunicipio']?></option>
                        </select>
                        <label for="municipio">Municipio</label>
                    </div>
                    <div class="col s12 m4 input-field">
                        <select name="colonia" id="colonia" required disabled>
                            <option value=""><?=$region['nombreRegion']." C.P. ".$region['codigoPostal']?></option>
                        </select>
                        <label for="colonia">Colonia</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3 input-field">
                        <input type="tel" name="RazonSocial" id="RazonSocial" value="<?=$sucursal['RazonSocial']?>" disabled>
                        <label for="RazonSocial" class="active">Razón Social</label>
                    </div>
                    <div class="col s12 m3 input-field">
                        <input type="tel" name="RFC" id="RFC" value="<?=$sucursal['RFC']?>" disabled>
                        <label for="RFC" class="active">RFC</label>
                    </div>
                    <div class="col s12 m3 input-field">
                        <input type="tel" name="telefono1" id="telefono1" value="<?=$sucursal['telefono1']?>" disabled>
                        <label for="telefono1" class="active">Teléfono</label>
                    </div>
                    <div class="col s12 m3 input-field">
                        <input type="tel" name="telefono2" id="telefono2" value="<?=$sucursal['telefono2']?>" disabled>
                        <label for="telefono2" class="active">Teléfono</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4 input-field">
                        <input type="text" name="idCuenta" id="idCuenta" value="<?=$sucursal['idCuenta']?>" disabled>
                        <label for="idCuenta" class="active">Id de cuenta</label>
                    </div>
                    <div class="col s12 m4 input-field">
                        <input type="text" name="primaryKey" id="primaryKey" value="<?=$sucursal['keyPrivada']?>" disabled>
                        <label for="primaryKey" class="active">Llave privada</label>
                    </div>
                    <div class="col s12 m4 input-field">
                        <input type="text" name="publicKey" id="publicKey" value="<?=$sucursal['keyPublica']?>" disabled>
                        <label for="publicKey" class="active">Llave pública</label>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("select").material_select();
        });
    </script>