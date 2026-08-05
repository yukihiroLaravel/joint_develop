@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">ユーザー管理</h1>

            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                管理者画面へ戻る
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>状態</th>
                    <th>登録日時</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="{{ $user->trashed() ? 'table-secondary' : '' }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->trashed())
                                <span class="badge badge-secondary">退会済み</span>
                            @else
                                <span class="badge badge-success">利用中</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if ($user->trashed() && ! $user->is_admin)
                                <form
                                    method="POST"
                                    action="{{ route('admin.users.restore', $user->id) }}"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-success">
                                        復元
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.users.force-delete', $user->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('このユーザーを完全削除しますか？投稿・リアクション・画像も元に戻せません。');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-dark">
                                        完全削除
                                    </button>
                                </form>
                            @elseif (! $user->is_admin)
                                <form
                                    method="POST"
                                    action="{{ route('admin.users.grant-admin', $user->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('このユーザーを管理者にしますか？');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-primary">
                                        管理者にする
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('このユーザーを強制退会させますか？');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        強制退会
                                    </button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            ユーザーはいません。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links('pagination::bootstrap-4') }}
    </div>
@endsection