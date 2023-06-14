@if (session('flash_msg'))
  <div class="alert alert-{{ session('cls')}}" role="alert">
    {{ session('flash_msg')}}
  </div>
@endif
