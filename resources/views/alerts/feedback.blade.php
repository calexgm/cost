@if ($errors->has($field))
    <script>
        var error = "{{ $errors->first($field) }}";
        alertify.error(error); 
    </script>
@endif
