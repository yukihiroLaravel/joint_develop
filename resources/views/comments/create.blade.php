@extends('layouts.app')
@section('content')
          <div class="text-center mb-3">
            <h1 class="mt-5">コメントを投稿する</h1>
              <form method="POST" action="{{ route('comment.store') }}" class="d-inline-block w-75">
                  @csrf
                  <div class="form-group">
                      <textarea class="form-control" name="content" rows="10" value="{{ old('content') }}"></textarea>
                      <div class="text-left mt-3">
                          <button type="submit" class="btn btn-primary">投稿する</button>
                      </div>
                  </div>
              </form>
              
              @include('comments.comments', ['comments' => $comments])
          </div>
          @if (session('redMessage'))
                <div class="alert alert-danger text-center mx-auto w-75 mb-3">
                        {{ session('redMessage') }}
                </div>
          @elseif (session('greenMessage'))
                <div class="alert alert-success text-center mx-auto w-75 mb-3">
                        {{ session('greenMessage') }}
                </div>
          @endif
         
@endsection
