<div class="posts row mt-5 text-center">
    @php
        $user -> posts ->last();
    @endphp
    @foreach($posts as $recode)
    
        <div class="d-flex justify-content-evenly">
            <div>日付：</div> {{$recode -> date}} <br>
            <div> 内容：</div> {{$recode -> postcontent}} <br>
        </div> 
        
        
        @if (Auth::id() === $recode ->user_id)
        <form method="POST" action="{{ route('post.delete', $recode->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">この投稿を削除する</button>
        </form>
        @endif
    @endforeach


</div>
