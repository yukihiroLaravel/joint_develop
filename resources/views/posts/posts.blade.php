<div class= "d-flex align-items-center justify-content-center">
    <h3 class="text-center mb-3 mr-2 mt-1">"地域ごとの絶景スポット"</h3>
    <h5>について140字以内で会話しよう！</h5>
</div>
    @if (Auth::check())
        <div class="w-75 m-auto">
            @include('commons.error_messages')</div> 
        <div class="text-center mb-3">
            <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75"  enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <div class= "row">
                        <div class="col-6">
                            <div  class="text-left mt-2 mb-1"><label>投稿タイトル</label></div>
                            <input class="form-control" name="post_title" value="{{ old('post_title') }}">
                        </div>
                        <div class="col-3">
                            <div  class="text-left mt-2 mb-1">エリア</div>
                            <label class="selectbox-006">
                                <select name="area" value="{{ old('area') }}">
                                    <option selected>北海道・東北</option>
                                    <option value="関東">関東</option>
                                    <option value="中部">中部</option>
                                    <option value="近畿">近畿</option>
                                    <option value="中国・四国">中国・四国</option>
                                    <option value="九州・沖縄">九州・沖縄</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div  class="text-left mt-2 mb-1"><label>投稿内容</label></div>
                    <textarea class="form-control" name="content" rows="4">{{ old('content') }}</textarea>
                    <div class="mt-2 mb-1  text-left">
                    <label for="cover_image" class="mr-3">画像の投稿</label>
                    <input type="file"  name="imagepath" value="{{ old('imagepath') }}">
                    </div>
                    <div class="text-left text-right">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif 

    <ul class="list-unstyled">
    @foreach($posts as $post)
        <li class="mb-3 text-center bgcolor">
            <div class="text-left d-inline-block w-75 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="mr-4 mt-3">{{ $post->post_title }}</h2>
                    <div>{{ $post->area }}</div>
                </div>
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($post->user->email, 50) }}" alt="アバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a></p>
            </div>

            <div class="">
                <div class="text-left d-inline-block w-75">
                    <div class="row mt-2 justify-content-between justify-content-between">
                        <div class="col-4">
                            @if($post->imagepath !== null)
                            <img src="{{ asset($post->imagepath)}}" alt= "投稿画像"class="image-fit border img1">
                            @else
                            <img src="{{ asset('storage/image/noimage.png')}}" alt= "投稿画像" class="image-fit border img1">
                            @endif
                        </div>
                        <div class="col-7 border border-dark p-3">{{ $post->content }}</div>
                    </div>

                    <p class="text-muted">{{ $post->created_at }} </p>
                </div>
                @if (\Auth::id() === $post->user_id)
                  <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                    <form method="POST" action="{{ route('post.delete', $post->id) }}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">削除</button>
                     </form>
                     <a href="{{ route('users.edit', $post->user_id) }}" class="btn btn-primary">編集する</a>
                  </div>
                @else
                <div class="d-flex justify-content-between align-items-cente bgcolor2 p-1">
                    <div class="mb-3 mr-5 mt-3 ml-5">返信  件</div>
                    <form method="POST" action="{{ route('reply.store',$post->id) }}">
                        @csrf
                        <div class="row align-items-center mt-2">
                            <input class="form-control col-8" name="reply" value="{{ old('reply') }}" style="width: 500px;">
                            <button type="submit" class="btn btn-primary ml-3 col-2">返信</button>
                        </div>
                    </form>
                </div>
                <div>
                    @include('replys.replys', ['replys' => $replys])
                </div>
                @endif  
            </div>
        </li>
    @endforeach    
    </ul>