@if (session('content'))
    <div class="alert alert-success text-center">
      {{ session('content') }}
</div>
@endif
@if (session('error_content'))
    <div class="alert alert-danger text-center">
      {{ session('error_content') }}
    </div>
@endif