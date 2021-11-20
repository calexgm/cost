@extends('layouts.app', ['page' => 'Ventas', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="card-title"> Ventas</h4>
                            </div>
                            <div class="col-lg-4 text-right">
                                <form method="post" action="{{ route('create_sale') }}" name="form_create">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-round modal_add_sales"><i
                                            class="fas fa-plus-circle"></i>
                                        AGREGAR
                                        VENTA</button>
                                </form>
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
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($sale->created_at)) }}</td>
                                            <td>{{ $sale->user->name }}</td>
                                            <td>{{ $sale->products->count() }}</td>
                                            <td>{{ $sale->products->sum('qty') }}</td>
                                            <td>
                                                {{ format_money($sale->total_amount) }}
                                            </td>
                                            <td>
                                                @if (!$sale->finalized_at)
                                                    <span class="text-danger">EN PROCESO</span>
                                                @else
                                                    <span class="text-success">FINALIZADA</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <form method="post">
                                                    <a href="{{ route('sales.show', ['sale' => $sale]) }}"
                                                        class="btn btn-primary btn-round btn_edit_product"> <i
                                                            class="far fa-edit"></i></a>
                                                </form>
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
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("#dashboard").removeClass("active");
            $("#categories").removeClass("active");
            $("#products").removeClass("active");
            $("#vents").addClass("active");
            $("#users").removeClass("active");
            $("#repors").removeClass("active");
        });
    </script>


    <script>
        $('.modal_add_sales').click(function() {
            $('.modal_add_sales').prop('disabled', true);
            $('.modal_add_sales').empty();
            $('.modal_add_sales').append(
                '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
            );

            document.form_create.submit().submit();
        });
    </script>
@endpush