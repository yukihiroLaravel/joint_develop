@if (Auth::check())
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
            <input type="hidden" name="posts">
            <div class="form-group">
                <textarea class="form-control @error('text') is-invalid @enderror" name="text" rows="4" value="{{ old('text') }}"></textarea>
                @error('text')
                    <span class="invalid-feedback text-left">{{ $message }}</span>
                @enderror
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif