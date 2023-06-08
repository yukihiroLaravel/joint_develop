@if(session('delete_flash_message'))
    <div class="alert alert-danger">
        {{ session('delete_flash_message') }}
    </div>
@endif
@if(session('update_flash_message'))
    <div class="alert alert-success">
        {{ session('update_flash_message') }}
    </div>
@endif