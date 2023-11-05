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
@endif