@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">タグ編集</h3>

        @if(session('success'))
            <p class="text-success">{{ session('success') }}</p>
        @endif
        <table class="table">
            <tr>
                <th>タグ名</th>
                <th>更新</th>
                <th>削除</th>
            </tr>
            @foreach($tags as $tag)
                <tr>
                    <td>
                        @if($tag->user_id === auth()->id() && $tag->update_count === 0)
                            <form action="{{ route('tags.update', $tag) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $tag->name }}" class="form-control @if(session('error_tag_id') == $tag->id && $errors->has('name')) is-invalid @endif">
                                @if(session('error_tag_id') == $tag->id && $errors->has('name'))
                                    <div class="invalid-feedback"> {{ $errors->first('name') }} </div>
                                @endif
                        @else
                            {{ $tag->name }}
                        @endif
                    </td>

                    <td>
                        @if($tag->user_id === auth()->id() && $tag->update_count === 0)
                                <button type="submit" class="btn btn-sm btn-primary">更新</button>
                            </form>
                        @else
                            <span class="text-muted">更新不可</span>
                        @endif
                    </td>

                    <td>
                        @if($tag->user_id === auth()->id())
                            <form action="{{ route('tags.destroy', $tag) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        @else
                            <span class="text-muted">削除不可</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">{{ $tags->links() }}</div>
    </div>
@endsection