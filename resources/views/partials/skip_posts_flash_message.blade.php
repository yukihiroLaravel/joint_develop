@if (session('flash_update_message'))
   <div class="alert alert-success">
      {{ session('flash_update_message') }}
   </div>
@endif

@if (session('flash_register_message'))
   <div class="alert alert-success">
        {{ session('flash_register_message') }}
   </div>
@elseif(session('flash_destroy_message'))
    <div class="alert alert-danger">
        {{ session('flash_destroy_message') }}
   </div>
@endif

@if (session('post_register_message'))
   <div class="alert alert-success">
        {{ session('post_register_message') }}
   </div>
@endif

@if (session('post_destory_message'))
    <div class="alert alert-danger">
        {{ session('post_destory_message') }}
    </div>
@endif