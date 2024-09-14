<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    /**
     * imgタグのsrc属性に指定する「{{ asset(XXX) }}」の「XXX」の値を取得する。
     */
    public function assetParam()
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
        
        // 例）{{ asset('storage/images/post/5b493bb7-b12e-4a12-aba3-3d1227a29bf8/imageP.jpg') }}
        $ret = "storage/images/post/{$this->uuid}/{$this->file_name}";
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

        // Xdebugで確認しやすいように、一旦、変数で受ける
        $ret =
            "<img src=\"" . asset($this->assetParam()) . "\"" .

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

        // Xdebugで確認しやすいように、一旦、変数で受ける
        $ret =
            "<img src=\"" . asset($this->assetParam()) . "\"" .

            // ツールチップを追加
            "title=\"{$this->file_name}\"" . 

            "class=\"d-block\" alt=\"{$this->file_name}\">"
            ;
        
        return $ret;
    }

    /* #endregion */ // 「carousel.blade.php」関連

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
