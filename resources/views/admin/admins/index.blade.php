@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">管理者アカウント管理</h1>

            <div>
                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                    管理者画面へ戻る
                </a>

                <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                    管理者を追加
                </a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>登録日時</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at }}</td>
                        <td>
                            <a
                                href="{{ route('admin.admins.edit', $admin->id) }}"
                                class="btn btn-sm btn-primary"
                            >
                                変更
                            </a>

                            @if ($admin->id !== Auth::id() && $admins->total() > 1)
                                <form
                                    method="POST"
                                    action="{{ route('admin.admins.revoke', $admin->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('このユーザーから管理者権限を外しますか？');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        権限を外す
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            管理者はいません。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $admins->links('pagination::bootstrap-4') }}
    </div>
@endsection