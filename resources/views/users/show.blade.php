@extends('layouts.app')
@section('content')
<div class="row">
    <aside class="col-sm-4 mb-5">
        <div class="card bg-info">
            <div class="card-header">
                <h3 class="card-title text-light">{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                @if (isset($user) && $user->profile_image)
                    <img id="profile-image" class="rounded-circle img-fluid" src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="ユーザーのプロフィール画像" style="width: 250px; height: 250px; border-radius: 50%; object-fit: cover;">
                @else
                    <img id="profile-image" class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 300) }}" alt="ユーザのアバター画像">
                @endif                
                @if (Auth::check() && Auth::user()->id == $user->id)
                    @if ($errors->any())
                         <div class="alert alert-danger">
                             <ul>
                                 @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif
                    <form action="{{ route('users.upload.image', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data" class="mt-2">
                        @csrf
                        <input type="file" name="image" id="image-input">
                        <input type="submit" value="写真をアップロード">
                    </form>
                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-block">ユーザ情報の編集</a>
                    </div>
                @endif
            </div>
            @include('follows.follow_button')
        </div>
    </aside>

    <div class="col-sm-8">
        <ul class="nav nav-tabs nav-justified mb-3">
            <li class="nav-item">
                <a href="{{ route('users.show', $user->id) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
                    タイムライン<br>
                    <div class="badge badge-secondary">{{ $countPosts }}</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('followings', $user->id) }}" class="nav-link {{ Request::routeIs('followings') ? 'active' : '' }}">
                    フォロー中<br>
                    <div class="badge badge-secondary">{{ $countFollowings }}</div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('followers', $user->id) }}" class="nav-link {{ Request::routeIs('followers') ? 'active' : '' }}">
                    フォロワー<br>
                    <div class="badge badge-secondary">{{ $countFollowers }}</div>
                </a>
            </li>
        </ul>
        @include('posts.posts', ['user' => $user, 'posts' => $posts])
    </div>
</div>

<div id="croppingModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">画像をトリミング</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imageToCrop" src="" alt="Cropping Image" style="max-width: 100%; height: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" id="cropButton" class="btn btn-primary">トリミング</button>
            </div>
        </div>
    </div>
</div>

{{-- トリミング用モーダルのスクリプト --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('image-input');
    var cropper;

    input.addEventListener('change', function (e) {
    var files = e.target.files;
    var reader = new FileReader();
    reader.onload = function (e) {
        var imageElement = document.getElementById('imageToCrop');
        if (imageElement) {
            imageElement.src = e.target.result;
            $('#croppingModal').modal('show');
        } else {
            console.error('imageToCrop element not found');
        }
    };
    reader.readAsDataURL(files[0]);
    });

    $('#croppingModal').on('shown.bs.modal', function () {
        var image = document.getElementById('imageToCrop');
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
    });

    document.getElementById('cropButton').addEventListener('click', function () {
        var croppedCanvas = cropper.getCroppedCanvas();
        var croppedImageDataURL = croppedCanvas.toDataURL('image/png');
        document.getElementById('profile-image').src = croppedImageDataURL;
        $('#croppingModal').modal('hide');

        // Ajaxリクエストでサーバーに画像を送信
        $.ajax({
            url: '{{ route('users.upload.image', ['id' => $user->id]) }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                imageData: croppedImageDataURL
            },
            success: function (response) {
                console.log(response);
                // 成功時の処理
            },
            error: function (xhr, status, error) {
                console.error(error);
                // エラー時の処理
            }
        });
    });
});
</script>
@endsection