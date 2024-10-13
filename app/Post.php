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

            // 紐づくReplyを削除
            $replies = Reply::where('post_id', $post->id)->get();
            foreach($replies as $reply) {
                $reply->delete();
            }

            /*
                $post->postImages()->delete();
                での一括削除は行わない。
                親：$user、子：$post、孫 : $post_image
                としたときに、ひ孫　のテーブルが、もし、将来的にできたときなど
                考慮し、確実に「孫 : $post_image」でのdeletingが発火する方式の
                布石としても、このほうが都合がよいだろう。
            */
            $postImages = $post->postImages()->get();

            // $postImagesの「DB値」を削除する
            $helper->deletePostImages($postImages);


            $categoryPostList = CategoryPost::getCategoryPostQueryByPostId($post->id)->get();

            // 「category_post」の「DB値」を削除する
            $helper->deleteCategoryPost($categoryPostList);
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

    public function replies()
    {
        return $this->hasMany(Reply::class);
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

        $helper = Helper::getInstance();

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

        //「編集モードの初期表示時のアップロードUIの復元情報」を作成する。
        $loadInfo = $helper->createUploadUiLoadInfo($fileUuids, $fileNames);

        return $loadInfo;
    }
}
