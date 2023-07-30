<ul class="list-unstyled">
        <li class="mb-3 text-center">
            <div class="text-left d-inline-block w-75 mb-2">
                
        @foreach ($users as $user)
            @php
                $post = $user->posts()->get();
            @endphp
        
            <div class="row text-center mt-3">
       
            <div class="col-lg-4 mb-5">
                <div class="movie text-left d-inline-block">
                <img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像">
                <p class="mt-3 mb-0 d-inline-block"><a href="{{ route ('user.show', $user->id) }}">＠{{ $user->name }}</a></p>
                    
        
</div>

            </div>
            <div class="container">
                <div class="text-left d-inline-block w-75">
                    <p class="mb-2"> {{ $post->text }}</p>
                    <p class="text-muted">{{ $post->created_at }}</p>
                </div>
        @endforeach
                    <div class="d-flex justify-content-between w-75 pb-3 m-auto">
                        <form method="POST" action="{{route ('post.destroy')}}">
                        @csrf
                        @method('DELETE')    
                        <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                        <a href="{{route ('post.edit')}}" class="btn btn-primary">編集する</a>
                    </div>
            </div>
        </li>
</ul>
{{ $users->links('pagination::bootstrap-4') }}
</div>
<div class="m-auto" style="width: fit-content"></div>