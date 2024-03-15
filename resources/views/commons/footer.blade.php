<footer>
    <nav class="navbar navbar-dark bg-info justify-content-center">
        <span class="navbar-brand">©Gut Familie, All rights reserved.</span>
    </nav>
    <div
        class="cat2{{ Route::is('PostsController@index') ? '' : ' cat2_left' }}"{{ Route::is('users.edit') ? ' hidden' : '' }}>
        <img src="{{ asset('storage/images/cat2.png') }}" alt="猫">
    </div>
</footer>
