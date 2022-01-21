@extends('layouts.app', ['page' => 'Reportes', 'pageSlug' => 'products', 'section' => 'inventory']) @section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6 pl-4 pr-4">
                            <h4 class="card-title"> Reportes</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Tipo de reporte</label>
                                <select id="tipo_reporte" class="form-control">
                                        <option value="">Seleccione un tipo</option>
                                        <option value="1">Mensual</option>
                                        <option value="2">Quincenal</option>
                                        <!-- <option value="3">Semanal</option> -->
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="Mensual">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Año *</label>
                                <select id="year_reporte" class="form-control">
                                                                       
                                </select>
                            </div>
                        </div>
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Mes</label>
                                <select id="mes_reporte" class="form-control">
                                    <option value="">Seleccione un mes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="Quincenal">
                    <div class="col-6 pl-4 pr-4" style="display: noen;">
                            <div class="form-group">
                                <label>Quincena</label>
                                <select id="quincena_reporte" class="form-control">
                                <option value="">Seleccione una quincena</option>
                                <option value="1">Primera</option>
                                <option value="2">Segunda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-style" id="tbl_reports">
                                    <thead class="">
                                        <th>
                                            FECHA
                                        </th>
                                        <th>
                                            USUARIO
                                        </th>
                                        <th>
                                            PRODUCTOS
                                        </th>
                                        <th>
                                            CANTIDAD
                                        </th>
                                        <th>
                                            MONTO TOTAL
                                        </th>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col pl-4 pr-4" id="button">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @push('js')
<script>
    $(document).ready(function() {
        $("#repors").addClass("active");

        $('#Mensual').hide();
        $('#Quincenal').hide();
        $('#Semanal').hide();

        //SELECCIONAR TIPO
        $(document).on('change', '#tipo_reporte', function() {
            let tipo = $(this).val();
            if (tipo == 1) {
                let currentTime = new Date();
                let year_actual = currentTime.getFullYear()
                $('#year_reporte').empty();
                $('#year_reporte').append('<option value="">Seleccione un año</option>');
                for (let index = 2021; index <= year_actual; index++) {
                    $('#year_reporte').append('<option value="' + index + '">' + index + '</option>');
                }
                $('#button').empty();
                $('#button').append('<button class="btn btn-success btn-round year_search">BUSCAR</button>');
                $('#Mensual').show();
                $('#Quincenal').hide();
                $('#Semanal').hide();
            } else if (tipo == 2) {
                let currentTime = new Date();
                let year_actual = currentTime.getFullYear()
                $('#year_reporte').empty();
                $('#year_reporte').append('<option value="">Seleccione un año</option>');
                for (let index = 2021; index <= year_actual; index++) {
                    $('#year_reporte').append('<option value="' + index + '">' + index + '</option>');
                }
                $('#button').empty();
                $('#button').append('<button class="btn btn-success btn-round mes_search">BUSCAR</button>');

                $('#Mensual').show();
                $('#Quincenal').show();
                $('#Semanal').hide();
            } else if (tipo == 3) {
                $('#button').empty();
                $('#button').append('<button class="btn btn-success btn-round semana_search">BUSCAR</button>');

                $('#Mensual').hide();
                $('#Quincenal').hide();
                $('#Semanal').show();
            }
        });

        //SELECCIONA AÑO
        $(document).on('change', '#year_reporte', function() {
            let selected = $(this).val();
            let mes_actual = 12;
            let date = new Date();
            let year_actual = date.getFullYear();
            $('#mes_reporte').empty();
            let meses = [{
                id: '01',
                name: 'Enero'
            }, {
                id: '02',
                name: 'Febrero'
            }, {
                id: '03',
                name: 'Marzo'
            }, {
                id: '04',
                name: 'Abril'
            }, {
                id: '05',
                name: 'Mayo'
            }, {
                id: '06',
                name: 'Junio'
            }, {
                id: '07',
                name: 'Julio'
            }, {
                id: '08',
                name: 'Agosto'
            }, {
                id: '09',
                name: 'Septiembre'
            }, {
                id: '10',
                name: 'Octubre'
            }, {
                id: '11',
                name: 'Noviembre'
            }, {
                id: '12',
                name: 'Diciembre'
            }, ];

            if (year_actual == selected) {
                mes_actual = date.getMonth() + 1;
            }

            for (let i = 0; i < mes_actual; i++) {
                $('#mes_reporte').append('<option value="' + meses[i].id + '">' + meses[i].name + '</option>');

            }
            meses.forEach(m => {

            });
        });



        //BUSCAR POR AÑO
        $(document).on('click', '.year_search', function() {
            let year = $('#year_reporte').val();
            let mes = $('#mes_reporte').val();
            if (year == "") {
                alertify.error('Seleccione un año');
            } else {
                $.ajax({
                    url: "{{ route('year_search')}}",
                    data: {
                        year: year,
                        mes: mes,
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.year_search').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.response) {
                            datatable.clear().draw();
                            addRowDatable(response.data);
                            $('.year_search').prop('disabled', false);
                        } else {
                            $('.year_search').prop('disabled', false);
                            alertify.error('Ocurrio un error.');
                        }
                    },
                    error: function(x, xs, xt) {
                        console.log(x);
                        alertify.error('Ocurrio un error.');
                        $('..year_search').prop('disabled', false);
                    }
                });
            }
        });

        $.ajax({
            url: "{{ route('get_search')}}",
            data: {
            },
            type: 'post',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.year_search').prop('disabled', true);
            },
            success: function(response) {
                if (response.response) {
                    addRowDatable(response.data);
                } else {
                    $('.year_search').prop('disabled', false);
                    alertify.error('Ocurrio un error.');
                }
            },
            error: function(x, xs, xt) {
                console.log(x);
                alertify.error('Ocurrio un error.');
                $('..year_search').prop('disabled', false);
            }
        });

        function addRowDatable(data) {
                data.forEach(r => {
                let date = new Date(r.finalized_at);
                const formatDate = (date) => {
                    let formatted_date = date.getDate() + "-" + (date
                            .getMonth() + 1) +
                        "-" + date.getFullYear()
                    return formatted_date;
                }
                datatable.row.add([
                    formatDate(date),
                    r.name,
                    r.count,
                    r.sum,
                    '$ '+new Intl.NumberFormat("de-DE").format(r.total_amount),
                ]).draw(false);
            });
            $(".loader").fadeOut("slow");

        };
        let idioma = {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            };

            let datatable = $('#tbl_reports').DataTable({
                responsive: true,
                destroy: true,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5'
                ],
                language: idioma,
            });

        //BUSCAR POR MES
        $(document).on('click', '.mes_search', function() {
            let year = $('#year_reporte').val();
            let mes = $('#mes_reporte').val();
            let quincena = $('#quincena_reporte').val();
            
            if (year == "") {
                alertify.error('Seleccione un año');
            } else if (mes == "") {
                alertify.error('Seleccione un mes');
            } else if (quincena == "") {
                alertify.error('Seleccione una quincena');
            } else {
                $.ajax({
                    url: "{{ route('quincena_search')}}",
                    data: {
                        year: year,
                        mes: mes,
                        quincena: quincena,
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.year_search').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.response) {
                            datatable.clear().draw();
                            addRowDatable(response.data);
                            $('.year_search').prop('disabled', false);
                        } else {
                            $('.year_search').prop('disabled', false);
                            alertify.error('Ocurrio un error.');
                        }
                    },
                    error: function(x, xs, xt) {
                        console.log(x);
                        alertify.error('Ocurrio un error.');
                        $('..year_search').prop('disabled', false);
                    }
                });
            }
        });

        //BUSCAR POR SEMANA
        $(document).on('click', '.semana_search', function() {});

    });
</script>
@endpush