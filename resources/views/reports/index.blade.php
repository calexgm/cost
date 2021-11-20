@extends('layouts.app', ['page' => 'Reportes', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="card-title"> Reportes</h4>
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
            $("#dashboard").removeClass("active");
            $("#categories").removeClass("active");
            $("#products").removeClass("active");
            $("#vents").removeClass("active");
            $("#users").removeClass("active");
            $("#repors").addClass("active");
        });
    </script>
@endpush
