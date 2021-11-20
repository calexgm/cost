@extends('layouts.app', ['page' => 'Productos', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="card-title"> Productos</h4>
                            </div>
                            <div class="col-lg-3 text-right">
                                <button class="btn btn-primary btn-round modal_add_stock"><i class="fas fa-plus-circle"></i>
                                    AGREGAR STOCK</button>
                            </div>
                            <div class="col-lg-3 text-right">
                                <button class="btn btn-primary btn-round modal_add_product"><i
                                        class="fas fa-plus-circle"></i>
                                    AGREGAR
                                    PRODUCTO</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tblUsers">
                                <thead class="">
                                    <th>
                                        PRODUCTO
                                    </th>
                                    <th>
                                        VALOR UNITARIO
                                    </th>
                                    <th>
                                        CANTIDAD
                                    </th>
                                    <th>
                                        ESTADO
                                    </th>
                                    <th class="text-right">

                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($products as $prod)
                                        <tr>
                                            <td>
                                                {{ $prod->product }}
                                            </td>
                                            <td>
                                                {{ format_money($prod->price) }}
                                            </td>
                                            <td>
                                                {{ $prod->stock }}
                                            </td>
                                            <td>
                                                @if ($prod->status == 1)
                                                    Activo
                                                @else
                                                    Inactivo
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <form method="post">
                                                    @if ($prod->status == 1)
                                                        <button type="button" data-id="{{ $prod->id }}"
                                                            class="btn btn-secondary btn-round btn_show_product"> <i
                                                                class="fas fa-info-circle"></i></button>
                                                        <button type="button" data-id="{{ $prod->id }}"
                                                            class="btn btn-primary btn-round btn_edit_product"> <i
                                                                class="far fa-edit"></i></button>
                                                        <button type="button" data-status="{{ $prod->status }}"
                                                            data-idd="{{ $prod->id }}"
                                                            class="btn btn-success btn-round btn_status_product"><i
                                                                class="fas fa-lock-open"></i></button>
                                                    @else
                                                        <button type="button" data-id="{{ $prod->id }}"
                                                            class="btn btn-secondary btn-round btn_show_product"> <i
                                                                class="fas fa-info-circle"></i></button>
                                                        <button type="button" data-id="{{ $prod->id }}"
                                                            class="btn btn-primary btn-round btn_edit_product"> <i
                                                                class="far fa-edit "></i></button>
                                                        <button type="button" data-status="{{ $prod->status }}"
                                                            data-idd="{{ $prod->id }}"
                                                            class="btn btn-danger btn-round btn_status_product"><i
                                                                class="fas fa-lock"></i></button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="container">
                            <div class="row">
                                @foreach ($products as $card)
                                    <div class="col">
                                        <div class="card card_product">
                                            <img src="images/products/{{ $card->image }}" class="card-img-top card_img"
                                                alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $card->product }}</h5>
                                                <p class="card-text">{{ $card->description }}</p>
                                                <p class="card-text">{{ $card->price }}</p>
                                            </div>
                                            <div class="row text-center">
                                                @if ($prod->status == 1)
                                                    <div class="col">
                                                        <button type="button" data-id="{{ $card->id }}"
                                                            class="btn btn-secondary btn-round btn_show_product"> <i
                                                                class="fas fa-info-circle"></i></button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" data-id="{{ $card->id }}"
                                                            class="btn btn-primary btn-round btn_edit_product"> <i
                                                                class="far fa-edit"></i></button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" data-status="{{ $card->status }}"
                                                            data-idd="{{ $card->id }}"
                                                            class="btn btn-success btn-round btn_status_product"><i
                                                                class="fas fa-lock-open"></i></button>
                                                    </div>


                                                @else
                                                    <div class="col">
                                                        <button type="button" data-id="{{ $card->id }}"
                                                            class="btn btn-secondary btn-round btn_show_product"> <i
                                                                class="fas fa-info-circle"></i></button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" data-id="{{ $card->id }}"
                                                            class="btn btn-primary btn-round btn_edit_product"> <i
                                                                class="far fa-edit "></i></button>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" data-status="{{ $card->status }}"
                                                            data-idd="{{ $card->id }}"
                                                            class="btn btn-danger btn-round btn_status_product"><i
                                                                class="fas fa-lock"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ====================================================================================================  -->
    <!-- Modal Show -->
    <div class="modal fade" id="showProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <div class="row text-center">
                            <div class="col">
                                <fieldset>
                                    <div class="input-file-row-1">
                                        <div class="upload-file-container_edit">
                                            <img id="preview_image_show" src="" alt="" />
                                            <div class="upload-file-container-text">
                                                <div class='one_opacity_0'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre </label>
                                    <input type="text" id="show_name" class="form-control" placeholder="Producto"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="text" maxlength="10" id="show_precio" class="form-control"
                                        placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" disabled />
                                </div>
                            </div>
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" id="show_cantidad" min="1" class="form-control"
                                        placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Categoría </label>
                                    <select id="show_categoria" class="form-control" disabled>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Descripción </label>
                                    <textarea class="form-control" id="show_descripcion" cols="52" rows="3"
                                        disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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

    <!-- Modal Editar -->
    <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" id="id_product" class="form-control" style="visibility: hidden;">
                        <div class="row text-center">
                            <div class="col">
                                <fieldset>
                                    <div class="input-file-row-1">
                                        <div class="upload-file-container_edit">
                                            <img id="preview_image_edit" src="" alt="" />
                                            <div class="upload-file-container-text">
                                                <div class='one_opacity_0'>
                                                    <input accept=".png,.jpg,.jpeg" name="photo" type="file"
                                                        id="patient_pic_edit" label="add" />
                                                </div>
                                                <span>EDITAR FOTO</span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre </label>
                                    <input type="text" id="edit_name" class="form-control" placeholder="Producto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="text" maxlength="10" id="edit_precio" class="form-control"
                                        placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" />
                                </div>
                            </div>
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" id="edit_cantidad" min="1" class="form-control"
                                        placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Categoría </label>
                                    <select id="edit_categoria" class="form-control">
                                        <option value="">Seleccione una categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Descripción </label>
                                    <textarea class="form-control" id="edit_descripcion" cols="52" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button"
                                        class="btn btn-success btn-round btn_update_product">EDITAR</button>
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
    <!-- Modal STOCK -->
    <div class="modal fade" id="stockProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Producto </label>
                                    <select id="id_product_stock" class="form-control">
                                        <option value="">Seleccione un producto</option>
                                        @foreach ($products as $produc)
                                            <option value="{{ $produc->id }}">{{ $produc->product }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" id="add_cantidad_stock" value="1" min="1" class="form-control"
                                        placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_add_stock">AGREGAR</button>
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
    <!-- Modal Agregar -->
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <div class="row text-center">
                            <div class="col">
                                <fieldset>
                                    <div class="input-file-row-1">
                                        <div class="upload-file-container">
                                            <img id="preview_image" alt="" />
                                            <div class="upload-file-container-text">
                                                <div class='one_opacity_0'>
                                                    <input accept=".png,.jpg,.jpeg" name="photo" type="file"
                                                        id="patient_pic" label="add" />
                                                </div>
                                                <span>AGREGAR FOTO</span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre </label>
                                    <input type="text" id="add_name" class="form-control" placeholder="Producto">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="text" maxlength="10" id="add_precio" class="form-control"
                                        placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" />
                                </div>
                            </div>
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" id="add_cantidad" value="1" min="1" class="form-control"
                                        placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Categoría </label>
                                    <select id="add_categoria" class="form-control">
                                        <option value="">Seleccione una categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Descripción </label>
                                    <textarea class="form-control" id="add_descripcion" cols="52" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button"
                                        class="btn btn-success btn-round btn_add_product">AGREGAR</button>
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
        function Numeros(string) { //Solo numeros
            var out = '';
            var filtro = '1234567890';
            for (var i = 0; i < string.length; i++)
                if (filtro.indexOf(string.charAt(i)) != -1)
                    out += string.charAt(i);
            //Retornar valor filtrado
            return out;
        }

        //IMAGEN CARGAR
        function readURL(input, target) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var image_target = $(target);
                reader.onload = function(e) {
                    image_target.attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#patient_pic").change(function() {
            readURL(this, "#preview_image")
        });

        $("#patient_pic_edit").change(function() {
            readURL(this, "#preview_image_edit")
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#tblUsers').DataTable({
                    language: {
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
                    },
                }

            );
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#dashboard").removeClass("active");
            $("#categories").removeClass("active");
            $("#products").addClass("active");
            $("#vents").removeClass("active");
            $("#users").removeClass("active");
            $("#repors").removeClass("active");
        });
        //Funcion cambiar estado
        $('.btn_status_product').click(function() {
            var idd = $(this).attr("data-idd");
            var status = $(this).attr("data-status");
            let statusDef = "";
            let tittle = "";
            let message = "";
            if (status == 1) {
                statusDef = 0;
                tittle = "Inactivar";
                message = "¿Está segur@ de inactivar este producto?";
            } else {
                statusDef = 1;
                tittle = "Activar";
                message = "¿Está segur@ de activar este producto?";
            }
            alertify.confirm(tittle, message, function() {
                //OK
                $.ajax({
                    url: 'status_product',
                    data: {
                        id: idd,
                        status: statusDef,
                    },
                    type: 'put',
                    beforeSend: function() {},
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Estado actualizado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            alertify.error(
                                'Ocurrio un error al actualizar el estado, intentelo nuevamente.'
                            );
                        }

                    },

                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error al intentar' + tittle +
                            ', intentelo nuevamente.');
                        console.log(x);
                    }
                });
            }, function() {
                //Cancel
            });

        });
        //Funcion show producto
        $('.btn_show_product').click(function() {
            var id = $(this).attr("data-id");

            if (id == "") {
                alertify.error('Ocurrio un error, intentelo nuevamente.');
            } else {
                $.ajax({
                    url: 'edit_product_modal',
                    data: {
                        id: id,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_show_product').prop('disabled', true);
                        $('.btn_show_product').empty();
                        $('.btn_show_product').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            $('.btn_show_product').prop('disabled', false);
                            $('.btn_show_product').empty();
                            $('.btn_show_product').append(
                                '<i class="fas fa-info-circle"></i></button>'
                            );
                            $('#show_name').val(response.data.name);
                            $('#show_precio').val(response.data.price);
                            $('#show_cantidad').val(response.data.stock);
                            $('#show_categoria').val(response.data.product_category_id);
                            $('#show_descripcion').val(response.data.description);
                            let img = "images/products/" + response.data.image + "";
                            $('#preview_image_show').attr('src', img);
                            $('#showProduct').modal('show');
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
        //Funcion traer datos producto
        $('.btn_edit_product').click(function() {
            var id = $(this).attr("data-id");

            if (id == "") {
                alertify.error('Ocurrio un error, intentelo nuevamente.');
            } else {
                $.ajax({
                    url: 'edit_product_modal',
                    data: {
                        id: id,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_edit_product').prop('disabled', true);
                        $('.btn_edit_product').empty();
                        $('.btn_edit_product').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            $('.btn_edit_product').prop('disabled', false);
                            $('.btn_edit_product').empty();
                            $('.btn_edit_product').append(
                                '<i class="fas fa-edit "></i>'
                            );
                            $('#id_product').val(response.data.id);
                            $('#edit_name').val(response.data.name);
                            $('#edit_precio').val(response.data.price);
                            $('#edit_cantidad').val(response.data.stock);
                            $('#edit_categoria').val(response.data.product_category_id);
                            $('#edit_descripcion').val(response.data.description);
                            let img = "images/products/" + response.data.image + "";
                            $('#preview_image_edit').attr('src', img);
                            $('#editProduct').modal('show');
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
        //Funcion editar producto
        $('.btn_update_product').click(function() {
            var avatarInput = $('#patient_pic_edit');
            var formData = new FormData();
            var id = $('#id_product').val();
            var name = $('#edit_name').val();
            var precio = $('#edit_precio').val();
            var cantidad = $('#edit_cantidad').val();
            var categoria = $('#edit_categoria').val();
            var descripcion = $('#edit_descripcion').val();
            let regText = /[A-Za-z0-9]+/g;
            let regNumber = /[0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre es requerido.');
            } else if (!regText.test(name) || name.length < 5) {
                alertify.error('Ingrese un nombre válido.');
            } else if (precio == "") {
                alertify.error('El campo precio es requerido.');
            } else if (!regNumber.test(precio) || precio <= 0) {
                alertify.error('Ingrese un precio válido.');
            } else if (cantidad == "") {
                alertify.error('El campo cantidad es requerido.');
            } else if (cantidad <= 0) {
                alertify.error('Ingrese una cantidad válida.');
            } else if (categoria == "") {
                alertify.error('El campo categoría es requerido.');
            } else if (descripcion == "") {
                alertify.error('El campo descripción es requerido.');
            } else if (!regText.test(descripcion)) {
                alertify.error('Ingrese una descripción válida.');
            } else {
                formData.append('photo', avatarInput[0].files[0]);
                formData.append('id', id);
                formData.append('name', name);
                formData.append('precio', precio);
                formData.append('cantidad', cantidad);
                formData.append('categoria', categoria);
                formData.append('descripcion', descripcion);
                $.ajax({
                    url: 'update_product',
                    data: formData,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.btn_update_category').prop('disabled', true);
                        $('.btn_update_category').empty();
                        $('.btn_update_category').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {

                        if (response.response) {
                            alertify.success('Producto editado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            $('.btn_update_category').prop('disabled', false);
                            $('.btn_update_category').empty();
                            $('.btn_update_category').append('Editar');
                            alertify.error('Ocurrio un error al editar el producto.');
                        }
                    },
                    error: function(x, xs, xt) {
                        console.log(x);
                        alertify.error('Ocurrio un error.');
                    }
                });
            }

        });
        //añadir stock

        $('.modal_add_stock').click(function() {
            $('#stockProduct').modal('show');
        })
        $('.btn_add_stock').click(function() {
            var id_prod = $('#id_product_stock').val();
            var cantidad = $('#add_cantidad_stock').val();
            let regNumber = /[0-9]+/g;
            if (id_prod == "") {
                alertify.error('El campo Producto es requerido.');
            } else if (cantidad == "") {
                alertify.error('El campo cantidad es requerido.');
            } else if (cantidad <= 0) {
                alertify.error('Ingrese una cantidad válida.');
            } else {
                $.ajax({
                    url: 'add_product_stock',
                    data: {
                        id: id_prod,
                        cantidad: cantidad
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_add_product').prop('disabled', true);
                        $('.btn_add_product').empty();
                        $('.btn_add_product').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            alertify.success('Stock agregado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            $('.btn_add_product').prop('disabled', false);
                            $('.btn_add_product').empty();
                            $('.btn_add_product').append('AGREGAR');
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
        //Funcion agregar producto
        $('.modal_add_product').click(function() {
            $('#addProduct').modal('show');
        })
        $('.btn_add_product').click(function() {
            var avatarInput = $('#patient_pic');
            var formData = new FormData();
            var name = $('#add_name').val();
            var precio = $('#add_precio').val();
            var cantidad = $('#add_cantidad').val();
            var categoria = $('#add_categoria').val();
            var descripcion = $('#add_descripcion').val();
            let regText = /[A-Za-z0-9]+/g;
            let regNumber = /[0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre es requerido.');
            } else if (!regText.test(name) || name.length < 5) {
                alertify.error('Ingrese un nombre válido.');
            } else if (precio == "") {
                alertify.error('El campo precio es requerido.');
            } else if (!regNumber.test(precio) || precio <= 0) {
                alertify.error('Ingrese un precio válido.');
            } else if (cantidad == "") {
                alertify.error('El campo cantidad es requerido.');
            } else if (cantidad <= 0) {
                alertify.error('Ingrese una cantidad válida.');
            } else if (categoria == "") {
                alertify.error('El campo categoría es requerido.');
            } else if (descripcion == "") {
                alertify.error('El campo descripción es requerido.');
            } else if (!regText.test(descripcion)) {
                alertify.error('Ingrese una descripción válida.');
            } else {
                formData.append('photo', avatarInput[0].files[0]);
                formData.append('name', name);
                formData.append('precio', precio);
                formData.append('cantidad', cantidad);
                formData.append('categoria', categoria);
                formData.append('descripcion', descripcion);
                $.ajax({
                    url: 'add_product',
                    data: formData,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.btn_add_product').prop('disabled', true);
                        $('.btn_add_product').empty();
                        $('.btn_add_product').append(
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
                            $('.btn_add_product').prop('disabled', false);
                            $('.btn_add_product').empty();
                            $('.btn_add_product').append('AGREGAR');
                            if (response.error) {
                                alertify.error(
                                    'El producto que intenta agregar ya se encuentra registrado.');
                            } else {
                                alertify.error('Ocurrio un error al agregar el producto.');
                            }
                        }
                    },
                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error al agregar el producto.');
                        console.log(x);
                    }
                });
            }

        });
    </script>
@endpush
