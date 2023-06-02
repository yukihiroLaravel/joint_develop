@if (Auth::check())
    <div class="w-75 m-auto">
        @if (session('successMessage'))
            <div class="alert alert-success alert-dismissible fade show mx-auto w-75" role="alert">
                <strong>{{ session('successMessage') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('errorMessage'))
            <div class="alert alert-danger alert-dismissible fade show mx-auto w-75" role="alert">
                <strong>{{ session('errorMessage') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
        @endif
        @include('commons.error_messages')
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
            @csrf
            <input type="hidden" name="posts">
            <div class="form-group">
                <textarea class="form-control" name="text" rows="4" value="{{ old('text') }}"></textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
    </div>
@endif