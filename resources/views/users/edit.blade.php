@extends('layouts.app')
@section('content')
<div class="container w-75">
    <h2 class="mt-5 mb-4 text-center" style="color:#2e5c2b; font-weight:bold;">
        <i class="fas fa-user-edit"></i> ユーザ情報を編集する
    </h2>
    <form method="POST" action="{{ route('users.update', $user->id ) }}"
          class="p-4 shadow rounded" 
          style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:15px;">
        @csrf
        @method('PUT')
        @include('commons.error_messages')
        <input type="hidden" name="id" value="{{$user->id}}" />
        <div class="form-group mb-3">
            <label for="name" style="color:#2e5c2b; font-weight:bold;">
                <i class="fas fa-id-badge"></i> ユーザ名
            </label>
            <input class="form-control border border-success"
                   value="{{ old('name', $user->name)}}"
                   name="name"
                   style="border-radius:10px;"/>
        </div>

        <div class="form-group mb-3">
            <label for="email" style="color:#2e5c2b; font-weight:bold;">
                <i class="fas fa-envelope"></i> メールアドレス
            </label>
            <input class="form-control border border-success"
                   value="{{old('email', $user->email)}}"
                   name="email"
                   style="border-radius:10px;"/>
        </div>

        <div class="form-group mb-3">
            <label for="password"  style="color:#2e5c2b; font-weight:bold;">
                <i class="fas fa-lock"></i> パスワード
            </label>
            <input class="form-control border border-success"
                   type="password"
                   name="password"
                   style="border-radius:10px;"/>
        </div>

        <div class="form-group  mb-4">
            <label for="password_confirmation" style="color:#2e5c2b; font-weight:bold;">
                <i class="fas fa-lock"></i> パスワードの確認
            </label>
            <input class="form-control  border border-success"
                   type="password"
                   name="password_confirmation"
                   style="border-radius:10px;"/>
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-danger text-light shadow-sm"
               style="border-radius:10px; font-weight:bold;"
               data-toggle="modal" data-target="#deleteConfirmModal">
               <i class="fas fa-save"></i> 退会する
            </a>
            <button type="submit" class="btn btn-success shadow-sm"
                    style="border-radius:10px; font-weight:bold;">
                <i class="fas fa-save"></i> 更新する
            </button>
        </div>
    </form>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:15px;">
                <div class="modal-header" style="background:#8b5e3c; color:#fff; border-radius:15px 15px 0 0;">
                    <h4 class="modal-title"><i class="fas fa-exclamation-triangle"></i> 確認</h4>
                </div>
                <div class="modal-body" style="background:#f9f7f1;">
                    <label>本当に退会しますか？</label>
                </div>
                <div class="modal-footer d-flex justify-content-between" style="background:#fffaf5;">
                    <form action="{{ route('users.delete', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="border-radius:10px; font-weight:bold;">
                            <i class="fas fa-sign-out-alt"></i> 退会する
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary" style="border-radius:10px;" data-dismiss="modal">
                        閉じる
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
    
