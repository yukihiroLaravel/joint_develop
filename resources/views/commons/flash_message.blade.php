@if(session()->has('flash_message'))
    <div class = "alert alert-success">{{ session('flash_message') }}</div>
@endif