@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <img class="rounded-circle img-fluid"src="{{ Gravatar::src($user->email, 330) }}" alt="ユーザのアバター画像">
                {{-- 他人のプロフィールの場合：フォローボタン --}}
                @if (Auth::check() && Auth::id() !== $user->id)
                    <div class="mt-3">
                        @if (Auth::user()->isFollowing($user->id))
                            <form method="POST" action="{{ route('unfollow', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary btn-block">
                                    フォロー解除
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('follow', $user->id) }}">
                                @csrf
                                <button class="btn btn-primary btn-block">
                                    フォロー
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
                {{-- 自分自身の場合：編集ボタン --}}
                @if (Auth::check() && Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="" class="btn btn-primary btn-block">
                            ユーザ情報の編集
                        </a>
                    </div>
                    </br>
                    <div class="mb-3 text-center">
                        <form method="post" action="{{ route('user.delete') }}"  onsubmit="return confirm('本当に退会しますか？（この操作は取り消せません）');">  
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">退会する</button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </aside>
    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">
                <a href="{{ route('user.show', $user->id) }}" class="nav-link  {{ $tab === 'posts' ? 'active' : '' }}">
                    タイムライン
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.show', $user->id) }}?tab=followings"class="nav-link {{ $tab === 'followings' ? 'active' : '' }}">
                    フォロー中 ({{ $followings_count }})
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.show', $user->id) }}?tab=followers"class="nav-link {{ $tab === 'followers' ? 'active' : '' }}">
                    フォロワー ({{ $followers_count }})
                </a>
            </li>
        </ul>
        @if ($tab === 'posts')
             @include('posts.post', ['posts' => $posts])
        @else
              @foreach ($users as $one)
                 <div class="media mb-3">
                     <img class="mr-2 rounded-circle" src="{{ Gravatar::src($one->email, 50) }}">
                     <div class="media-body">
                        <a href="{{ route('user.show', $one->id) }}">
                          {{ $one->name }}
                         </a>
                     </div>
                </div>
        @endforeach
    {{ $users->links() }}
@endif
    </div>
</div>
@endsection