@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile', 'section' => 'users'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image">
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <img class="avatar border-gray" src="{{ asset('images/avatars/user-04.jpg') }}" alt="...">
                            <h5 class="title" id="name_card">{{ auth()->user()->name }}</h5>
                            @if (auth()->user()->rol_id == 1)
                                <p class="description">
                                    {{ $membership->name_membership }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if (auth()->user()->rol_id == 1)
                        <div class="card-footer">
                            <hr>
                            <div class="button-container">
                                <div class="row">
                                    <div class="col-lg-6 ml-auto">
                                        <h5>{{ $membership->date_star }}<br><small>Inicio</small></h5>
                                    </div>
                                    <div class="col-lg-6 mr-auto">
                                        <h5>{{ $membership->date_end }}<br><small>Fin</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if (auth()->user()->rol_id == 1)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Vendedores</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled team-members">
                                @foreach ($vendedores as $ven)
                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-2">
                                                <div class="avatar">
                                                    <img src="{{ asset('images/avatars/user-04.jpg') }}"
                                                        alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-7">
                                                <span class="text-uppercase">{{ $ven->name }}</span>
                                                <br />
                                                @if (Cache::has('user-is-online-' . $ven->id))
                                                    <span class="text-success"><small>Online</small></span>
                                                @else
                                                    <span class="text-secondary"><small>Offline</small></span>
                                                @endif
                                            </div>
                                            <div class="col-md-3 col-3 text-right">
                                                    <a class="btn btn-sm btn-outline-success btn-round btn-icon" href="mailto:{{ $ven->email }}">
                                                    <i class="fa fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <div class="card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Perfil</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-12 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Tienda</label>
                                        <input class="form-control" disabled="" value="{{ $shop->name_shop }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre"
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Email" value="{{ auth()->user()->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="button" id="btn_profile_update" class="btn btn-primary btn-round">
                                        Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Actualizar Contraseña</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Contraseña actual</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control"
                                            placeholder="Contraseña actual">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Nueva contraseña</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Nueva contraseña">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-2 pl-2">
                                    <div class="form-group">
                                        <label>Confirme nueva contraseña</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Confirme nueva contraseña">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="button" id="btn_profile_password"
                                        class="btn btn-primary btn-round">Actualizar contraseña</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#btn_profile_update').click(function() {
            var name = $('#name').val();
            var email = $('#email').val();

            let regEmail =
                /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
            let regName = /[A-Za-z0-9]+/g;
            if (name == "") {
                alertify.error('El campo nombre es requerido.');
            } else if (!regName.test(name)) {
                alertify.error('El campo nombre no cumple con el formato requerido.');
            } /*else if (email == "") {
                alertify.error('El campo email es requerido.');
            } else if (!regEmail.test(email)) {
                alertify.error('El campo email no cumple con el formato requerido.');
            } */else {
                $.ajax({
                    url: 'profile',
                    data: {
                        name: name,
                       // email: email,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('#btn_profile_update').prop('disabled', true);
                        $('#btn_profile_update').empty();
                        $('#btn_profile_update').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        $('#btn_profile_update').prop('disabled', false);
                        $('#btn_profile_update').empty();
                        $('#btn_profile_update').append('Actualizar');
                        $('#name_card').empty();
                        $('#name_card').append(name);
                        if (response.response) {
                            alertify.success('Perfil actualizado con exito.');
                        } else {
                            alertify.error('Ocurrio un error al actualizar el perfil.');
                        }
                    },

                    error: function(x, xs, xt) {
                        console.log(x);
                    }
                });
            }

        });
        $('#btn_profile_password').click(function() {
            var old = $('#old_password').val();
            var password = $('#password').val();
            var confirm = $('#password_confirmation').val();

            let regPassword = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
            if (old == "") {
                alertify.error('El campo contraseña actual es requerido.');
            } else if (!regPassword.test(old)) {
                alertify.error('El campo contraseña actual no cumple con el formato requerido.');
            } else if (password == "") {
                alertify.error('El campo nueva contraseña es requerido.');
            } else if (!regPassword.test(password)) {
                alertify.error('El campo nueva contraseña no cumple con el formato requerido.');
            } else if (confirm == "") {
                alertify.error('El campo confirme nueva contraseña es requerido.');
            } else if (!regPassword.test(confirm)) {
                alertify.error('El campo confirme nueva contraseña no cumple con el formato requerido.');
            } else if (password != confirm) {
                alertify.error('La nueva contraseña y la confirmación no concuerdan.');
            } else {
                $.ajax({
                    url: 'profile/password',
                    data: {
                        old_password: old,
                        password: password,
                        password_confirmation: confirm,
                    },
                    type: 'put',
                    beforeSend: function() {
                        $('#btn_profile_password').prop('disabled', true);
                        $('#btn_profile_password').empty();
                        $('#btn_profile_password').append(
                            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                    },
                    success: function(response) {
                        $('#btn_profile_password').prop('disabled', false);
                        $('#btn_profile_password').empty();
                        $('#btn_profile_password').append('Actualizar contraseña');
                        if (response.response) {
                            alertify.success('Contraseña actualizada con exito.');
                        } else {
                            alertify.error('Ocurrio un error al actualizar la contraseña.');
                        }
                    },

                    error: function(x, xs, xt) {
                        console.log(x);
                    }
                });
            }

        });
    </script>
@endpush
