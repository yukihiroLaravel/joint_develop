@if( session('flash_msg') )
    <div class="alert alert-{{ session('cls') }}">
        {{ session('flash_msg') }}
    </div>                
@endif  