<!-- ユーザ情報編集 -->
<!-- 成功 -->
@if (session('infoedit_successMessage'))
    <div class="alert alert-success text-center w-50 mx-auto mb-3">
        {{ session('infoedit_successMessage') }}
    </div> 
@endif
<!-- 失敗 -->
@if (session('infoedit_errorMessage'))
    <div class="alert alert-danger text-center w-50 mx-auto mb-3">
        {{ session('infoedit_errorMessage') }}
    </div> 
@endif

<!-- ユーザ退会処理 -->
<!-- 成功 -->
@if (session('quit_successMessage'))
    <div class="alert alert-danger text-center w-50 mx-auto mb-3">
        {{ session('quit_successMessage') }}
    </div> 
@endif
<!-- 失敗 -->
@if (session('quit_errorMessage'))
    <div class="alert alert-danger text-center w-50 mx-auto mb-3">
        {{ session('quit_errorMessage') }}
    </div> 
@endif
