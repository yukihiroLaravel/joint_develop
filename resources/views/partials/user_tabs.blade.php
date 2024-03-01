<div class="col-sm-8">
      <ul class="nav nav-tabs nav-justified mb-3">
      <li class="nav-item"><a href="" class="nav-link 
            {{ Request::is('users/'.$user->id) ? 'active' :'' }}">タイムライン</a></li>
         <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
         <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
      </ul>
      @include('posts.posts',['user' =>$user,'posts' => $posts])
</div>