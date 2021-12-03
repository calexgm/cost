@extends('layouts.app', ['page' => 'Venta', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-7">
                                <h4 class="card-title">Detalle de venta</h4>
                            </div>
                            <div class="col text-right">
                                <a type="button" href="{{ route('ventas') }}"
                                    class="btn btn-primary btn-round ">VOLVER
                                </a>
                            </div>
                            @if (!$sales->finalized_at || $mifecha < $sales->finalized_at)
                                <div class="col text-right">
                                        <button type="button" data-id="{{ $sale->id }}"
                                            class="btn btn-primary btn-round btn_finalice">FINALIZAR VENTA
                                        </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tblUsers">
                                <thead class="">
                                    <th>
                                        ID
                                    </th>
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
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ date('d-m-Y', strtotime($sale->created_at)) }}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td id="tbl_prods">{{ $sale->products->count() }}</td>
                                        <td id="tbl_cantidad">{{ $sale->products->sum('qty') }}</td>
                                        <td id="tbl_total_amount">{{ number_format($total_amount) }}</td>
                                        <td id="tbl_estado">
                                            @if (!$sale->finalized_at) 
                                                <span class="text-danger">EN PROCESO</span>
                                            @else
                                                @if($mifecha < $sales->finalized_at)
                                                    <span class="text-warning">EN ESPERA</span>
                                                @else
                                                    <span class="text-success">COMPLETADA<br> . {{ date('d-m-Y', strtotime($sale->finalized_at))}}</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6 text-right">
                                @if (!$sales->finalized_at || $mifecha < $sales->finalized_at)
                                    <button class="btn btn-primary btn-round modal_add_open" type="button"
                                        data-id="{{ $sale->id }}"><i class="fas fa-plus-circle"></i>
                                        AGREGAR
                                        PRODUCTO</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tblUsers">
                                <thead class="">
                                    <th>
                                        FECHA
                                    </th>
                                    <th>
                                        PRODUCTO
                                    </th>
                                    <th>
                                        CATEGORÍA
                                    </th>
                                    <th>
                                        CANTIDAD
                                    </th>
                                    <th>
                                        PRECIO UNITARIO
                                    </th>
                                    <th>
                                        TOTAL
                                    </th>
                                    <th class="text-right">

                                    </th>
                                </thead>
                                <tbody id="tbdy_productos">
                                    @foreach ($sale->products as $sold_product)
                                        <tr id="{{ $sold_product->product->id }}">
                                            <td>{{ date('d-m-Y', strtotime($sold_product->created_at)) }}</td>
                                            <td>{{ $sold_product->product->name }}</td>
                                            <td>{{ $sold_product->product->category->name }}</td>
                                            <td>
                                                @if (!$sales->finalized_at || $mifecha < $sales->finalized_at)
                                                <button data-sale="{{ $sale->id }}" type="button"
                                                    data-id="{{ $sold_product->product->id }}"
                                                    class="btn btn-danger btn-round btn_less"> <i
                                                        class="fas fa-minus"></i> </button>
                                                        @endif        
                                                {{ $sold_product->qty }}
                                                @if (!$sales->finalized_at || $mifecha < $sales->finalized_at)
                                                <button data-sale="{{ $sale->id }}" type="button"
                                                    data-id="{{ $sold_product->product->id }}"
                                                    class="btn btn-success btn-round btn_more"> <i
                                                        class="fas fa-plus"></i> </button>
                                                        @endif
                                            </td>
                                            <td>{{ number_format($sold_product->price) }}</td>
                                            <td>{{ number_format($sold_product->total_amount) }}</td>
                                            <td class="td-actions text-right">
                                                @if (!$sales->finalized_at || $mifecha < $sales->finalized_at)
                                                    <button type="button" data-sale="{{ $sale->id }}"
                                                        data-id="{{ $sold_product->product->id }}"
                                                        class="btn btn-danger btn-round btn_delete_product">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal OPEN -->
    <div class="modal fade" id="openAddProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-4">
                    <div class="container">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Producto </label>
                                    <input type="text" class="form-control" id="formulario">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $sale->id }}" id="id_sale">
                        <div class="row" id="resultado">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Escan -->
    @if(!$sales->finalized_at || $mifecha < $sales->finalized_at)
    <div class="modal fade" id="openScann" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0 !important;">
                    <div class="">
                        <div class="row justify-content-center">
                            <div class=" text-center" id="div_scann">
                                <scandit-barcode-picker 
                                id="barcodePicker"
            configure.licenseKey="AdUgSxxNPcDNJN3l0DyLzyI/AtdVI/XfOVjwVrRT/oKPOM8XmQqkPudFiJJuN8IMchaasu9eC6tDa1amawvip7gG/oqFVmKMfkpHB9s1caqdHB1oyS7ZpZgdaEaNLQ0BlAs2X6gYDeVbZJ9TgC0rZVdBRNOr6PNyuITaENjwX55rRAuN24UZTgG2SIZS6xaNY7PMaDctQjI4XwHdh3qnqft5s6BAifp5CgVtRkvzNAC2LkiW62ABQXY2Qvlbe77PKq3V1DCw6bQN/d2Csy0n6OiZ1epmaU4WG++dwhfDJjNlciU12tH7bleWXHKWokGi9d7hzDeFxS1pJX6xxJHsOndArL0gWDCEflVasoMl7kOQFCk98yMcynWW4rVwUV1z3biZXvMwjms+S3xwxL5/wfhuD/7urR38RdZieD9jeCL1y5F0UhPPj3mHF3jiIhU5v6mhS08ZxXgnAQQY2qV0/mD75uWnWljj/Pu0itbzB5/yZPDYEM5M7FsXcEvBYKLv726QSwfl+EHW/lLNTVQOJKBoG2xmizcuW5Z3ryYD04U3Bk5HlBP97Nch8BxnprTfPqJdhQ0W9YEvNSRwL2P4Xz8c1VqFma90uAQRnsS550LWvUck9YqaOSniSw4UbYfpUiy2+jsa9OibrSEKqXoovL11n6CDnBU/ugbm1mX5JsTFwheNaoYaE3YNEJgxrKvbYTvvpGGYh80Yanjlo/muGEoAfxHnUNIUnHQ+irSJAzpMEf8upNb2JL00arMvCaJ88kyyRnnenCz3slcLyu/j9ESlSiH9lRbe8QfrJ7tyeQ=="
            configure.engineLocation="https://cdn.jsdelivr.net/npm/scandit-sdk@5.x/build/" playSoundOnScan="true"                    
            scanSettings.enabledSymbologies='["ean8", "ean13", "upca", "upce"]'></scandit-barcode-picker>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $sale->id }}" id="id_sale">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Modal Cantidad -->
    <div class="modal fade" id="add_cantidad" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingrese la cantidad</h5>
                    <button type="button" class="close" id="close_count">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-4">
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad </label>
                                <input type="number" min="1" class="form-control" id="count">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_prod_c">
                    <div class="row" id="resultado">
                    </div>
                    <div class="row text-center">
                        <div class="col">
                            <button type="submit" class="btn btn-success btn-round btn_add_cantidad">Añadir
                                producto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="openEditProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_sale_edit">
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Producto </label>
                                <select id="edit_product" class="form-control" disabled>
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($products as $produc)
                                        <option data-price="{{ $produc->price }}" value="{{ $produc->id }}">
                                            {{ $produc->product }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="edit_cantidad" min="1" class="form-control"
                                    placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-round btn_update_open">Editar</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary btn-round"
                                    data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            function prods(params) {
                filtrarProds(params);
            }
            $.ajax({
                url: '{{ route('prods') }}',
                data: {},
                type: 'post',
                beforeSend: function() {},
                success: function(response) {
                    if (response.response) {
                        prods(response.data);
                    } else {
                        alertify.error(
                            'Ocurrio un error, intentelo nuevamente.'
                        );
                    }

                },

                error: function(x, xs, xt) {
                    alertify.error('Ocurrio un error, intentelo nuevamente.');
                }
            });

            function filtrarProds(productos) {
                const formulario = document.querySelector('#formulario');
                let result = '';
                for (let producto of productos) {

                    $('#resultado').append('<div class="col">' +
                        '<div class="modal_add_cantidad card card_product_search" data-id="' + producto.id +
                        '">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + producto.product + '</h5>' +
                        '<p class="card-text">' + producto.description + '</p>' +
                        '<p class="card-text">' + producto.price + '</p> ' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                }
                const filtrar = () => {

                    $('#resultado').empty();
                    const texto = formulario.value.toLowerCase();
                    for (let producto of productos) {
                        let nombre = producto.product.toLowerCase();
                        if (nombre.indexOf(texto) !== -1) {
                            result = 1;
                            $('#resultado').append('<div class="col">' +
                                '<div class="modal_add_cantidad card card_product_search" data-id="' +
                                producto.id + '">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">' + producto.product + '</h5>' +
                                '<p class="card-text">' + producto.description + '</p>' +
                                '<p class="card-text">' + producto.price + '</p> ' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        }
                    }
                    if (result !== 1) {
                        $('#resultado').append('<li>PRODUCTO NO ENCONTRADO</li>');
                    }

                }
                formulario.addEventListener('keyup', filtrar);
            }
        });
        $(document).on('click', '.modal_add_cantidad', function() {
            $('#count').val('');
            $('#add_cantidad').modal('show');
            let id_prod = $(this).attr("data-id");
            $('#id_prod_c').val(id_prod);
            $('#openAddProduct').addClass('z');
        });
        $(document).on('click', '#close_count', function() {
            $('#openAddProduct').removeClass('z');
            $('#count').val('');
            $('#id_prod_c').val('');
            $('#add_cantidad').modal('hide');
        });
        //agregar cantidad de producto
        $(document).on('click', '.btn_add_cantidad', function() {
            let count = $('#count').val();
            let prod = $('#id_prod_c').val();
            var id_sale = $('#id_sale').val();
            console.log(id_sale);
            if (count.trim() <= 0 || count.trim() > 50) {
                alertify.error('Ingrese una cantidad válida')
            } else {
                $.ajax({
                    url: '{{ route('add_p') }}',
                    data: {
                        count: count,
                        id: prod,
                        sale: id_sale
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.btn_add_cantidad').prop('disabled', true);
                        $('.btn_add_cantidad').empty();
                        $('.btn_add_cantidad').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            let detail = response.detail;
                            let data = response.data;
                            //Llenamos el detalle
                            $('#tbl_prods').empty();
                            $('#tbl_prods').append('' + detail.prods + '');
                            $('#tbl_cantidad').empty();
                            $('#tbl_cantidad').append('' + detail.qty + '');
                            $('#tbl_total_amount').empty();
                            $('#tbl_total_amount').append('' + new Intl.NumberFormat("de-DE").format(
                                detail.total) + '');
                                $('#tbl_estado').empty();
                        $('#tbl_estado').append('EN PROCESO');
                            /*Llenamos los productos*/
                            $('#tbdy_productos').empty();
                            data.forEach(prodata => {
                                let date = new Date(prodata.created_at);
                                const formatDate = (date) => {
                                    let formatted_date = date.getDate() + "-" + (date
                                            .getMonth() + 1) +
                                        "-" + date.getFullYear()
                                    return formatted_date;
                                }
                                $('#tbdy_productos').append('<tr id="' + prodata.id + '">' +
                                '<td>' + formatDate(date) + '</td>' +
                                '<td>' + prodata.name + '</td>' +
                                '<td>' + prodata.cate + '</td>' +
                                '<td><button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-danger btn-round btn_less"> <i ' +
                                'class="fas fa-minus"></i> </button>' +
                                ''+ prodata.qty +'' +
                                '<button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-success btn-round btn_more"> <i ' +
                                'class="fas fa-plus"></i> </button>' +
                                '</td>'+
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.price) + '</td>' +
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.total_amount) + '</td>' +
                                '<td class="td-actions text-right">' +
                                '@if (!$sales->finalized_at || $sales->finalized_at < $mifecha)'+
                                    '<button type="button" data-sale="{{ $sale->id }}" data-id="'+prodata.id+'"'+
                                        ' class="btn btn-danger btn-round btn_delete_product"><i '+
                                            'class="far fa-trash-alt"></i>'+
                                        '</button>'+
                                    '@endif' +
                                '</td>' +
                                '</tr>');
                            });

                            //otras accciones
                            alertify.success(response.msg);
                            $('#openAddProduct').removeClass(
                                'z');
                            $('#add_cantidad').modal('hide');
                            $('#count').val('');
                            $(
                                '#id_prod_c').val('');
                            $('.btn_add_cantidad').prop('disabled',
                                false);
                            $('.btn_add_cantidad').empty();
                            $('.btn_add_cantidad')
                                .append(
                                    'AÑADIR PRODUCTO'
                                );

                        } else {
                            alertify.error(response.msg);
                            $('.btn_add_cantidad').prop('disabled', false);
                            $('.btn_add_cantidad').empty();
                            $('.btn_add_cantidad').append(
                                'AÑADIR PRODUCTO'
                            );
                        }
                    },

                    error: function(x, xs, xt) {
                        $('.btn_add_cantidad').prop('disabled', false);
                        $('.btn_add_cantidad').empty();
                        $('.btn_add_cantidad').append(
                            'AÑADIR PRODUCTO'
                        );
                        alertify.error('Ocurrio un error, intentelo nuevamente.');
                    }
                });
            }
        });
        //Funcion eliminar
        $(document).on('click', '.btn_delete_product', function() {
            let idd = $(this).attr("data-id");
            let sale = $(this).attr("data-sale");
            alertify.confirm('Eliminar', '¿Está segur@ de eliminar este producto?', function() {
                //OK
                $.ajax({
                    url: '{{ route('delete_p_sale') }}',
                    data: {
                        id: idd,
                        sale: sale,
                    },
                    type: 'post',
                    beforeSend: function() {},
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Producto eliminado con exito.');
                            $('#' + response.id + '').empty();
                            let detail = response.detail;
                            //Llenamos el detalle
                            $('#tbl_prods').empty();
                            $('#tbl_prods').append('' + detail.prods + '');
                            $('#tbl_cantidad').empty();
                            $('#tbl_cantidad').append('' + detail.qty + '');
                            $('#tbl_total_amount').empty();
                            $('#tbl_total_amount').append('' + new Intl.NumberFormat("de-DE")
                                .format(
                                    detail.total) + '');
                                    $('#tbl_estado').empty();
                        $('#tbl_estado').append('EN PROCESO');        
                        } else {
                            alertify.error(
                                'Ocurrio un error, intentelo nuevamente.'
                            );
                        }

                    },

                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error, intentelo nuevamente.');
                        console.log(x);
                    }
                });
            }, function() {
                //Cancel
            });

        });
        $(document).ready(function() {
            $("#dashboard").removeClass("active");
            $("#categories").removeClass("active");
            $("#products").removeClass("active");
            $("#vents").addClass("active");
            $("#users").removeClass("active");
            $("#repors").removeClass("active");


        });
        //Funcion finalizar
        $('.btn_finalice').click(function() {
            let idd = $(this).attr("data-id");

            alertify.confirm('Eliminar', '¿Está segur@ de finalizar esta venta?', function() {
                //OK
                $.ajax({
                    url: '{{ route('finalize') }}',
                    data: {
                        id: idd,
                    },
                    type: 'post',
                    beforeSend: function() {},
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Venta finalizada con exito.');
                            setTimeout(() => {
                                location.href = "/ventas";
                            }, 1000);
                        } else {
                            alertify.error(
                                'Ocurrio un error, intentelo nuevamente.'
                            );
                        }

                    },

                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error, intentelo nuevamente.');
                        console.log(x);
                    }
                });
            }, function() {
                //Cancel
            });

        });
        //añadir open
        $('.modal_add_open').click(function() {
            $('#openAddProduct').modal('show');
        });
        
        //abrir escaner
        $('.modal_add_scann').click(function() {
            //EVITAR QUE SE CIERRE MODAL
            //$('#openScann').modal({backdrop: 'static', keyboard: false})
            $('#openScann').modal('show');
        });
        $('.close_scann').click(function() {
            $('#openScann').modal('hide');
            $('#div_scann').empty();
        });
        
        $('.btn_add_open').click(function() {
            var id_prod = $('#id_product_open').val();
            var cantidad = $('#add_cantidad').val();
            var id_sale = $('#id_sale').val();
            let regNumber = /[0-9]+/g;
            if (id_prod == "") {
                alertify.error('El campo producto es requerido.');
            } else if (cantidad == "") {
                alertify.error('El campo cantidad es requerido.');
            } else if (cantidad <= 0) {
                alertify.error('Ingrese una cantidad válida.');
            } else {
                $.ajax({
                    url: '{{ route('add_p') }}',
                    data: {
                        id: id_prod,
                        cantidad: cantidad,
                        sale: id_sale,
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.btn_add_open').prop('disabled', true);
                        $('.btn_add_open').empty();
                        $('.btn_add_open').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Producto agregado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('.btn_add_open').prop('disabled', false);
                            $('.btn_add_open').empty();
                            $('.btn_add_open').append('AGREGAR');
                            alertify.error('Ocurrio un error.');
                        }
                    },
                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error.');
                        console.log(x);
                    }
                });
            }


        });
        //Restar cantidad
        $(document).on('click', '.btn_less', function() {
            const count = -1;
            let id = $(this).attr("data-id");
            let sale = $(this).attr("data-sale");
            $.ajax({
                url: '{{ route('less_more') }}',
                data: {
                    count: count,
                    id: id,
                    sale: sale
                },
                type: 'post',
                beforeSend: function() {
                    $('.btn_less').prop('disabled', true);
                    $('.btn_less').empty();
                    $('.btn_less').append(
                        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                    );
                },
                success: function(response) {
                    if (response.response) {
                        let detail = response.detail;
                        let data = response.data;
                        //Llenamos el detalle
                        $('#tbl_prods').empty();
                        $('#tbl_prods').append('' + detail.prods + '');
                        $('#tbl_cantidad').empty();
                        $('#tbl_cantidad').append('' + detail.qty + '');
                        $('#tbl_total_amount').empty();
                        $('#tbl_total_amount').append('' + new Intl.NumberFormat("de-DE").format(
                            detail.total) + '');
                            $('#tbl_estado').empty();
                        $('#tbl_estado').append('EN PROCESO');    
                        /*Llenamos los productos*/
                        $('#tbdy_productos').empty();
                        data.forEach(prodata => {
                            let date = new Date(prodata.created_at);
                            const formatDate = (date) => {
                                let formatted_date = date.getDate() + "-" + (date
                                        .getMonth() + 1) +
                                    "-" + date.getFullYear()
                                return formatted_date;
                            }
                            $('#tbdy_productos').append('<tr id="' + prodata.id + '">' +
                                '<td>' + formatDate(date) + '</td>' +
                                '<td>' + prodata.name + '</td>' +
                                '<td>' + prodata.cate + '</td>' +
                                '<td><button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-danger btn-round btn_less"> <i ' +
                                'class="fas fa-minus"></i> </button>' +
                                ' '+ prodata.qty +' ' +
                                '<button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-success btn-round btn_more"> <i ' +
                                'class="fas fa-plus"></i> </button>' +
                                '</td>'+
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.price) + '</td>' +
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.total_amount) + '</td>' +
                                '<td class="td-actions text-right">'+
                                '@if (!$sales->finalized_at || $mifecha < $sales->finalized_at)'+
                                    '<button type="button" data-sale="{{ $sale->id }}" data-id="'+prodata.id+'"'+
                                        ' class="btn btn-danger btn-round btn_delete_product"><i '+
                                            'class="far fa-trash-alt"></i>'+
                                        '</button>'+
                                '@endif' +
                                '</td>' +
                                '</tr>');
                        });

                        //otras accciones
                        alertify.success(response.msg);

                        $('.btn_less').prop('disabled', false);
                        $('.btn_less').empty();
                        $('.btn_less')
                            .append(
                                '<i class="fas fa-minus"></i>'
                            );

                    } else {
                        alertify.error(response.msg);
                        $('.btn_less').prop('disabled', false);
                        $('.btn_less').empty();
                        $('.btn_less')
                            .append(
                                '<i class="fas fa-minus"></i>'
                            );
                    }
                },

                error: function(x, xs, xt) {
                    $('.btn_less').prop('disabled', false);
                    $('.btn_less').empty();
                    $('.btn_less')
                        .append(
                            '<i class="fas fa-minus"></i>'
                        );
                    alertify.error('Ocurrio un error, intentelo nuevamente.');
                }
            });
        });
        //Sumar cantidad
        $(document).on('click', '.btn_more', function() {
            const count = 1;
            let id = $(this).attr("data-id");
            let sale = $(this).attr("data-sale");
            $.ajax({
                url: '{{ route('less_more') }}',
                data: {
                    count: count,
                    id: id,
                    sale: sale
                },
                type: 'post',
                beforeSend: function() {
                    $('.btn_more').prop('disabled', true);
                    $('.btn_more').empty();
                    $('.btn_more').append(
                        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                    );
                },
                success: function(response) {
                    if (response.response) {
                        let detail = response.detail;
                        let data = response.data;
                        //Llenamos el detalle
                        $('#tbl_prods').empty();
                        $('#tbl_prods').append('' + detail.prods + '');
                        $('#tbl_cantidad').empty();
                        $('#tbl_cantidad').append('' + detail.qty + '');
                        $('#tbl_total_amount').empty();
                        $('#tbl_total_amount').append('' + new Intl.NumberFormat("de-DE").format(
                            detail.total) + '');
                        $('#tbl_estado').empty();
                        $('#tbl_estado').append('EN PROCESO');
                        /*Llenamos los productos*/
                        $('#tbdy_productos').empty();
                        data.forEach(prodata => {
                            let date = new Date(prodata.created_at);
                            const formatDate = (date) => {
                                let formatted_date = date.getDate() + "-" + (date
                                        .getMonth() + 1) +
                                    "-" + date.getFullYear()
                                return formatted_date;
                            }
                            $('#tbdy_productos').append('<tr id="' + prodata.id + '">' +
                                '<td>' + formatDate(date) + '</td>' +
                                '<td>' + prodata.name + '</td>' +
                                '<td>' + prodata.cate + '</td>' +
                                '<td><button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-danger btn-round btn_less"> <i ' +
                                'class="fas fa-minus"></i> </button>' +
                                ' '+ prodata.qty +' ' +
                                '<button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-success btn-round btn_more"> <i ' +
                                'class="fas fa-plus"></i> </button>' +
                                '</td>'+
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.price) + '</td>' +
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.total_amount) + '</td>' +
                                '<td class="td-actions text-right">'+
                                '@if (!$sales->finalized_at || $mifecha < $sales->finalized_at)'+
                                    '<button type="button" data-sale="{{ $sale->id }}" data-id="'+prodata.id+'"'+
                                        ' class="btn btn-danger btn-round btn_delete_product"><i '+
                                            'class="far fa-trash-alt"></i>'+
                                        '</button>'+
                                '@endif' +
                                '</td>' +
                                '</tr>');
                        });

                        //otras accciones
                        alertify.success(response.msg);

                        $('.btn_more').prop('disabled', false);
                        $('.btn_more').empty();
                        $('.btn_more')
                            .append(
                                '<i class="fas fa-plus"></i>'
                            );

                    } else {
                        alertify.error(response.msg);
                        $('.btn_more').prop('disabled', false);
                        $('.btn_more').empty();
                        $('.btn_more')
                            .append(
                                '<i class="fas fa-plus"></i>'
                            );
                    }
                },

                error: function(x, xs, xt) {
                    $('.btn_more').prop('disabled', false);
                    $('.btn_more').empty();
                    $('.btn_more')
                        .append(
                            '<i class="fas fa-plus"></i>'
                        );
                    alertify.error('Ocurrio un error, intentelo nuevamente.');
                }
            });
        });

        
    </script>
    <script>
        const barcodePickerElement = document.getElementById("barcodePicker");
        barcodePickerElement.addEventListener("scan", function(event) {
            const scanResult = event.detail;
            let code = scanResult.barcodes.reduce(function(string, barcode) {
                    return string  + "" +
                        barcode.data;
                }, "");
                let sale = $('#id_sale').val();
                $.ajax({
                url: '{{ route('add_scann') }}',
                data: {
                    id: code,
                    sale: sale
                },
                type: 'post',
                beforeSend: function() {
                },
                success: function(response) {
                    if (response.response) {
                        let detail = response.detail;
                        let data = response.data;
                        //Llenamos el detalle
                        $('#tbl_prods').empty();
                        $('#tbl_prods').append('' + detail.prods + '');
                        $('#tbl_cantidad').empty();
                        $('#tbl_cantidad').append('' + detail.qty + '');
                        $('#tbl_total_amount').empty();
                        $('#tbl_total_amount').append('' + new Intl.NumberFormat("de-DE").format(
                            detail.total) + '');
                        $('#tbl_estado').empty();
                        $('#tbl_estado').append('EN PROCESO');
                        /*Llenamos los productos*/
                        $('#tbdy_productos').empty();
                        data.forEach(prodata => {
                            let date = new Date(prodata.created_at);
                            const formatDate = (date) => {
                                let formatted_date = date.getDate() + "-" + (date
                                        .getMonth() + 1) +
                                    "-" + date.getFullYear()
                                return formatted_date;
                            }
                            $('#tbdy_productos').append('<tr id="' + prodata.id + '">' +
                                '<td>' + formatDate(date) + '</td>' +
                                '<td>' + prodata.name + '</td>' +
                                '<td>' + prodata.cate + '</td>' +
                                '<td><button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-danger btn-round btn_less"> <i ' +
                                'class="fas fa-minus"></i> </button>' +
                                ' '+ prodata.qty +' ' +
                                '<button data-sale="{{ $sale->id }}" type="button"' +
                                'data-id="'+ prodata.id +'"' +
                                'class="btn btn-success btn-round btn_more"> <i ' +
                                'class="fas fa-plus"></i> </button>' +
                                '</td>'+
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.price) + '</td>' +
                                '<td>' + new Intl.NumberFormat("de-DE").format(prodata.total_amount) + '</td>' +
                                '<td class="td-actions text-right">'+
                                '@if (!$sales->finalized_at || $mifecha < $sales->finalized_at)'+
                                    '<button type="button" data-sale="{{ $sale->id }}" data-id="'+prodata.id+'"'+
                                        ' class="btn btn-danger btn-round btn_delete_product"><i '+
                                            'class="far fa-trash-alt"></i>'+
                                        '</button>'+
                                '@endif' +
                                '</td>' +
                                '</tr>');
                        });

                        //otras accciones
                        alertify.success(response.msg);
                    } else {
                        alertify.error(response.msg);
                    }
                },

                error: function(x, xs, xt) {
                    alertify.error('Ocurrio un error, intentelo nuevamente.');
                }
            });
        });
    </script>
@endpush
