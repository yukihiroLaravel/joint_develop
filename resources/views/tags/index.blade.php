@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">タグ編集</h3>

        @if(session('success'))
            <p class="text-success">{{ session('success') }}</p>
        @endif

        @if($tags->count() === 0)
            <div class="alert alert-info">あなたが作成したタグはありません</div>
        @else
            <table class="table">
                <tr>
                    <th>タグ名</th>
                    <th>更新</th>
                    <th>削除</th>
                </tr>
                @foreach($tags as $tag)
                    <tr>
                        <td>
                            <form id="update-{{ $tag->id }}" action="{{ route('tags.update', $tag) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="text" name="name" class="form-control @if(session('error_tag_id') == $tag->id && $errors->has('name')) is-invalid @endif" value="{{ session('error_tag_id') == $tag->id ? old('name', $tag->name) : $tag->name }}" @if($tag->update_count >= 1) readonly @endif>
                                @if(session('error_tag_id') == $tag->id && $errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </form>
                        </td>

                        <td>
                            @if($tag->update_count === 0)
                                <button type="submit" form="update-{{ $tag->id }}" class="btn btn-sm btn-primary">更新</button>
                            @else
                                <span class="text-muted">更新済み</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('tags.destroy', $tag) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="d-flex justify-content-center">{{ $tags->links() }}</div>
        @endif
    </div>
@endsection