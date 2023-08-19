@if (Auth::id() != $post->user->id)
@if (Auth::check())
<div class="container">
<div class="text-center mb-3">
<div class="form-group">
<div class="d-flex justify-content-between w-75 pb-3 m-auto">
<a href="{{ route('new.comment') }}" class="btn btn-primary">コメントする</a>
</div>
</div>
</div>
</div>
@endif
@endif