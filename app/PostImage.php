<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\FileType;

class PostImage extends Model
{
    /**
     * imgタグのsrc属性に指定する「{{ asset(XXX) }}」の「XXX」の値を取得する。
     */
    private function assetParam($fileType, $isThumbnailImg)
    {
        /*
            例として
            /var/www/html/laravelapp/storage/app/public/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg
            であるとき、
            /var/www/html/laravelapp/public/storage
            が
            /var/www/html/laravelapp/storage/app/public
            へのシンポリックリンクなので、
            /var/www/html/laravelapp/public/storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg
            でもアクセス可能である

            このとき、{{ asset('storage') }} は、
            /var/www/html/laravelapp/public/storage
            についてのURL
            http://localhost:8080/storage
            の値を取得する。
            
            また、{{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }} で、
            http://localhost:8080/storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg
            のURLを求めることとなり、このURLでは、画像がブラウザに表示される

            上記のようなURLをimgタグにsrc属性に指定するため実際値を補う形で
            {{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }}
            の形となるように「{{ asset(XXX) }}」のXXXに相当する値を取得するのが当メソッドの役割である。
        */
        $folderRelativePath = $fileType->getFolderRelativePath($this->uuid);

        /*
            サムネイル画像としてのコンテクスト($isThumbnailImgがtrueの場合)で、かつ、動画の場合は、
            同じuuidフォルダ内に、別で生成しているサムネイル画像名を返却する。
            
            上記以外は、純粋に本体のファイル名を返却する。
        */
        $adjustFileName = $fileType->adjustFileName($isThumbnailImg);

        // 例）{{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }}
        $ret = "storage/{$folderRelativePath}/{$adjustFileName}";
        return $ret;
    }

    /* #region 「carousel.blade.php」関連 */

    /**
     *  「resources/views/commons/carousel.blade.php」
     *  で表示用のサムネイル画像のimgタグの文字列を取得する。
     */
    public function getThumbnailImg($strPostIdPostfix)
    {
        /*
            例として
            <img src="{{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }}" class="img-thumbnail" alt="imageP.jpg" data-toggle="modal" data-target="#imageModal{{ $strPostIdPostfix }}" data-slide-to="0">
            のようなタグを出力したいのであるが、
            *.blade.phpで実装してもいいが、VSコードのエディタ上で正しいはずなのに、文字が赤色になったり
            イマイチ認識してくれず、やりにくいため、こちらで実装し、
            {!! $postImage->getThumbnailImg() !!}
            の形で使うことにした。
        */

        $strOrder = strval($this->order);

        // 当ロジックは、固定値 (PHPでローカルスコープの定数がないため変数で代用)
        $imageType = 'post';
        $fileType = new FileType($this->file_name, $imageType);

        $asetValue = asset($this->assetParam($fileType, true));

        // Xdebugで確認しやすいように、一旦、変数で受ける
        $ret =
            "<img src=\"{$asetValue}\"" .

            // ツールチップを追加
            "title=\"{$this->file_name}\"" . 

            "class=\"img-thumbnail\" alt=\"{$this->file_name}\"" . 
            "data-toggle=\"modal\" data-target=\"#imageModal{$strPostIdPostfix}\" data-slide-to=\"{$strOrder}\">"
            ;
        
        return $ret;
    }

    /**
     * 「resources/views/commons/carousel.blade.php」
     * で表示用の「<div class="carousel-item」の内部にある
     * imgタグの文字列を取得する。
     */
    public function getCarouselItemImg()
    {
        // 例)
        // <img src="{{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }}" class="d-block" alt="imageP.jpg">

        // 当ロジックは、固定値 (PHPでローカルスコープの定数がないため変数で代用)
        $imageType = 'post';
        $fileType = new FileType($this->file_name, $imageType);

        // Xdebugで確認しやすいように、一旦、変数で受ける
        $ret = "";

        $asetValue = asset($this->assetParam($fileType, false));

        if($fileType->isVideo) {
            // 動画の場合

            /*
                事前調査として、
                storageの領域に該当の動画ファイルを置いてみて、
                カルーセルでページ切り替えで表示している画像のimgタグを
                ブラウザのデバッガーで下記のvideoタグに、置き換えてみたところストリーミング再生が可能なことが分かっている。

                <video controls="" preload="auto" title="2003　世にも奇妙な物語　迷路.mp4">
                    <source src="http://localhost:6080/storage/images/2003　世にも奇妙な物語　迷路.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                上記のタグを作成する形で、実装する。
            */

            /*
                ★★★★★★★★★★★★★★★★★★★★
                ★★★widthを固定にする一旦の処置★★★
                ★★★★★★★★★★★★★★★★★★★★
                public/js/carousel.jsにも書いたが、動的なサイズ調整をcss, javascritpでするのが
                うまく、いかない、<video タグを作るときに、最初から widthを指定しておくと
                枠内の動画も広がることが後でわかった
                ある程度の大きさで、固定的にはなるが指定しておくと縦幅も元の動画の縦横比を保って
                調整される。縦スクロールも出る
                縦スクロールが出た場合は、一番下のスクロール位置にする対応を
                public/js/carousel.js
                側でしているため、一旦の暫定的での見た目調整をしておく
                もっといい方法が、見つかれば後で検討する。
                ★★★★★★★★★★★★★★★★★★★★
            */
            $ret =
                // ★ 「width=\"800\"」は、一旦の、今できる見た目調整です。★
                "<video width=\"800\" controls=\"\"  preload=\"auto\" title=\"{$this->file_name}\" \">" .
                    "<source src=\"{$asetValue}\" type=\"video/mp4\">" .
                    "Your browser does not support the video tag." .
                "</video>"
            ;
        } else {
            $ret =
                "<img src=\"{$asetValue}\"" .

                // ツールチップを追加
                "title=\"{$this->file_name}\"" . 

                "class=\"d-block\" alt=\"{$this->file_name}\">"
            ;
        }
        
        return $ret;
    }

    /* #endregion */ // 「carousel.blade.php」関連

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
