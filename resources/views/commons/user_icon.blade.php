@php
    $iconSrc = Gravatar::src($user->email, 400);
    if ($user->icon !== null) {
        $iconSrc = asset('storage/images/userIcons/' . $user->icon);
    }
@endphp
<img src="{{ $iconSrc }}" alt="ユーザーアバター" class="rounded-circle img-fluid user_icon">
