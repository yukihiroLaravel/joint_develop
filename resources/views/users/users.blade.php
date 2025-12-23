@if (count($users) > 0)
    <ul class="list-unstyled">
        @foreach ($users as $user)
            <li class="media mb-3">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        <p><a href="{{ route('user.show', $user->id) }}">ユーザー情報を見る</a></p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $users->links() }}
@endif
