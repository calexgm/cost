@extends('layouts.app', ['page' => 'Categorías', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="card-title"> Categorías</h4>
                            </div>
                            <div class="col-lg-4 text-right">
                                <button class="btn btn-primary btn-round modal_add_category"><i class="fas fa-plus-circle"></i>
                                    AGREGAR
                                    CATEGORÍA</button>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tblUsers">
                                <thead class=" text-primary">
                                    <th>
                                        NOMBRE
                                    </th>
                                    <th>
                                        PRODUCTOS
                                    </th>
                                    <th>
                                        FECHA DE CREACIÓN
                                    </th>
                                    <th>
                                        ESTADO
                                    </th>
                                    <th class="text-right">

                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                {{ $category->name }}
                                            </td>
                                            <td>
                                                {{ count($category->products) }}

                                            </td>
                                            <td>
                                                {{ $category->created_at }}
                                            </td>
                                            <td>
                                                @if ($category->status == 1)
                                                    Activo
                                                @else
                                                    Inactivo
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <form method="post">
                                                    @if ($category->status == 1)
                                                        <button type="button" data-id="{{ $category->id }}"
                                                            class="btn btn-primary btn-round btn_edit_category"> <i
                                                                class="far fa-edit"></i></button>
                                                        <button type="button" data-status="{{ $category->status }}"
                                                            data-idd="{{ $category->id }}"
                                                            class="btn btn-success btn-round btn_status_category"><i
                                                                class="fas fa-lock-open"></i></button>
                                                    @else
                                                        <button type="button" data-id="{{ $category->id }}"
                                                            class="btn btn-primary btn-round btn_edit_category"> <i
                                                                class="far fa-edit "></i></button>
                                                        <button type="button" data-status="{{ $category->status }}"
                                                            data-idd="{{ $category->id }}"
                                                            class="btn btn-danger btn-round btn_status_category"><i
                                                                class="fas fa-lock"></i></button>
                                                    @endif
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

    <!-- ====================================================================================================  -->
    <!-- Modal Editar -->
    <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <input type="hidden" id="id_category" class="form-control" style="visibility: hidden;">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre categoría</label>
                                    <input type="text" maxlength="30" id="name_category" class="form-control" placeholder="Nombre categoría">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_update_category">Editar</button>
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
    <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre categoría</label>
                                    <input type="text" id="add_name" class="form-control" placeholder="Nombre categoría">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_add_category">AGREGAR</button>
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
            $("#categories").addClass("active");
            $("#products").removeClass("active");
            $("#vents").removeClass("active");
            $("#users").removeClass("active");
            $("#repors").removeClass("active");
        });
        //Funcion cambiar estado
        $('.btn_status_category').click(function() {
            var idd = $(this).attr("data-idd");
            var status = $(this).attr("data-status");
            let statusDef = "";
            let tittle = "";
            let message = "";
            if (status == 1) {
                statusDef = 0;
                tittle = "Inactivar categoría";
                message = "¿Está segur@ de Inactivar esta categoría?";
            } else {
                statusDef = 1;
                tittle = "Activar categoría";
                message = "¿Está segur@ de Activar esta categoría?";
            }
            alertify.confirm(tittle, message, function() {
                //OK
                $.ajax({
                    url: 'status_category',
                    data: {
                        id: idd,
                        status: statusDef,
                    },
                    type: 'put',
                    beforeSend: function() {},
                    success: function(response) {
                        if (response.response) {
                            if (statusDef == 1) {
                                alertify.success('Categoría activada con exito.');
                            } else {
                                alertify.success('Categoría inactivada con exito.');
                            }
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            alertify.error('Ocurrio un error al intentar' + tittle +
                                ', intentelo nuevamente.');
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
        //Funcion traer datos categoria
        $('.btn_edit_category').click(function() {
            var id = $(this).attr("data-id");

            if (id == "") {
                alertify.error('Ocurrio un error al intentar editar la categoría, intentelo nuevamente.');
            } else {
                $.ajax({
                    url: 'edit_category_modal',
                    data: {
                        id: id,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_edit_category').prop('disabled', true);
                        $('.btn_edit_category').empty();
                        $('.btn_edit_category').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            $('.btn_edit_category').prop('disabled', false);
                            $('.btn_edit_category').empty();
                            $('.btn_edit_category').append(
                                '<i class="fas fa-edit "></i>'
                            );
                            $('#id_category').val(response.data.id);
                            $('#name_category').val(response.data.name);
                            $('#editCategory').modal('show');
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
        //Funcion editar categoria
        $('.btn_update_category').click(function() {
            var id = $('#id_category').val();
            var name = $('#name_category').val();
            let regName = /[A-Za-z0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre categoría es requerido.');
            } else if (!regName.test(name)) {
                alertify.error('El campo nombre categoría no cumple con el formato requerido.');
            } else {
                $.ajax({
                    url: 'update_category',
                    data: {
                        id: id,
                        name: name,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_update_category').prop('disabled', true);
                        $('.btn_update_category').empty();
                        $('.btn_update_category').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        console.log(response);
                        $('.btn_update_category').prop('disabled', false);
                        $('.btn_update_category').empty();
                        $('.btn_update_category').append('Editar');
                        if (response.response) {
                            alertify.success('Categoría editada con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            alertify.error('Ocurrio un error al editar la categoría.');
                        }
                    },
                    error: function(x, xs, xt) {
                        console.log(x);
                        alertify.error('Ocurrio un error al editar la categoría.');
                    }
                });
            }

        });
        //Funcion agregar categoria
        $('.modal_add_category').click(function() {
            $('#addCategory').modal('show');
        })
        $('.btn_add_category').click(function() {
            var name = $('#add_name').val();
            let regName = /[A-Za-z0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre categoría es requerido.');
            } else if (!regName.test(name) || name.lenght < 5) {
                alertify.error('El campo nombre categoría no cumple con el formato requerido.');
            } else {
                $.ajax({
                    url: 'add_category',
                    data: {
                        name: name,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_add_category').prop('disabled', true);
                        $('.btn_add_category').empty();
                        $('.btn_add_category').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        $('.btn_add_category').prop('disabled', false);
                        $('.btn_add_category').empty();
                        $('.btn_add_category').append('AGREGAR');
                        if (response.response) {
                            alertify.success('Categoría agregada con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            if (response.error) {
                                alertify.error('La categoría que intenta agregar ya se encuentra registrada.');
                            } else {
                                alertify.error('Ocurrio un error al agregar la categoría.');
                            }
                        }
                    },
                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error al agregar la categoría.');
                        console.log(x);
                    }
                });
            }

        });
        //Funcion delete
        $('.btn_delete_category').click(function() {
            var idd = $(this).attr("data-delete");
            let tittle = "";
            let message = "";
            alertify.confirm('Eliminar categoría', '¿Está segur@ de eliminar esta categoría?', function() {
                //OK
                $.ajax({
                    url: 'delete_category',
                    data: {
                        id: idd,
                    },
                    type: 'put',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        if (response.response) {
                            alertify.success('Categoría eliminada con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else if(response.data) {
                            alertify.error('No puede eliminar esta categoría ya que tiene productos relacionados.');
                        }else {
                            alertify.error('Ocurrio un error al intentar eliminar esta categoría, intentelo nuevamente.');
                        }

                    },

                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error al intentar eliminar esta categoría, intentelo nuevamente.');
                        console.log(x);
                    }
                });
            }, function() {
                //Cancel
            });

        });
    </script>
@endpush
