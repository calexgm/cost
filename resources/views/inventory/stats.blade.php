@extends('layouts.app', ['page' => 'Dashboard', 'pageSlug' => 'istats', 'section' => 'inventory'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-badge text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Usuarios</p>
                                    <p class="card-title">{{ $userscount }}
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Vendedores
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Ventas</p>

                                    <p>
                                </div>
                                <div class="numbers" style="font-size: 1.5em !important;">
                                    <p class="card-title">{{ format_money($sale->sum) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-calendar-o"></i>
                            Ultimo día
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-box-2 text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Productos</p>
                                    <p class="card-title">{{ $productscount }}
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-clock-o"></i>
                            Totales
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-box-2 text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Agotados</p>
                                    <p class="card-title">{{ $productsexhausted }}
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i>
                            Actualizar
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Ventas por mes</h5>
                    </div>
                    <div class="card-body ">
                        <canvas id="myChart" width="400" height="150"></canvas>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Productos mas vendidos</h5>
                    </div>
                    <div class="card-body ">
                        <canvas id="myMore" width="100" height="100"></canvas>
                    </div>

                </div>
            </div>
            <div class="col-md-7">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-title">Ventas por usuario</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="mySales" width="100" height="70"></canvas>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#dashboard").addClass("active");
            $("#categories").removeClass("active");
            $("#products").removeClass("active");
            $("#vents").removeClass("active");
            $("#users").removeClass("active");
            $("#repors").removeClass("active");
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'get_sales_month',
                type: 'post',
                beforeSend: function() {
                },
                success: function(response) {
                    if (response.response) {
                        get_mont_sales(response.data);
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
        });

        function get_mont_sales(data) {
            var valor = [];
            var mes = [];
            data.forEach(element => {
                valor.push(element.sum);
                const date = new Date(element.fecha); // 2009-11-10
                const month = date.toLocaleString('es', {
                    month: 'long'
                });
                mes.push(month);
            });

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: mes,
                    datasets: [{
                        label: 'Meses',
                        data: valor,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
    <!-- More Prods-->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'more_product',
                type: 'post',
                beforeSend: function() {
                },
                success: function(response) {
                    if (response.response) {
                        get_more(response.data);
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
        });

        function get_more(data) {
            var name = [];
            var qtycan = [];
            data.forEach(element => {
                name.push(element.name);
                qtycan.push(element.qty);
            });
            const ctx = document.getElementById('myMore').getContext('2d');
            const myMore = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: name,
                    datasets: [{
                        label: '',
                        data: qtycan,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.3)',
                            'rgba(75, 192, 192, 0.3)',
                            'rgba(255, 205, 86, 0.3)',
                            'rgba(201, 203, 207, 0.3)',
                            'rgba(54, 162, 235, 0.3)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                        }
                    }
                }
            });
        }
    </script>
    <!-- Sales Users-->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'sales_users',
                type: 'post',
                beforeSend: function() {
                },
                success: function(response) {
                    if (response.response) {
                        sales_users(response.data);
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
        });

        function sales_users(data) {
            var name = [];
            var qtycan = [];
            data.forEach(element => {
                name.push(element.name);
                qtycan.push(element.sum);
            });
            console.log(name);
            console.log(qtycan);

            const ctx = document.getElementById('mySales').getContext('2d');
            const mySales = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: name,
                    datasets: [{
                        label: '',
                        data: qtycan,
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(75, 192, 192)',
                            'rgb(255, 205, 86)',
                            'rgb(201, 203, 207)',
                            'rgb(54, 162, 235)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                        }
                    }
                }
            });
        }
    </script>

@endpush

<!--@section('content')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Statistics by Quantity (TOP 15)</h4>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table">
                                                        <thead>
                                                            <th>ID</th>
                                                            <th>Category</th>
                                                            <th>Name</th>
                                                            <th>Stock</th>
                                                            <th>Annual Sales</th>
                                                            <th>Average Price</th>
                                                            <th>Annual Income</th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($soldproductsbystock as $soldproduct)
                                                                <tr>
                                                                    <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product_id }}</a></td>
                                                                    <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                                                    <td>{{ $soldproduct->product->name }}</td>
                                                                    <td>{{ $soldproduct->product->stock }}</td>
                                                                    <td>{{ $soldproduct->total_qty }}</td>
                                                                    <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
                                                                    <td>{{ format_money($soldproduct->incomes) }}</td>
                                                                    <td class="td-actions text-right">
                                                                        <a href="{{ route('products.show', $soldproduct->product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                                            <i class="tim-icons icon-zoom-split"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card card-tasks">
                                                <div class="card-header">
                                                    <h4 class="card-title">Statistics by Income (TOP 15)</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-full-width table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <th>ID</th>
                                                                <th>Category</th>
                                                                <th>Name</th>
                                                                <th>Sold</th>
                                                                <th>Income</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($soldproductsbyincomes as $soldproduct)
                                                                    <tr>
                                                                        <td>{{ $soldproduct->product_id }}</td>
                                                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                                                        <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                                                        <td>{{ $soldproduct->total_qty }}</td>
                                                                        <td>{{ format_money($soldproduct->incomes) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-tasks">
                                                <div class="card-header">
                                                    <h4 class="card-title">Statistics by Average Price (TOP 15)</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-full-width table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <th>ID</th>
                                                                <th>Category</th>
                                                                <th>Name</th>
                                                                <th>Sold</th>
                                                                <th>Average Price</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($soldproductsbyavgprice as $soldproduct)
                                                                    <tr>
                                                                        <td>{{ $soldproduct->product_id }}</td>
                                                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                                                        <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                                                        <td>{{ $soldproduct->total_qty }}</td>
                                                                        <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
@endsection-->
