<h5 class="mt-5 mb-4">フォローしているユーザー</h5>
@foreach ($followings as $following)
    <div class="list-group-item">
        <li class="media mb-1">
            <img class="mr-3 rounded-circle" 
                  src="{{ Gravatar::src($following->email, 55) }}" alt="{{ $following->name }}のアバター画像">
            <div class="media-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $following->id) }}">{{ $following->name }}</a></h5>
                    {{-- フォローボタン共通コンポーネント --}}
                    @include('commons.follow_button', ['userId' => $following->id, 'userName' => $following->name])
                </div>
                <p class="mb-0 text-muted">{{ $following->email }}</p>
            </div>
        </li>
    </div>
@endforeach
<div class="mt-3">
    {{ $followings->links('pagination::bootstrap-4') }}
</div>

<script src="{{ asset('/js/confirmUnfollow.js') }}" defer></script>
