@if (session('flash_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('flash_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error_message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif