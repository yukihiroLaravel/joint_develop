<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class Post extends Model
{
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($post) {

            $helper = Helper::getInstance();

            /*
                「storage」も削除したいため
                $post->postImages()->delete();
                での一括削除は行わない。
                また、後ほど、わかったことだが、
                親：$user、子：$post、孫 : $post_image
                としたときに、ひ孫　のテーブルが、もし、将来的にできたときなど
                考慮し、確実に「孫 : $post_image」でのdeletingが発火する方式の
                布石としても、このほうが都合がよいだろう。
            */
            $postImages = $post->postImages()->get();

            // $postImagesの「storage」と「DB値」を削除する
            $helper->deletePostImages($postImages);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postImages()
    {
        return $this->hasMany(PostImage::class);
    }

    /**
     * $thisに紐づく「post_images」をorder順に取得
     */
    public function postOrderImages() {
        return $this->postImages()->orderBy('order', 'asc');
    }

    /**
     * $thisに紐づく「post_images」があれば、
     * 編集の初期表示時のアップロードUIの復元情報を返す
     */
    public function getLoadInfoForEditPostInitial() {
        // $thisに紐づく「post_images」をorder順に取得
        $postImages = $this->postOrderImages()->get();
        if ($postImages->isEmpty()) {
            return null;
        }

        $fileUuids = [];
        $fileNames = [];

        foreach($postImages as $postImage) {
            $fileUuids[] = $postImage->uuid;
            $fileNames[] = $postImage->file_name;
        }

        // 編集の初期表示時のアップロードUIの復元情報
        $loadInfo = new \ArrayObject([
            // uuid
            "fileUuids" => json_encode($fileUuids),
            // ログインユーザ以外のuserId
            "fileNames" => json_encode($fileNames),
        ], \ArrayObject::ARRAY_AS_PROPS);

        return $loadInfo;
    }
}
