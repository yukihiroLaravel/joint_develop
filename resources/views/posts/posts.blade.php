<ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 50) }}" alt="">
                <p class="mt-3 mb-0 d-inline-block"><a href="">{{$user->name}}</a></p>
            </div>

            <div class="">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2">{{$post->content}}</p>
                    <p class="text-muted">2023-10-13 23:13:12</p>
                </div>
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="" action="">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    <a href="" class="btn btn-primary">編集する</a>
                </div>
            </div>
        </li>
    @endforeach    
</ul>