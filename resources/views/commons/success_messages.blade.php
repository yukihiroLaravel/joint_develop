<!-- 投稿に成功　-->
@if (session('successMessage'))
    <div class="alert alert-success w-75 m-auto">
        {{ session('successMessage') }}
    </div>
<!-- 削除に成功　-->
@elseif (session('destroyMessage'))
    <div class="alert alert-success w-75 m-auto">
        {{ session('destroyMessage') }}
    </div>
<!-- 編集に成功　-->
@elseif (session('editMessage'))
    <div class="alert alert-success w-75 m-auto">
        {{ session('editMessage') }}
    </div>
<!-- ユーザ新規登録 -->
@elseif (session('registerMessage'))
    <div class="alert alert-success w-75 m-auto">
        {{ session('registerMessage') }}
    </div>
<!-- ユーザ情報更新 -->
@elseif (session('updateMessage'))
    <div class="alert alert-success m-auto">
        {{ session('updateMessage') }}
    </div>
<!-- ユーザ退会 -->
@elseif (session('deleteMessage'))
    <div class="alert alert-danger w-75 m-auto">
        {{ session('deleteMessage') }}
    </div>
@endif