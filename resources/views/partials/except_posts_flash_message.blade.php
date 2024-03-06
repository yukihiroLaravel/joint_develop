<link rel="stylesheet" href="{{ asset('path/to/animations.css') }}">

@if (session('flash_update_message'))
   <div class="alert alert-success ">
      {{ session('flash_update_message' ) }}
   </div>
@endif

@if (session('flash_register_message'))
   <div class="alert alert-success ">
        {{ session('flash_register_message' ) }}
   </div>
@elseif(session('flash_delete_message'))
    <div class="alert alert-danger ">
        {{ session('flash_delete_message' ) }}
   </div>
@endif

if(session('flash_followers_message'))
    <div class="alert alert-danger ">
        {{ session('flash_followers_message' ) }}
   </div>
@endif