@if (count($errors) > 0)
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
<<<<<<< HEAD
@endif
=======
@endif
>>>>>>> 301d37908ca4d4a9e480f54ec8d89cfddb98938b
