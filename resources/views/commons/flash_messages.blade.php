@if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if (session('danger'))
    <div class="alert alert-danger text-center">
        {{ session('danger') }}
    </div>
@endif