@extends('layouts.app', ['page' => 'Bodega', 'pageSlug' => 'products', 'section' => 'inventory']) @section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title"> Bodega</h4>
                        </div>
                        <div class="col-lg-6 text-right">
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
                                    CÓDIGO DE BARRAS
                                </th>
                                <th class="text-center">

                                </th>
                            </thead>
                            <tbody>
                                @foreach ($products as $prod) @if ($prod->stock == 0)
                                <tr class="table-danger">
                                    @else
                                    <tr>
                                        @endif
                                        <td>
                                            {{ $prod->product }}
                                        </td>
                                        <td>
                                            {{ number_format($prod->price) }}
                                        </td>
                                        <td>
                                            {{ $prod->stock }}
                                        </td>
                                        <td>
                                            {{ $prod->code_bar }}
                                            <!--<img id="list_img" src="images/products/{{ $prod->image }}" class="card_img_tbl" alt="imagen producto"> -->
                                        </td>
                                        <td class="">
                                            <form method="post">
                                                <a href="#" data-id="{{ $prod->id }}" data-code_bar="{{ $prod->code_bar }}" data-name="{{ $prod->product }}" data-price="{{ $prod->price }}" data-stock="{{ $prod->stock }}" data-category="{{ $prod->category }}" data-description="{{ $prod->description }}"
                                                    data-image="{{ $prod->image }}" class="btn_show_product text-secondary"> <i class="fas fa-info-circle fa-2x"></i></a>
                                                <a href="#" data-id="{{ $prod->id }}" data-code_bar="{{ $prod->code_bar }}" data-name="{{ $prod->product }}" data-price="{{ $prod->price }}" data-stock="{{ $prod->stock }}" data-category="{{ $prod->category }}" data-description="{{ $prod->description }}"
                                                    data-image="{{ $prod->image }}" class="btn_edit_product text-primary"> <i class="far fa-edit fa-2x"></i></a>
                                                <a href="#" data-status="{{ $prod->status }}" data-idd="{{ $prod->id }}" class="btn_status_product text-success">
                                                    <i class="fas fa-external-link-alt fa-2x"></i></a>

                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--<div class="container">
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
                        </div>-->
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
                    <div class="row text-center" style="display:none;">
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
                                <label>Código de barras</label>
                                <input type="text" id="show_code" class="form-control" placeholder="Código de barras" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Nombre </label>
                                <input type="text" id="show_name" class="form-control" placeholder="Producto" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" maxlength="10" id="show_precio" class="form-control" placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" disabled />
                            </div>
                        </div>
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="show_cantidad" min="1" class="form-control" placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)" disabled>
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
                                <textarea class="form-control" id="show_descripcion" cols="52" rows="3" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancelar</button>
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
                    <div class="row text-center" style="display: none;">
                        <div class="col">
                            <fieldset>
                                <div class="input-file-row-1">
                                    <div class="upload-file-container_edit">
                                        <img id="preview_image_edit" src="" alt="" />
                                        <div class="upload-file-container-text">
                                            <div class='one_opacity_0'>
                                                <input accept=".png,.jpg,.jpeg" name="photo" type="file" id="patient_pic_edit" label="add" />
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
                                <label>Código de barras</label>
                                <input type="text" id="edit_code" class="form-control" placeholder="Código de barras">
                            </div>
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
                                <input type="text" maxlength="10" id="edit_precio" class="form-control" placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" />
                            </div>
                        </div>
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="edit_cantidad" min="1" class="form-control" placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
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
                                <button type="button" class="btn btn-success btn-round btn_update_product">EDITAR</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancelar</button>
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
                <button type="button" class="close close_scann_add">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container" id="div_scann_add">
                    <div class="row">
                        <div class="col" id="id_scann">
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col">
                            <button class="btn btn-success btn-continuar btn-round">CONTINUAR</button>
                        </div>
                    </div>
                </div>
                <div class="container" id="div_add_prod">
                    <div class="row text-center" style="display: none;">
                        <div class="col">
                            <fieldset>
                                <div class="input-file-row-1">
                                    <div class="upload-file-container">
                                        <img id="preview_image" alt="" />
                                        <div class="upload-file-container-text">
                                            <div class='one_opacity_0'>
                                                <input accept=".png,.jpg,.jpeg" name="photo" type="file" id="patient_pic" label="add" />
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
                                <label>Código de barras </label>
                                <input type="number" id="code_bar" class="form-control" placeholder="Código de barras">
                            </div>
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
                                <input type="text" maxlength="10" id="add_precio" class="form-control" placeholder="Valor unitario" onkeyup="this.value=Numeros(this.value)" />
                            </div>
                        </div>
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="add_cantidad" value="1" min="1" class="form-control" placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
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
                                <button type="button" class="btn btn-success btn-round btn_add_product">AGREGAR</button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container" id="div_add_stock">
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <input type="hidden" id="id_product_stock">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" id="id_scannn">
                            <div class="list-group">
                                <div href="#" class="list-group-item list-group-item-action">
                                    <div class="container text-center">
                                        <img id="list_img" src="images/products/producto.png" class="card-img-top card_img_stock" alt="imagen producto">
                                    </div>
                                    <div class="d-flex w-100 justify-content-between" id="list_product">

                                    </div>
                                    <p class="mb-1" id="list_description">Descripcion</p>
                                    <p class="mb-1" id="list_price">Precio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="add_cantidad_stock" value="1" min="1" class="form-control" placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
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
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Sacar -->
<div class="modal fade" id="modal_salir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Salida de bodega</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="" autocomplete="off">
                    <input type="hidden" id="id_product_salir" class="form-control" style="visibility: hidden;">
                    <div class="row">
                        <div class="col pl-4 pr-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="check_pass" name="check_pass">
                                <label class="custom-control-label" for="check_pass">Todas las unidades</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="salir_count">
                        <div class="col pl-4 pr-4">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" id="exit_cantidad" min="1" value="1" class="form-control" placeholder="Cantidad" onkeyup="this.value=Numeros(this.value)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-right">
                                <button type="button" class="btn btn-success btn-round btn_exit_product">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








@endsection @push('js')
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
        $("#products_ware").addClass("active");
    });

    //open salir 
    $('.btn_status_product').click(function() {
        let id = $(this).attr("data-idd");
        $('#id_product_salir').val(id);
        $('#modal_salir').modal('show');
    });


    $('#check_pass').change(function() {
        if ($(this).prop('checked')) {
            $('#salir_count').hide();
        }else{
            $('#salir_count').show();
        }
    });
    

    //Funcion cambiar estado
    $('.btn_exit_product').click(function() {
        var idd = $('#id_product_salir').val();
        let all = $("#check_pass").prop('checked');
        let count = $('#exit_cantidad').val();
        let allval = 0;
        let cantidad = 0;
        if(all == false){
            allval = 0;
            cantidad = count;
        }else {
            allval = 1;
            cantidad = 0;
        }
        alertify.confirm('Bodega', 'Sacar de bodega', function() {
            //OK
            $.ajax({
                url: 'status_product_ware',
                data: {
                    id: idd,
                    allval: allval,
                    cantidad: cantidad
                },
                type: 'put',
                beforeSend: function() {},
                success: function(response) {
                    if (response.response) {
                        alertify.success(response.msg);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        alertify.error(response.msg);
                    }
                },
                error: function(x, xs, xt) {
                    alertify.error('Ocurrio un error, intentelo nuevamente');
                    console.log(x);
                }
            });
        }, function() {
            //Cancel
        });

    });
    //Funcion show producto
    $('.btn_show_product').click(function() {
        let name = $(this).attr("data-name");
        let code_bar = $(this).attr("data-code_bar");
        let price = $(this).attr("data-price");
        let stock = $(this).attr("data-stock");
        let category = $(this).attr("data-category");
        let description = $(this).attr("data-description");
        let image = $(this).attr("data-image");

        $('#show_code').val(code_bar);
        $('#show_name').val(name);
        $('#show_precio').val(price);
        $('#show_cantidad').val(stock);
        $('#show_categoria').val(category);
        $('#show_descripcion').val(description);
        let img = "images/products/" + image + "";
        $('#preview_image_show').attr('src', img);
        $('#showProduct').modal('show');
    });
    //Funcion traer datos producto
    $('.btn_edit_product').click(function() {
        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");
        let code_bar = $(this).attr("data-code_bar");
        let price = $(this).attr("data-price");
        let stock = $(this).attr("data-stock");
        let category = $(this).attr("data-category");
        let description = $(this).attr("data-description");
        let image = $(this).attr("data-image");

        $('#id_product').val(id);
        $('#edit_code').val(code_bar);
        $('#edit_name').val(name);
        $('#edit_precio').val(price);
        $('#edit_cantidad').val(stock);
        $('#edit_categoria').val(category);
        $('#edit_descripcion').val(description);
        let img = "images/products/" + image + "";
        $('#preview_image_edit').attr('src', img);
        $('#editProduct').modal('show');
    });
    //Funcion editar producto
    $('.btn_update_product').click(function() {
        var avatarInput = $('#patient_pic_edit');
        var formData = new FormData();
        var id = $('#id_product').val();
        var code = $('#edit_code').val();
        var name = $('#edit_name').val();
        var precio = $('#edit_precio').val();
        var cantidad = $('#edit_cantidad').val();
        var categoria = $('#edit_categoria').val();
        var descripcion = $('#edit_descripcion').val();
        let regText = /[A-Za-z0-9]+/g;
        let regNumber = /[0-9]+/g;
        if (code == "") {
            alertify.error('El campo código de barras es requerido.');
        } else if (name == "") {
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
        } else if (categoria == "" || categoria == null) {
            alertify.error('El campo categoría es requerido.');
        } else if (descripcion == "") {
            alertify.error('El campo descripción es requerido.');
        } else if (!regText.test(descripcion)) {
            alertify.error('Ingrese una descripción válida.');
        } else {
            let photo = "";
            if (avatarInput[0].files[0]) {
                photo = avatarInput[0].files[0];
            } else {
                photo = "";
            }
            formData.append('photo', photo);
            formData.append('id', id);
            formData.append('code', code);
            formData.append('name', name);
            formData.append('precio', precio);
            formData.append('cantidad', cantidad);
            formData.append('categoria', categoria);
            formData.append('descripcion', descripcion);

            $.ajax({
                url: 'update_product_ware',
                data: formData,
                type: 'post',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btn_update_product').prop('disabled', true);
                    $('.btn_update_product').empty();
                    $('.btn_update_product').append(
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
                        $('.btn_update_product').prop('disabled', false);
                        $('.btn_update_product').empty();
                        $('.btn_update_product').append('Editar');
                        alertify.error('Ocurrio un error al editar el producto.');
                    }
                },
                error: function(x, xs, xt) {
                    console.log(x);
                    alertify.error('Ocurrio un error.');
                    $('.btn_update_product').prop('disabled', false);
                    $('.btn_update_product').empty();
                    $('.btn_update_product').append('Editar');
                    alertify.error('Ocurrio un error al editar el producto.');
                }
            });
        }

    });
    $('.btn_add_stock').click(function() {
        var id_prod = $('#id_product_stock').val();
        var cantidad = $('#add_cantidad_stock').val();
        let regNumber = /[0-9]+/g;
        if (id_prod == "") {
            alertify.error('Producto no válido.');
        } else if (cantidad == "") {
            alertify.error('El campo cantidad es requerido.');
        } else if (cantidad <= 0) {
            alertify.error('Ingrese una cantidad válida.');
        } else {
            $.ajax({
                url: 'add_product_stock_ware',
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
    //Abrir modal agregar
    $('.modal_add_product').click(function() {
        $('#id_scann').empty();
        $('#id_scann').append('<div id="scandit-barcode-picker"></div>');
        $('#div_scann_add').show();
        $('#div_add_prod').hide();
        $('#div_add_stock').hide();
        $('#addProduct').modal('show');
        $('#addProduct').modal({
            backdrop: 'static',
            keyboard: false
        });
        //Confuguración
        ScanditSDK.configure(
                "AdUgSxxNPcDNJN3l0DyLzyI/AtdVI/XfOVjwVrRT/oKPOM8XmQqkPudFiJJuN8IMchaasu9eC6tDa1amawvip7gG/oqFVmKMfkpHB9s1caqdHB1oyS7ZpZgdaEaNLQ0BlAs2X6gYDeVbZJ9TgC0rZVdBRNOr6PNyuITaENjwX55rRAuN24UZTgG2SIZS6xaNY7PMaDctQjI4XwHdh3qnqft5s6BAifp5CgVtRkvzNAC2LkiW62ABQXY2Qvlbe77PKq3V1DCw6bQN/d2Csy0n6OiZ1epmaU4WG++dwhfDJjNlciU12tH7bleWXHKWokGi9d7hzDeFxS1pJX6xxJHsOndArL0gWDCEflVasoMl7kOQFCk98yMcynWW4rVwUV1z3biZXvMwjms+S3xwxL5/wfhuD/7urR38RdZieD9jeCL1y5F0UhPPj3mHF3jiIhU5v6mhS08ZxXgnAQQY2qV0/mD75uWnWljj/Pu0itbzB5/yZPDYEM5M7FsXcEvBYKLv726QSwfl+EHW/lLNTVQOJKBoG2xmizcuW5Z3ryYD04U3Bk5HlBP97Nch8BxnprTfPqJdhQ0W9YEvNSRwL2P4Xz8c1VqFma90uAQRnsS550LWvUck9YqaOSniSw4UbYfpUiy2+jsa9OibrSEKqXoovL11n6CDnBU/ugbm1mX5JsTFwheNaoYaE3YNEJgxrKvbYTvvpGGYh80Yanjlo/muGEoAfxHnUNIUnHQ+irSJAzpMEf8upNb2JL00arMvCaJ88kyyRnnenCz3slcLyu/j9ESlSiH9lRbe8QfrJ7tyeQ==", {
                    engineLocation: "https://cdn.jsdelivr.net/npm/scandit-sdk@5.x/build/",
                })
            .then(() => {
                return ScanditSDK.BarcodePicker.create(document.getElementById("scandit-barcode-picker"), {
                    //playSoundOnScan: true,
                    vibrateOnScan: true,
                    scanSettings: new ScanditSDK.ScanSettings({
                        enabledSymbologies: ["ean8", "ean13", "upca", "upce"]
                    }),
                });
            })
            .then((barcodePicker) => {
                barcodePicker.on("scan", (scanResult) => {
                    let code = scanResult.barcodes[0].data;
                    if (code != '') {
                        $.ajax({
                            url: '{{ route('exist_ware') }}',
                            data: {
                                code: code,
                            },
                            type: 'post',
                            beforeSend: function() {

                            },
                            success: function(response) {
                                if (response.response) {
                                    if (response.data) {
                                        let data = response.data;
                                        //informacion de producto
                                        $('#id_product_stock').val(data.id);
                                        let img = "images/products/" + data.image + "";
                                        $('#list_img').attr('src', img);
                                        $('#list_product').empty();
                                        if (data.stock > 0) {
                                            $('#list_product').append('<h5 class="mb-1">' + data.name + '</h5>' +
                                                '<small id="list_stock" class="text-success">Cantidad: ' + data.stock + '</small>');
                                        } else {
                                            $('#list_product').append('<h5 class="mb-1" >' + data.name + '</h5>' +
                                                '<small id="list_stock" class="text-danger">Cantidad: ' + data.stock + '</small>');
                                        }
                                        $('#list_stock').empty();
                                        $('#list_stock').append('Cantidad: ' + data.stock + '');
                                        $('#list_description').empty();
                                        $('#list_description').append('' + data.description + '');
                                        $('#list_price').empty();
                                        $('#list_price').append('' + data.price + '');
                                        //fin información
                                        $('#div_scann_add').hide();
                                        $('#div_add_stock').show();
                                        $('#div_add_prod').hide();
                                    } else {
                                        $('#code_bar').val(code);
                                        $('#div_scann_add').hide();
                                        $('#div_add_stock').hide();
                                        $('#div_add_prod').show();
                                    }
                                } else {
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
            });
    })
    $('.close_scann_add').click(function() {
        $('#addProduct').modal('hide');
        $('#id_scann').empty();
    });
    //Funcion que agrega
    $('.btn_add_product').click(function() {
        var avatarInput = $('#patient_pic');
        var formData = new FormData();
        var codebar = $('#code_bar').val();
        var name = $('#add_name').val();
        var precio = $('#add_precio').val();
        var cantidad = $('#add_cantidad').val();
        var categoria = $('#add_categoria').val();
        var descripcion = $('#add_descripcion').val();
        let regText = /[A-Za-z0-9]+/g;
        let regNumber = /[0-9]+/g;
        if (codebar == "") {
            alertify.error('El campo código de barras es requerido.');
        } else if (name == "") {
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
            formData.append('codebar', codebar);
            formData.append('name', name);
            formData.append('precio', precio);
            formData.append('cantidad', cantidad);
            formData.append('categoria', categoria);
            formData.append('descripcion', descripcion);
            $.ajax({
                url: 'add_product_ware',
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
<!--Scann agregar-->
<script>
    $(document).on('click', '.btn-continuar', function() {
        $('#div_scann_add').hide();
        $('#div_add_prod').show();
    });
</script>
@endpush