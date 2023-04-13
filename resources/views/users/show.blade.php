@extends('layouts.app')
@section('content')
<div class="row">
   <aside class="col-sm-4 mb-5">
      <div class="card bg-info">
         <div class="card-header">
            <h3 class="card-title text-light" style="color:white">{{ $user->name }}</h3>
         </div>
         <div class="card-body">
            <img class="rounded-circle img-fluid" src="{{ Gravatar::src ($user->email,['size' => 400]) }}" alt="ユーザのアバター画像">
            @if(Auth::check() && Auth::id() == $user->id)
            <div class="mt-3">
               <a href="{{ route('users.show',$user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
            </div>
            @endif
         </div>
      </div>
   </aside>
   <div class="col-sm-8">
      <ul class="nav nav-tabs nav-justified mb-3">
         <li class="nav-item"><a href="" class="nav-link 
            {{ Request::is('users/'.$user->id) ? 'active' :'' }}">タイムライン</a></li>
         <li class="nav-item"><a href="#" class="nav-link">フォロー中</a></li>
         <li class="nav-item"><a href="#" class="nav-link">フォロワー</a></li>
      </ul>
      @include('posts.post',['user' =>$user,'posts' => $posts])
      <div class="d-flex justify-content-between">
         <a class="btn btn-danger text-light" data-toggle="modal" data-target="#deleteConfirmModal">退会する</a>
      </div>
   </div>
</div>
@endsection

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>確認</h4>
            </div>
            <div class="modal-body">
                <label>本当に退会しますか？</label>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">退会する</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>