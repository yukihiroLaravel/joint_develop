@php
    if ($user->icon == null) {
        $iconSrc = Gravatar::src($user->email, 400);
    } else {
        $iconSrc = asset('storage/images/userIcons/' . $user->icon);
    }
@endphp
<img src="{{ $iconSrc }}" alt="ユーザーアバター" id="{{ Route::is('users.edit', 'users.update') ? 'user_icon_preview' : '' }}"
    class="rounded-circle img-fluid user_icon">
