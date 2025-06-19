@foreach ($users as $user)
    <div class="media mb-3">
        {{-- アバター画像にリンク追加 --}}
        <a href="{{ route('user.show', $user->id) }}">
            <img class="mr-3 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="{{ $user->name }}">
        </a>
        <div class="media-body">
            {{-- ユーザー名にリンク追加 --}}
            <h5 class="mt-0">
                <a href="{{ route('user.show', $user->id) }}" class="text-dark text-decoration-none">
                    {{ $user->name }}
                </a>
            </h5>
            {{-- フォローボタン --}}
            @include('follow.follow_button', ['user' => $user])
        </div>
    </div>
@endforeach