@foreach ($posts as $post) 
@endforeach

@include('follow.follow_button')

<div class="row ml-2">
    <span class="col-6">フォロー中！
        <span class="badge badge-pill badge-success">{{ $countFollows }}</span>
    </span>
    <span class="col-6">フォロワー！
        <span class="badge badge-pill badge-success">{{ $countFollowers }}</span>
    </span>
</div>