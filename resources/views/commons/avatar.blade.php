{{-- 
    当初avatar画像の表示部分は、
    例として、
    img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像"
    のようなimgタグとなっていた。
    (
        コメント表記の都合上、上記の例では「 両端の< >の記号 」は消してる。
        「 両端の< >の記号 」をつけるとVSコード上、実コードと認識されるので、それを回避してコメント記述している。
        以後、同じ。要領で両端の< >の記号は消してます。
    )

    当「avatar.blade.php」を実装直前の周辺での
    「Gravatar::src()」を用いたアバター画像表示部分は、
    (1) ユーザ詳細画面
        resources/views/posts/show.blade.php にあった
        img class="mr-2 rounded-circle" src="{{ Gravatar::src($user->email, 55) }}" alt="ユーザのアバター画像"

    (2) ユーザ編集画面
        resources/views/users/edit.blade.php にあった
        img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt=""

    (3) トップ画面または、ユーザ詳細画面での「ユーザと投稿の組み合わせ表示部品」
        resources/views/users/show.blade.php にあった
        img class="rounded-circle img-fluid" src="{{ Gravatar::src($user->email, 400) }}" alt=""

    上記の(1)、(2)、(3)の状態だった。
    上記の(1)、(2)、(3)を見比べた時、
        $editFlg : 編集モードかどうかのフラグ ( これは、後述で説明している )
        $imageSize : 上記の55や、400に相当する値
        $user : Userモデル。Gravatar::src()の引数のemailの値や、後述の「user_images」を求めるのにも必要。
        $class : class属性値
    の引数が当コンポーネントに指定されればよいことが判断できた。

    この時点での仕様と、avatar画像のアップロード対応後の仕様を総合すると
    下記のように考えるのが適切であろう。

    (a) アップロードしたアバター画像がある場合 (言い換えると、テーブル「users」に1対1対応で紐づく「user_images」がある場合)
        「user_images」に基づいた画像を表示する。

    (b) アップロードしたアバター画像がない場合 (言い換えると、テーブル「users」に1対1対応で紐づく「user_images」がない場合)
        「Gravatar::src()」を用いた表示をする

    上記の(a)ではユーザがアップロードした画像の実寸が様々であることから
    例として
    img class="rounded-circle img-fluid" style="width: 400px; height: 400px;" src="http://localhost:8080/storage/images/avatar/26c236d6-285d-41e4-97c9-8f174f3a833a/image1.png" alt="ユーザ名１"
    のように、「  style="width: 400px; height: 400px;"  」を補った形で ( $imageSizeが、400の例です。 )
    サイズ調整した形でimgタグを作る必要がある。
    width、heightを同じ値にして拡大／縮小し正方形にしておけば、
    $classにrounded-circleが含まれた値があれば、円形になるだろう。

    上記の(b)では、「Gravatar::src()」は、55や、400つまり、$imageSizeを指定していれば
    その大きさの画像のURLがGravatarが返してくれる
    実行時は、例として
    img class="rounded-circle img-fluid" src="https://secure.gravatar.com/avatar/33ead0fffce3518ee97d59348a3708af?s=400&amp;r=g&amp;d=identicon" alt="ユーザ名１"
    であり、特に、width, heightの指定は、imgタグには不要である。

    (1)、(3)については、表示専用である。
    (2)については、avatar画像の「アップロード／削除」を行うコンポーネント自体が
       'editFlg' => 'ON'の編集モードであるため、「reconstructionImageDBCallBack」を通じた
       javascript側で表示更新に対応すべく、
       もし、「reconstructionImageDBCallBack」のコールバックの引数が空であった時、
       「画像削除」の操作の結果、今、アップロード済のアバター画像がないということですから
       (b)方式でのimgとなる表示更新をjavascriptでする必要がある。
       ( ajax通信の後処理で画面全体リロードをしないからである )
    
    (2)は、当「avatar.blade.php」でも、'editFlg' => 'ON'の編集モードでの引数指定を
    受けてその制御をする形とすればよいだろう。
    ただし、(2)の場合は、ユーザー編集画面を見れば１画面に１つしか
    当コンポーネントを配置しないであろう。
    ですから、carousel.blade.php、carousel.jsに見られるような
    「id属性に親レコードのid値を前ゼロ補充した数字文字列を付与して複数インクルードにそなえるような対応」は不要だと言える
    (1)、(3)はたしかに、1画面に複数インクルードされるが、表示専用のため画面表示時に一回、
    決まればよく、その後、javascript処理による表示変更は不要であるため、これまた、
    「id属性に親レコードのid値を前ゼロ補充した数字文字列を付与して複数インクルードにそなえるような対応」は不要だと言える

    これまで上記で記載してきた考え方の実装は、ある程度、複雑なので、それを各個別画面で同じ実装を
    一個一個していくようなアプリの実装は避けたほうがよい。 (保守性、拡張性の問題)

    必要性が生じたタイミングの初期段階でコンポーネント化を検討すべきである。
    
    当「avatar.blade.php」にてコンポーネント化をして、将来的にavatar画像の表示すべき画面が増えた時
    また、avatar画像の表示仕様変更時の実装対応がしやすい構造としたい。
--}}
@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    $isEdit = ($editFlg === 'ON');

    // アップロード済のアバター画像の表示時にimgタグのsrcに指定値を取得する。
    $imgSrcParam = $user->getUploadedAvatarImgSrcParam();

    // アバター画像のimgタグを作成する。
    $avatarImgTag = $viewHelper->createAvatarImgTag($isEdit, $user, $imgSrcParam, $class, $imageSize);
@endphp
{{-- アバター画像に関するimgタグを出力 --}}
{!! $avatarImgTag->imgUploadedAvatar !!}
{!! $avatarImgTag->imgGravatar !!}
@if ($isEdit)
    {{-- 編集モードの場合 --}}

    {{-- アップロード済のアバター画像の表示時にimgタグのsrcに指定値 --}}
    <input id="avatarImgSrcParam" type="hidden" value="{{ $imgSrcParam }}" />

    {{-- avatar.jsの読み込みをする。 --}}
    <script src="{{ asset('js/avatar.js') }}"></script>
@endif
