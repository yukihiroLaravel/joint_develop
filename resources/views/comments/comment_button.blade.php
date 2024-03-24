@if (Auth::check() && Auth::id() !== $id)
    <div style="font-size:0.85em">
        @if (Auth::user()->isComment($id))
            <a href="{{ route('comments.edit', $post->id) }}" style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">コメントすみ&nbsp;<i class="fa-solid fa-comment" style="color:#17a2b8;"></i></a>
        @else
            <a href="{{ route('comments.edit', $post->id) }}" style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">コメントする&nbsp;<i class="fa-regular fa-comment" style="color:gray;"></i></a>
        @endif
    </div>
@endif