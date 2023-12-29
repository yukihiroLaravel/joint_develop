@if (count($errors) > 0)
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="text-left" class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif