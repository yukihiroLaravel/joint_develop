@if (Auth::check() && Auth::id() !== $id)
    <div style="font-size:0.85em">
        @if (Auth::user()->isComment($id))
                <button style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">コメントすみ&nbsp;<i class="fa-solid fa-comment" style="color:#17a2b8;"></i></button>
            </form>
        @else
            <form method="POST" action="{{ route('comments.edit', $post->id) }}">
                @csrf
                <button style="border: solid 1px gray; background-color:inherit; border-radius: 3em; color:gray">コメントする&nbsp;<i class="fa-regular fa-comment" style="color:gray;"></i></button>
            </form>
        @endif
    </div>
@endif