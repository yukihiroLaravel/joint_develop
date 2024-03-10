@if (Auth::check())
  @if (Auth::user()->isFollower($user->id))
    <form method="POST" action="{{ route('unfollower', $user->id) }}">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">フォローを外す</button>
    </form>
  @else
    <form method="POST" action="{{ route('follower', $user->id) }}">
      @csrf
      <button type="submit" class="btn btn-success">フォローする</button>
    </form> 
  @endif
@endif