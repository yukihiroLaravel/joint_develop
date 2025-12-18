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
                    <form action="{{ route('tags.update', $tag) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control">
                </td>
                <td>
                        <button type="submit" class="btn btn-sm btn-primary">更新</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('tags.destroy', $tag) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('削除しますか？')">
                            削除
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>
    </div>
@endsection