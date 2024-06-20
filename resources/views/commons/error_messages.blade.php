@if (count($errors) > 0)  
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="ml-4">
                 @include('commons.error_messages')
                 @yield('content')
                </li>
        @endforeach
    </ul>
@endif
