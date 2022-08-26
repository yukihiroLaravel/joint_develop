<div class="w-75 m-auto">@include('commons.error_messages')</div>
<div class="w-75 m-auto">@include('commons.flash_message')</div>    
<div class="text-center mb-3">
        <form method="post" action="{{ route('posts.store') }}" class="d-inline-block w-75">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" rows="4"></textarea>
                <div class="text-left mt-3">
                    <button type="submit" class="btn btn-primary">投稿する</button>
                </div>
            </div>
        </form>
</div>