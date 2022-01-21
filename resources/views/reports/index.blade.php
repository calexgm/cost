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
                                        <option value="3">Semanal</option>
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
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="table-responsive">
                                <table class="table table-striped table-style" id="tblUsers">
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
                                        <th>
                                            ESTADO
                                        </th>
                                        <th class="text-right">

                                        </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>1</td>
                                        </tr>
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
                $('#button').empty();
                $('#button').append('<button class="btn btn-success btn-round mes_search">BUSCAR</button>');

                $('#Mensual').hide();
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
                alertify.error('El campo año es requerido.');
            } else {
                $.ajax({
                    url: "{{ route('year_search')}}",
                    data: {
                        year: year,
                        mes: mes,
                    },
                    type: 'post',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.year_search').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.response) {} else {
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

        function addRowDatableToros(data) {
            data.forEach(r => {
                datatable_toros.row.add([
                    '',
                    r.NOMBRE,
                    r.RAZA_VACA,
                ]).draw(false);
            });
            $(".loader").fadeOut("slow");

        };

        //BUSCAR POR MES
        $(document).on('click', '.mes_search', function() {});

        //BUSCAR POR SEMANA
        $(document).on('click', '.semana_search', function() {});

    });
</script>
@endpush