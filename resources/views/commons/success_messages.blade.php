<!-- 投稿に成功　-->
@if (session('successMessage'))
        <div class="alert alert-success w-75 m-auto">
            {{ session('successMessage') }}
        </div>
@endif

<!-- 削除に成功　-->
@if (session('destroyMessage'))
        <div class="alert alert-success w-75 m-auto">
            {{ session('destroyMessage') }}
        </div>
@endif

<!-- 編集に成功　-->
@if (session('editMessage'))
        <div class="alert alert-success w-75 m-auto">
            {{ session('editMessage') }}
        </div>
@endif