<?= $this->include('julio101290\boilerplate\Views\load\select2') ?>
<?= $this->include('julio101290\boilerplate\Views\load\datatables') ?>
<?= $this->include('julio101290\boilerplate\Views\load\nestable') ?>
<!-- Extend from layout index -->
<?= $this->extend('julio101290\boilerplate\Views\layout\index') ?>

<!-- Section content -->
<?= $this->section('content') ?>

<?= $this->include('julio101290\boilerplatelicences\Views\modulesLicencias/modalCaptureLicencias') ?>

<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-header">
        <div class="float-right">
            <div class="btn-group">

                <button class="btn btn-primary btnAddLicencias" data-toggle="modal" data-target="#modalAddLicencias"><i class="fa fa-plus"></i>

                    <?= lang('licencias.add') ?>

                </button>

            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tableLicencias" class="table table-striped table-hover va-middle tableLicencias">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th><?= lang('licencias.fields.idEmpresa') ?></th>
                                <th><?= lang('licencias.fields.descripcion') ?></th>
                                <th><?= lang('licencias.fields.desdeFecha') ?></th>
                                <th><?= lang('licencias.fields.hastaFecha') ?></th>
                                <th><?= lang('licencias.fields.claveModulo') ?></th>
                                <th><?= lang('licencias.fields.licencia') ?></th>
                                <th><?= lang('licencias.fields.created_at') ?></th>
                                <th><?= lang('licencias.fields.updated_at') ?></th>
                                <th><?= lang('licencias.fields.deleted_at') ?></th>

                                <th><?= lang('licencias.fields.actions') ?> </th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.card -->

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>

    /**
     * Cargamos la tabla
     */

    var tableLicencias = $('#tableLicencias').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        order: [[1, 'asc']],

        ajax: {
            url: '<?= base_url('admin/licencias') ?>',
            method: 'GET',
            dataType: "json"
        },
        columnDefs: [{
                orderable: false,
                targets: [10],
                searchable: false,
                targets: [10]

            }],
        columns: [{
                'data': 'id'
            },

            {
                'data': 'idEmpresa'
            },

            {
                'data': 'descripcion'
            },

            {
                'data': 'desdeFecha'
            },

            {
                'data': 'hastaFecha'
            },

            {
                'data': 'claveModulo'
            },

            {
                'data': 'licencia'
            },

            {
                'data': 'created_at'
            },

            {
                'data': 'updated_at'
            },

            {
                'data': 'deleted_at'
            },

            {
                "data": function (data) {
                    return `<td class="text-right py-0 align-middle">
                         <div class="btn-group btn-group-sm">
                             <button class="btn btn-warning btnEditLicencias" data-toggle="modal" idLicencias="${data.id}" data-target="#modalAddLicencias">  <i class=" fa fa-edit"></i></button>
                             <button class="btn btn-success btnGetString" nombre="${data.nombre}" rfc="${data.rfc}"  claveModulo="${data.claveModulo}" desdeFecha="${data.desdeFecha}" hastaFecha="${data.hastaFecha}">  <i class="fa fa-unlock"></i></button> 
                            <button class="btn btn-danger btn-delete" data-id="${data.id}"><i class="fas fa-trash"></i></button>
                         </div>
                         </td>`
                }
            }
        ]
    });




    /**
     * GENERA CADENA
     */

    $(".tableLicencias").on("click", ".btnGetString", function () {

        var nombre = $(this).attr("nombre");
        var rfc = $(this).attr("rfc");
        var claveModulo = $(this).attr("claveModulo");
        var desdeFecha = $(this).attr("desdeFecha");
        var hastaFecha = $(this).attr("hastaFecha");

        var cadena = nombre + rfc + claveModulo  + desdeFecha + hastaFecha;


        Swal.fire({
            title: "Copie y envie al desarrollador la siguiente cadena!",
            text: cadena,
            icon: "success"
        });
    }

    );

    $(document).on('click', '#btnSaveLicencias', function (e) {


        var idLicencias = $("#idLicencias").val();
        var idEmpresa = $("#idEmpresa").val();
        var descripcion = $("#descripcion").val();
        var desdeFecha = $("#desdeFecha").val();
        var hastaFecha = $("#hastaFecha").val();
        var claveModulo = $("#claveModulo").val();
        var licencia = $("#licencia").val();

        $("#btnSaveLicencias").attr("disabled", true);

        var datos = new FormData();
        datos.append("idLicencias", idLicencias);
        datos.append("idEmpresa", idEmpresa);
        datos.append("descripcion", descripcion);
        datos.append("desdeFecha", desdeFecha);
        datos.append("hastaFecha", hastaFecha);
        datos.append("claveModulo", claveModulo);
        datos.append("licencia", licencia);


        $.ajax({

            url: "<?= base_url('admin/licencias/save') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.match(/Correctamente.*/)) {

                    Toast.fire({
                        icon: 'success',
                        title: "Guardado Correctamente"
                    });

                    tableLicencias.ajax.reload();
                    $("#btnSaveLicencias").removeAttr("disabled");


                    $('#modalAddLicencias').modal('hide');
                } else {

                    Toast.fire({
                        icon: 'error',
                        title: respuesta
                    });

                    $("#btnSaveLicencias").removeAttr("disabled");


                }

            }

        }

        ).fail(function (jqXHR, textStatus, errorThrown) {

            if (jqXHR.status === 0) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "No hay conexión.!" + jqXHR.responseText
                });

                $("#btnSaveLicencias").removeAttr("disabled");


            } else if (jqXHR.status == 404) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Requested page not found [404]" + jqXHR.responseText
                });

                $("#btnSaveLicencias").removeAttr("disabled");

            } else if (jqXHR.status == 500) {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Internal Server Error [500]." + jqXHR.responseText
                });


                $("#btnSaveLicencias").removeAttr("disabled");

            } else if (textStatus === 'parsererror') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Requested JSON parse failed." + jqXHR.responseText
                });

                $("#btnSaveLicencias").removeAttr("disabled");

            } else if (textStatus === 'timeout') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Time out error." + jqXHR.responseText
                });

                $("#btnSaveLicencias").removeAttr("disabled");

            } else if (textStatus === 'abort') {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Ajax request aborted." + jqXHR.responseText
                });

                $("#btnSaveLicencias").removeAttr("disabled");

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'Uncaught Error: ' + jqXHR.responseText
                });


                $("#btnSaveLicencias").removeAttr("disabled");

            }
        })

    });



    /**
     * Carga datos actualizar
     */


    /*=============================================
     EDITAR Licencias
     =============================================*/
    $(".tableLicencias").on("click", ".btnEditLicencias", function () {

        var idLicencias = $(this).attr("idLicencias");

        var datos = new FormData();
        datos.append("idLicencias", idLicencias);

        $.ajax({

            url: "<?= base_url('admin/licencias/getLicencias') ?>",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#idLicencias").val(respuesta["id"]);

                $("#idEmpresa").val(respuesta["idEmpresa"]).trigger("change");
                $("#descripcion").val(respuesta["descripcion"]);
                $("#desdeFecha").val(respuesta["desdeFecha"]);
                $("#hastaFecha").val(respuesta["hastaFecha"]);
                $("#claveModulo").val(respuesta["claveModulo"]);
                $("#licencia").val(respuesta["licencia"]);


            }

        })

    })


    /*=============================================
     ELIMINAR licencias
     =============================================*/
    $(".tableLicencias").on("click", ".btn-delete", function () {

        var idLicencias = $(this).attr("data-id");

        Swal.fire({
            title: '<?= lang('boilerplate.global.sweet.title') ?>',
            text: "<?= lang('boilerplate.global.sweet.text') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('boilerplate.global.sweet.confirm_delete') ?>'
        })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `<?= base_url('admin/licencias') ?>/` + idLicencias,
                            method: 'DELETE',
                        }).done((data, textStatus, jqXHR) => {
                            Toast.fire({
                                icon: 'success',
                                title: jqXHR.statusText,
                            });


                            tableLicencias.ajax.reload();
                        }).fail((error) => {
                            Toast.fire({
                                icon: 'error',
                                title: error.responseJSON.messages.error,
                            });
                        })
                    }
                })
    })

    $(function () {
        $("#modalAddLicencias").draggable();

    });


</script>
<?= $this->endSection() ?>
        