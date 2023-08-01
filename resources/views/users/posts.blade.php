<ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
            
                @foreach ($posts as $post)
                
                @php
                $users=$post->user()->get();
                @endphp
                
                @foreach ($users as $user)
                
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{ $user->name}}</a></p>
                @endforeach
            </div>
                
            
            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{ $post->text }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                @endforeach
                </div>
                
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="" class="btn btn-primary">編集する</a>
                    </div>
            </div>
        </li>
</ul>
<div class="m-auto" style="width: fit-content"></div>
{{ $posts->links('pagination::bootstrap-4') }}