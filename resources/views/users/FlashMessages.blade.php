<!-- ユーザ情報編集 -->
<!-- 成功 -->
@if (session('infoedit_successMessage'))
    <div class="alert alert-success text-center">
        {{ session('infoedit_successMessage') }}
    </div> 
@endif
<!-- 失敗 -->
@if (session('infoedit_errorMessage'))
    <div class="alert alert-danger text-center">
        {{ session('infoedit_errorMessage') }}
    </div> 
@endif

<!-- ユーザ退会処理 -->
<!-- 成功 -->
@if (session('quit_successMessage'))
    <div class="alert alert-danger text-center">
        {{ session('quit_successMessage') }}
    </div> 
@endif
<!-- 失敗 -->
@if (session('quit_errorMessage'))
    <div class="alert alert-danger text-center">
        {{ session('quit_errorMessage') }}
    </div> 
@endif
