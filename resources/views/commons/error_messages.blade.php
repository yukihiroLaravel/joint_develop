@if (count($errors) > 0 or session('error'))
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
        @if (session('error'))
            <li class="ml-4">{{ session('error') }}</li>
        @endif
    </ul>
@endif
