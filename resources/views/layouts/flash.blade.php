@if(session('msg'))
    <div class="alert alert-success w-75 my-2 mx-auto text-center"  role="alert">
        {{ session('msg') }}
    </div>
@elseif(session('msg_danger'))
    <div class="alert alert-danger w-75 my-2 mx-auto text-center" role="alert">
        {{ session('msg_danger') }}
    </div>
@endif