@if (session('greenMessage'))
    <div class="alert alert-success alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('greenMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('redMessage'))
    <div class="alert alert-danger alert-dismissible fade show mx-auto w-75" role="alert">
        <strong>{{ session('redMessage') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
@endif
