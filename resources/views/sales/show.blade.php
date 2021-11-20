@extends('layouts.app', ['page' => 'Venta', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="card-title">Detalle de venta</h4>
                            </div>
                            @if (!$sale->finalized_at)
                                <div class="col-4 text-right">
                                    @if ($sale->products->count() == 0)
                                    @else
                                        <button type="button" data-id="{{ $sale->id }}"
                                            class="btn btn-primary btn-round btn_finalice">FINALIZAR VENTA
                                        </button>
                                    @endif
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
                                        <td>{{ $sale->products->count() }}</td>
                                        <td>{{ $sale->products->sum('qty') }}</td>
                                        <td>
                                            {{ format_money($sale->total_amount) }}
                                        </td>
                                        <td>
                                            {!! $sale->finalized_at ? 'COMPLETADA<br>' . date('d-m-Y', strtotime($sale->finalized_at)) : ($sale->products->count() > 0 ? 'EN PROCESO' : 'EN PROCESO') !!}
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
                            <div class="col-lg-8">
                                <h4 class="card-title"> Productos: {{ $sale->products->sum('qty') }}</h4>
                            </div>
                            <div class="col-lg-4 text-right">
                                @if (!$sale->finalized_at)
                                    <button class="btn btn-primary btn-round modal_add_open"
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
                                <tbody>
                                    @foreach ($sale->products as $sold_product)
                                        <tr>
                                            <td>{{ $sold_product->product->id }}</td>
                                            <td>{{ $sold_product->product->name }}</td>
                                            <td>{{ $sold_product->product->category->name }}</td>
                                            <td>{{ $sold_product->qty }}</td>
                                            <td>{{ format_money($sold_product->price) }}</td>
                                            <td>{{ format_money($sold_product->total_amount) }}</td>
                                            <td class="td-actions text-right">
                                                @if (!$sale->finalized_at)
                                                    <button data-sale="{{ $sale->id }}"
                                                        data-id="{{ $sold_product->product->id }}"
                                                        class="btn btn-primary btn-round btn_edit_product"> <i
                                                            class="far fa-edit"></i> </button>
                                                    <form class="d-inline">
                                                        <button type="button" data-sale="{{ $sale->id }}"
                                                            data-id="{{ $sold_product->product->id }}"
                                                            class="btn btn-danger btn-round btn_delete_product">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
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
                    <form action="" autocomplete="off">

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
                        {{-- 
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Producto </label>
                                    <select id="id_product_open" class="form-control">
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
                                    <input type="number" id="add_cantidad" value="0" min="1" class="form-control"
                                        placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                                </div>
                            </div>
                        </div>
                        
                          <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_add_open">AGREGAR</button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-secondary btn-round"
                                        data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div> --}}
                    </form>
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
                    <form action="" autocomplete="off">
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
                    </form>
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

                console.log(productos);
                const formulario = document.querySelector('#formulario');
                const button = document.querySelector('#button');
                let result = '';
                for (let producto of productos) {

                    $('#resultado').append('<div class="col">' +
                        '<div class="modal_add_cantidad card card_product_search" data-id="'+ producto.id+'">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + producto.product + '</h5>' +
                        '<p class="card-text">' + producto.description + '</p>' +
                        '<p class="card-text">' + producto.price + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                }
                const filtrar = () => {

                    $('#resultado').empty();
                    const texto = formulario.value.toLowerCase();
                    console.log(texto);
                    for (let producto of productos) {
                        let nombre = producto.product.toLowerCase();
                        if (nombre.indexOf(texto) !== -1) {
                            result = 1;
                            $('#resultado').append('<div class="col">' +
                                '<div class="card card_product_search">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">' + producto.product + '</h5>' +
                                '<p class="card-text">' + producto.description + '</p>' +
                                '<p class="card-text">' + producto.price + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        }
                    }
                    if (result !== 1) {
                        $('#resultado').append('<li>NO found</li>');
                    }
                    
                }
                formulario.addEventListener('keyup', filtrar);

            }
        });
    </script>
    <script>

    </script>
    <script>
        function Numeros(string) { //Solo numeros
            var out = '';
            var filtro = '1234567890';
            for (var i = 0; i < string.length; i++)
                if (filtro.indexOf(string.charAt(i)) != -1)
                    out += string.charAt(i);
            //Retornar valor filtrado
            return out;
        }
    </script>
    <script>
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
        //Funcion eliminar
        $('.btn_delete_product').click(function() {
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
                            setTimeout(() => {
                                location.reload();
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
        })
        $('.modal_add_cantidad').click(function() {
            console.log('cantidad');
        })
        $('#add_cantidad').change(function() {})
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
        //Funcion traer datos producto
        $('.btn_edit_product').click(function() {
            let id = $(this).attr("data-id");
            let sale = $(this).attr("data-sale");

            if (id == "") {
                alertify.error('Ocurrio un error, intentelo nuevamente.');
            } else {
                $.ajax({
                    url: '{{ route('get_edit_product') }}',
                    data: {
                        id: id,
                        sale: sale,
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.btn_edit_product').prop('disabled', true);
                        $('.btn_edit_product').empty();
                        $('.btn_edit_product').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                        );
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.response) {
                            $('.btn_edit_product').prop('disabled', false);
                            $('.btn_edit_product').empty();
                            $('.btn_edit_product').append(
                                '<i class="fas fa-edit "></i>'
                            );
                            $('#id_sale_edit').val(response.data.sale_id);
                            $('#edit_product').val(response.data.product_id);
                            $('#edit_cantidad').val(response.data.qty);
                            $('#openEditProduct').modal('show');
                        } else {
                            console.log(response);
                            alertify.error('Ocurrio un error.');
                        }


                    },

                    error: function(x, xs, xt) {
                        console.log(x);
                        alertify.error('Ocurrio un error.');
                    }
                });
            }

        });

        $('.btn_update_open').click(function() {
            var id_prod = $('#edit_product').val();
            var cantidad = $('#edit_cantidad').val();
            var id_sale = $('#id_sale_edit').val();

            let regNumber = /[0-9]+/g;
            if (id_prod == "") {
                alertify.error('El campo producto es requerido.');
            } else if (cantidad == "") {
                alertify.error('El campo cantidad es requerido.');
            } else if (cantidad <= 0) {
                alertify.error('Ingrese una cantidad válida.');
            } else {
                $.ajax({
                    url: '{{ route('updateproduct') }}',
                    data: {
                        id: id_prod,
                        cantidad: cantidad,
                        sale: id_sale,
                    },
                    type: 'post',
                    beforeSend: function() {
                        $('.btn_update_open').prop('disabled', true);
                        $('.btn_update_open').empty();
                        $('.btn_update_open').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Producto actualizado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('.btn_update_open').prop('disabled', false);
                            $('.btn_update_open').empty();
                            $('.btn_update_open').append('EDITAR');
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
    </script>
@endpush
