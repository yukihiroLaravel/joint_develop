@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">投稿管理</h1>

            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                管理者画面へ戻る
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>投稿内容</th>
                    <th>投稿者</th>
                    <th>画像</th>
                    <th>状態</th>
                    <th>投稿日時</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($posts as $post)
                    <tr class="{{ $post->trashed() ? 'table-secondary' : '' }}">
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ optional($post->user)->name ?? '削除済みユーザー' }}</td>
                        <td>
                            {{ $post->image_path ? 'あり' : 'なし' }}
                        </td>
                        <td>
                            @if ($post->trashed())
                                <span class="badge badge-secondary">削除済み</span>
                            @else
                                <span class="badge badge-success">公開中</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            @if (! $post->trashed())
                                <form
                                    method="POST"
                                    action="{{ route('admin.posts.destroy', $post->id) }}"
                                    onsubmit="return confirm('この投稿を削除しますか？');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        削除
                                    </button>
                                </form>
                            @else
                                @if ($post->deleted_reason === \App\Post::DELETED_REASON_ADMIN_POST)
                                    <form
                                        method="POST"
                                        action="{{ route('admin.posts.restore', $post->id) }}"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-sm btn-success">
                                            復元
                                        </button>
                                    </form>
                                @endif

                                <form
                                    method="POST"
                                    action="{{ route('admin.posts.force-delete', $post->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('この投稿を完全削除しますか？元に戻せません。');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-dark">
                                        完全削除
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            投稿はありません。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
@endsection