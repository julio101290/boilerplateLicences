<!-- Modal Licencias -->
<div class="modal fade" id="modalAddLicencias" tabindex="-1" role="dialog" aria-labelledby="modalAddLicencias" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang('licencias.createEdit') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-licencias" class="form-horizontal">
                    <input type="hidden" id="idLicencias" name="idLicencias" value="0">

                    <div class="form-group row">
                        <label for="emitidoRecibido" class="col-sm-2 col-form-label">Empresa</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>

                                <select class="form-control idEmpresa" name="idEmpresa" id="idEmpresa" style = "width:80%;">
                                    <option value="0">Seleccione empresa</option>
                                    <?php
                                    foreach ($empresas as $key => $value) {

                                        echo "<option value='$value[id]' selected>$value[id] - $value[nombre] </option>  ";
                                    }
                                    ?>

                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-2 col-form-label"><?= lang('licencias.fields.descripcion') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="descripcion" id="descripcion" class="form-control <?= session('error.descripcion') ? 'is-invalid' : '' ?>" value="<?= old('descripcion') ?>" placeholder="<?= lang('licencias.fields.descripcion') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desdeFecha" class="col-sm-2 col-form-label"><?= lang('licencias.fields.desdeFecha') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="date" name="desdeFecha" id="desdeFecha" class="form-control <?= session('error.desdeFecha') ? 'is-invalid' : '' ?>" value="<?= old('desdeFecha') ?>" placeholder="<?= lang('licencias.fields.desdeFecha') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hastaFecha" class="col-sm-2 col-form-label"><?= lang('licencias.fields.hastaFecha') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="date" name="hastaFecha" id="hastaFecha" class="form-control <?= session('error.hastaFecha') ? 'is-invalid' : '' ?>" value="<?= old('hastaFecha') ?>" placeholder="<?= lang('licencias.fields.hastaFecha') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="claveModulo" class="col-sm-2 col-form-label"><?= lang('licencias.fields.claveModulo') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="claveModulo" id="claveModulo" class="form-control <?= session('error.claveModulo') ? 'is-invalid' : '' ?>" value="<?= old('claveModulo') ?>" placeholder="<?= lang('licencias.fields.claveModulo') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="licencia" class="col-sm-2 col-form-label"><?= lang('licencias.fields.licencia') ?></label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="licencia" id="licencia" class="form-control <?= session('error.licencia') ? 'is-invalid' : '' ?>" value="<?= old('licencia') ?>" placeholder="<?= lang('licencias.fields.licencia') ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><?= lang('boilerplate.global.close') ?></button>
                <button type="button" class="btn btn-primary btn-sm" id="btnSaveLicencias"><?= lang('boilerplate.global.save') ?></button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('js') ?>


<script>

    $(document).on('click', '.btnAddLicencias', function (e) {


        $(".form-control").val("");

        $("#idLicencias").val("0");

        $("#btnSaveLicencias").removeAttr("disabled");

    });

    /* 
     * AL hacer click al editar
     */



    $(document).on('click', '.btnEditLicencias', function (e) {


        var idLicencias = $(this).attr("idLicencias");

        //LIMPIAMOS CONTROLES
        $(".form-control").val("");

        $("#idLicencias").val(idLicencias);
        $("#btnGuardarLicencias").removeAttr("disabled");

    });


    $("#idEmpresa").select2();

</script>


<?= $this->endSection() ?>
        