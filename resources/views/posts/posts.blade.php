<div class="row mt-5">
    @foreach ($posts as $post)
        <div class="col-lg-4 mb-5">
            <div class="card h-100 text-left">
                <div class="card-body">
                    <p class="card-text">
                        {{ $post->content }}
                    </p>
                </div>

                <div class="card-footer text-muted">
                    {{ $post->created_at }}
                </div>
            </div>
        </div>
    @endforeach
</div>

{{ $posts->links('pagination::bootstrap-4') }}