@if (Auth::check())
    <div class="w-75 m-auto">
        @include('commons.error_messages')
    </div>
    <div class="text-center mb-3">
        <form method="POST" action="{{ route('post.store') }}" class="d-inline-block w-75" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="posts">
            <div class="form-group">
                <div class ="mb-3">
                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" rows="4" placeholder="140字以内で投稿しよう ...">{{ old('text') }}</textarea>
                </div>
                <div>
                    <i class="far fa-image"></i>
                    <input type="file" name="img_path" placeholder="画像投稿">
                </div>    
                @error('text')
                    <span class="invalid-feedback text-left" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <p class="h6 text-secondary ml-3 ">※画像サイズは最大1MB</p>
                <div class="text-left mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-pen"></i> 投稿する
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif