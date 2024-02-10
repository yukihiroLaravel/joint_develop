@if (count($errors) > 0)
    <ul class="alert alert-danger" role="alert" style="max-width: 540px; margin: 0 auto; text-align: left;">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif