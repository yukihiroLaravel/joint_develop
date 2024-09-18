<h5 class="mt-5 mb-4">フォロワー</h5>
@foreach ($followers as $follower)
    <div class="list-group-item">
        <li class="media mb-2">
            <img class="mr-3 rounded-circle" 
                    src="{{ Gravatar::src($follower->email, 55) }}" alt="{{ $follower->name }}のアバター画像">
            <div class="media-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mt-0 mb-1"><a href="{{ route('user.show', $follower->id) }}">{{ $follower->name }}</a></h5>
                    {{-- フォローボタン共通コンポーネント --}}
                    @include('commons.follow_button', ['userId' => $follower->id, 'userName' => $follower->name])
                </div>
                <p class="mb-0 text-muted">{{ $follower->email }}</p>
            </div>
        </li>
    </div>
@endforeach
<div class="mt-3">
    {{ $followers->links('pagination::bootstrap-4') }}
</div>

<script src="{{ asset('/js/confirmUnfollow.js') }}" defer></script>
