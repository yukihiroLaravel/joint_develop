@foreach ($posts as $key => $post) 
    @if ($key === 2)
        @break
    @endif
@endforeach

@include('follow.follow_button')

@php
    $countFollowerUsers = $post->user->followers()->count();
    $countFollowingUsers = $post->user->followings()->count();
@endphp
    
    
<div class="row ml-2">
<span class="col-6">フォロー中！
    <span class="badge badge-pill badge-success">{{ $countFollowingUsers }}</span>
</span>
<span class="col-6">フォロワー！
    <span class="badge badge-pill badge-success">{{ $countFollowerUsers }}</span>
</span>
</div>