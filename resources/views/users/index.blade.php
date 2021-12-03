@extends('layouts.app', ['page' => __('Usuarios'), 'pageSlug' => 'users', 'section' => 'users'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="card-title"> Usuarios</h4>
                            </div>
                            @if (count($users) <= 2)
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-primary btn-round modal_add"><i class="fas fa-user-plus"></i>
                                        AGREGAR
                                        USUARIO</button>
                                </div>
                            @endif
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
                                        EMAIL
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
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td>
                                                {{ $user->email }}

                                            </td>
                                            <td>
                                                {{ $user->created_at }}
                                            </td>
                                            <td>
                                                @if ($user->status == 1)
                                                    Activo
                                                @else
                                                    Inactivo
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <form method="post">
                                                    @if ($user->status == 1)
                                                        <button type="button" data-id="{{ $user->id }}"
                                                            class="btn btn-primary btn-round btn_edit_user"> <i
                                                                class="fas fa-user-edit"></i></button>
                                                        <button type="button" data-status="{{ $user->status }}"
                                                            data-idd="{{ $user->id }}"
                                                            class="btn btn-success btn-round btn_status"><i
                                                                class="fas fa-lock-open"></i></button>
                                                    @else
                                                        <button type="button" data-id="{{ $user->id }}"
                                                            class="btn btn-primary btn-round btn_edit_user"> <i
                                                                class="fas fa-user-edit "></i></button>
                                                        <button type="button" data-status="{{ $user->status }}"
                                                            data-idd="{{ $user->id }}"
                                                            class="btn btn-danger btn-round btn_status"><i
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
    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <input type="hidden" id="id" class="form-control" style="visibility: hidden;">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" id="name" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" id="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="div_pass">

                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="check_pass">
                                    <label class="custom-control-label" for="check_pass">Modificar contraseña</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_update_user">Editar</button>
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
    <!-- Modal agregar -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" autocomplete="off">
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" id="add_name" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" id="add_email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" id="add_password" class="form-control"
                                        placeholder="Contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col pl-4 pr-4">
                                <div class="form-group">
                                    <label>Confirme contraseña</label>
                                    <input type="password" id="add_password_confirmation" class="form-control"
                                        placeholder="Confirme contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-round btn_add_user">AGREGAR</button>
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
        $('#check_pass').change(function() {
            if ($(this).prop('checked')) {
                $('.div_pass').append('<div class="row">' +
                    '<div class="col pl-4 pr-4">' +
                    '<div class="form-group">' +
                    '<label>Contraseña</label>' +
                    '<input type="password" id="password" class="form-control" placeholder="Contraseña">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col pl-4 pr-4">' +
                    '<div class="form-group">' +
                    '<label>Confirme contraseña</label>' +
                    '<input type="password" id="password_confirmation" class="form-control" placeholder="Confirme contraseña">' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            } else {
                $('.div_pass').empty();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#dashboard").removeClass("active");
            $("#categories").removeClass("active");
            $("#products").removeClass("active");
            $("#vents").removeClass("active");
            $("#users").addClass("active");
            $("#repors").removeClass("active");
        });
        //Funcion cambiar estado
        $('.btn_status').click(function() {
            var idd = $(this).attr("data-idd");
            var status = $(this).attr("data-status");
            let statusDef = "";
            let tittle = "";
            let message = "";
            if (status == 1) {
                statusDef = 0;
                tittle = "Inactivar";
                message = "¿Está segur@ de iactivar este usuario?";
            } else {
                statusDef = 1;
                tittle = "Activar";
                message = "¿Está segur@ de activar este usuario?";
            }
            alertify.confirm(tittle, message, function() {
                //OK
                $.ajax({
                    url: 'status_user',
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
                            }, 2000);
                        } else {
                            alertify.error('Ocurrio un error, intentelo nuevamente.');
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
        //Funcion traer datos usuario
        $('.btn_edit_user').click(function() {
            var id = $(this).attr("data-id");

            if (id == "") {
                alertify.error('Ocurrio un error al intentar editar el usuario, intentelo nuevamente.');
            } else {
                $.ajax({
                    url: 'edit_user_modal',
                    data: {
                        id: id,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_edit_user').prop('disabled', true);
                        $('.btn_edit_user').empty();
                        $('.btn_edit_user').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
                        );
                    },
                    success: function(response) {
                        if (response.response) {
                            $('.btn_edit_user').prop('disabled', false);
                            $('.btn_edit_user').empty();
                            $('.btn_edit_user').append(
                                '<i class="fas fa-user-edit "></i>'
                            );
                            $('#id').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#email').val(response.data.email);
                            $('#editUser').modal('show');
                        } else {}

                        /*if (response.response) {
                            alertify.success('Contraseña actualizada con exito.');
                        } else {
                            alertify.error('Ocurrio un error al actualizar la contraseña.');
                        }*/
                    },

                    error: function(x, xs, xt) {
                        console.log(x);
                    }
                });
            }

        });
        //Funcion editar usuario
        function validatePass(password,confirm){
            let regPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
            if ($('#check_pass').prop('checked')) {
                if (password == "") {
                    alertify.error('El campo contraseña es requerido.');
                } else if (!regPassword.test(password)) {
                    alertify.error('El campo contraseña no cumple con el formato requerido.');
                } else if (confirm == "") {
                    alertify.error('El campo confirme contraseña es requerido.');
                } else if (!regPassword.test(confirm)) {
                    alertify.error('El campo confirme contraseña no cumple con el formato requerido.');
                } else if (password != confirm) {
                    alertify.error('La contraseña y la confirmación no concuerdan.');
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }
        $('.btn_update_user').click(function() {
            var id = $('#id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirm = $('#password_confirmation').val();

            let regPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
            let regEmail =
                /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
            let regName = /[A-Za-z0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre es requerido.');
            } else if (!regName.test(name)) {
                alertify.error('El campo nombre no cumple con el formato requerido.');
            } else if (email == "") {
                alertify.error('El campo email es requerido.');
            } else if (!regEmail.test(email)) {
                alertify.error('El campo email no cumple con el formato requerido.');
            } else if (!validatePass(password,confirm)) {
               
            } else {
                let check = false;
                if ($('#check_pass').prop('checked')) {
                    check = true;
                }else {
                    check = false;
                }
                $.ajax({
                    url: 'update_user',
                    data: {
                        id: id,
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: confirm,
                        check: check
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_update_user').prop('disabled', true);
                        $('.btn_update_user').empty();
                        $('.btn_update_user').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        $('.btn_update_user').prop('disabled', false);
                        $('.btn_update_user').empty();
                        $('.btn_update_user').append('Editar');
                        if (response.response) {
                            alertify.success('Usuario editado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            alertify.error('Ocurrio un error al editar el usuario.');
                        }
                    },
                    error: function(x, xs, xt) {
                        console.log(x);
                    }
                });
            }

        });
        //Funcion agregar usaurio
        $('.modal_add').click(function() {
            $('#addUser').modal('show');
        })
        $('.btn_add_user').click(function() {
            var name = $('#add_name').val();
            var email = $('#add_email').val();
            var password = $('#add_password').val();
            let rol_id = 2;
            let status = 1;
            var confirm = $('#add_password_confirmation').val();

            let regPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
            let regEmail =
                /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
            let regName = /[A-Za-z0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre es requerido.');
            } else if (!regName.test(name)) {
                alertify.error('El campo nombre no cumple con el formato requerido.');
            } else if (email == "") {
                alertify.error('El campo email es requerido.');
            } else if (!regEmail.test(email)) {
                alertify.error('El campo email no cumple con el formato requerido.');
            } else if (password == "") {
                alertify.error('El campo contraseña es requerido.');
            } else if (!regPassword.test(password)) {
                alertify.error('El campo contraseña no cumple con el formato requerido.');
            } else if (confirm == "") {
                alertify.error('El campo confirme contraseña es requerido.');
            } else if (!regPassword.test(confirm)) {
                alertify.error('El campo confirme contraseña no cumple con el formato requerido.');
            } else if (password != confirm) {
                alertify.error('La contraseña y la confirmación no concuerdan.');
            } else {
                $.ajax({
                    url: 'add_user',
                    data: {
                        rol_id: rol_id,
                        status: status,
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: confirm,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('.btn_update_user').prop('disabled', true);
                        $('.btn_update_user').empty();
                        $('.btn_update_user').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        $('.btn_update_user').prop('disabled', false);
                        $('.btn_update_user').empty();
                        $('.btn_update_user').append('Editar');
                        if (response.response) {
                            alertify.success('Usuario agregado con exito.');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            if (response.error) {
                                alertify.error('El correo que intenta agregar ya se encuentra en uso.');
                            } else {
                                alertify.error('Ocurrio un error al agregar el usuario.');
                            }
                        }
                    },
                    error: function(x, xs, xt) {
                        alertify.error('Ocurrio un error al agregar el usuario.');
                        console.log(x);
                    }
                });
            }

        });
    </script>
     
@endpush
