<h2 class="mt-5 mb-5">投稿一覧</h2>
<div class="posts row mt-5 text-center">
    @foreach ($users as $user)
        @php
            $post = $user->posts->last();
        @endphp
        
        <ul class="list-unstyled">
            <li class="mb-3 text-center">
                <div class="text-left d-inline-block w-75 mb-2">
                    <img class="mr-2 rounded-circle" src="https://secure.gravatar.com/avatar/f196e1cd39192e184be74e0ee5102909?s=55&r=g&d=identicon" alt="user avatar"> 
                    <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name }}</a></p>                   
                </div>
                <div class="">
                    <div class="text-left d-inline-block w-75">
                        <p class="mb-2">{{$post->content}}</p>
                        <p class="text-muted">2023-09-20 21:00:10</p>
                    </div>
                        {{-- <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                            <form method="" action="">
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                            <a href="" class="btn btn-primary">編集する</a>
                        </div> --}}
                </div>
            </li>
    </ul>
    <div class="m-auto" style="width: fit-content"></div>
    
    
    @endforeach
</div>
{{ $users->links('pagination::bootstrap-4') }}