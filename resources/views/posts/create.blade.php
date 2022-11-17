<div class="text-center mb-3">
    @include('commons.error_messages')
    <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75">
    @if (session('successMessage'))
        <div class="alert alert-success text-center">
            {{ session('successMessage') }}
        </div> 
    @elseif (session('deleteMessage'))
        <div class="alert alert-success text-center">
            {{ session('deleteMessage') }}
        </div>
    @elseif (session('updateMessage'))
        <div class="alert alert-success text-center">
            {{ session('updateMessage') }}
        </div>
    @else
    @endif
        @csrf
        <div class="form-group">
            <textarea class="form-control" name="text"  rows="3" placeholder="〇〇について語る">{{ old('text') }}</textarea>
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </div>
    </form>
</div>