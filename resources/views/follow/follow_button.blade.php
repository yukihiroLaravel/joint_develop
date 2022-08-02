@if (Auth::check())
  @if (Auth::id() != $user->id)
    @if (Auth::user()->is_following($suer->id))
      {!! Form::open(['route' => ['unfollow', $user->id], 'method' => 'delete']) !!}
        {!! Form:submit('フォローを外す', ['class' => "button btn btn-danger mt-1"]) !!}
      {!! Form::close() !!}
    @else
      {!! Form::open(['route' => ['follow', $user->id]]) !!}
        {!! submit('フォローする', ['class' => "button btn btn-primary mt-1"]) !!}
      {!! Form::close() !!}
    @endif
  @endif
@endif

