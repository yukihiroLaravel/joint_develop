<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($user) {
            // フォロー情報の削除( 性能考慮で直接的な削除をする )
            // from_user_idで絞って削除
            \DB::table('follows')->where('from_user_id', $user->id)->delete();
            // to_user_idで絞って削除
            \DB::table('follows')->where('to_user_id', $user->id)->delete();

            /*
                親：$user、子：$post、孫 : $post_image
                の関係性であるが、
                下記の方式で「親：$user」に紐づいてる「子：$post」の一括削除を行うと
                    // 紐づいてるpostsの削除
                    $user->posts()->delete();
                「子：$post」のdeletingイベントが発火せず
                結果的に、「孫 : $post_image」が削除されないことが判明した。
                この解決策として、
                「$user->posts()」の各々の「子：$post」について、
                明示的に、「$post->delete()」を実行し、
                「子：$post」のdeletingイベントが発火させ、
                「孫 : $post_image」の削除ができる状況とした。
            */
            foreach ($user->posts as $post) {
                $post->delete();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザ名の文字数が$truncateLengthを超える場合は、
     * 先頭の$truncateLengthの文字数分でカットして「...」を連結した文字列を返す
     */
    public function truncateName($truncateLength = 12)
    {
        if(mb_strlen($this->name) > $truncateLength) {
            return mb_substr($this->name, 0, $truncateLength) . '...';
        }
        return $this->name;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 最新の投稿を1件取得 (投稿なしの場合はnull返却)
     */
    public function latestPost()
    {
        /*
            $thisのUserの最新の投稿を1件取得する
            ただし、$thisのUserが1件も投稿がない場合はnullが返却される。
        */
        return $this->hasMany(Post::class)->orderBy('id', 'desc')->first();
    }

    /* #region フォロー関連 */

    /**
     * 「$followsParam」のデフォルトを作成する。
     * フォロー関係のUIを表示しない仕様のケースは、このデフォルト値で、後続処理が動作可能とする。
     */
    public static function createDefaultFollowsParam()
    {
        /*
            第2引数に、ArrayObject::ARRAY_AS_PROPS を指定して作った
            ArrayObjectのインスタンスは、「->」でメンバーアクセス可能となる。
            より複雑な仕様に対応すべき時にクラス定義を考慮したときに、利用してる側の実装について、
            変更なしとなるために「->」でメンバーアクセス可能な形としたい
            現状は、そこまで必要なしだが、後々に、そうなったときに改修しやすい状況とするのが目的
        */
        $followsParam = new \ArrayObject([
            // フォロー関係のUIを表示する仕様のケース
            "isControl" => false,
            // ログインユーザ以外のuserId
            "otherUserId" => null,
            // ログインユーザが、$otherUserIdを「フォロー中」かどうか
            "isFollowings" => false,
            // $otherUserIdが、ログインユーザの「フォロワー」かどうか
            "isFollowers" => false,
            // フォロー関連のボタン表示のベースがOKかどうか
            "isFollowsBaseOk" => false,
            // 「フォローされています」のインジゲーターの表示をすべきかどうか
            "isFollowerIndicatorVisible" => false,
        ], \ArrayObject::ARRAY_AS_PROPS);

        return $followsParam;
    }

    /**
     * 「Auth::id()」と「$otherUserId」の状況に従って、$followsParamを更新する。
     */
    public static function updateFollowsParam($followsParam, $otherUserId)
    {
        /*
            「createDefaultFollowsParam()」でデフォルト値を作り、
            当メソッドで必要に応じて更新する2段構えとしておく。
            
            ユーザと投稿の1対1の表示形式のリストが、フォロー関連のUIは不要だが必要となるケースが
            あったとしても、既存のコードが使いまわせる柔軟性を持った状況となることを目的とする
        */
        
        if(!\Auth::check()) {
            // ログインしてなければ、なにもしない
            return;
        }

        if(\Auth::id() === $otherUserId) {
            // ログインユーザ自身は、なにもしない
            return;
        }

        // フォロー関係のUIを表示する仕様のケースだから当メソッドを実行したので、trueを指定する。
        $followsParam->isControl = true;

        // ログインユーザ以外のuserIdを指定する
        $followsParam->otherUserId = $otherUserId;

        // ログインユーザ
        $loginUser = \Auth::user();

        // ログインユーザが、$otherUserIdを「フォロー中」かどうかを指定する
        $followsParam->isFollowings = $loginUser->isFollowings($otherUserId);

        // $otherUserIdが、ログインユーザの「フォロワー」かどうかを指定する
        $followsParam->isFollowers = $loginUser->isFollowers($otherUserId);

        // フォロー関連のボタン表示のベースがOKかどうか
        $followsParam->isFollowsBaseOk = \App\User::isFollowsBaseOk($followsParam);

        // 「フォローされています」のインジゲーターの表示をすべきかどうか
        $followsParam->isFollowerIndicatorVisible = ($followsParam->isFollowsBaseOk && $followsParam->isFollowers);
    }

    /**
     * フォロー関連のボタン表示のベースがOKかどうか
     */
    private static function isFollowsBaseOk($followsParam)
    {
        // 処理負荷が低い順に判定

        if(!$followsParam->isControl) {
            // 「isControl：インクルード元が画面仕様としてフォローの表示制御がしたい」
            // ではないケースは対象外
            return false;
        }

        if(!\Auth::check()) {
            // ログインしてなければ対象外
            return false;
        }

        if(\Auth::id() === $followsParam->otherUserId) {
            // ログインユーザ自身は、対象外にする
            return false;
        }

        return true;
    }

    /**
     * 「フォロー中」のUserのリストを取得
     */
    public function followings()
    {

        /*
            「$this」のUserが「フォロー中」のUserのリストを取得

            belongsToMany(相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
            
            相手のモデル             - 相手もUser
            中間テーブル名           - follows
            自モデルの外部キー名     - from_user_id ( 自分「$this」が、フォローしている側だから )
            相手モデルの外部キー名   - to_user_id   上記と逆の項目を相手側として指定

            ->withPivot('id')
            ->orderBy('follows.id', 'desc')
            は、followsのidの降順、つまり、フォロー関係が作られたのが新しい順で取得するために必要。

            ->withTimestamps()は、created_at、updated_atの設定を自動化させるために必要。
        */

        return $this->belongsToMany(User::class, 'follows', 'from_user_id', 'to_user_id')
                    ->withPivot('id')
                    ->orderBy('follows.id', 'desc')
                    ->withTimestamps();
    }

    /**
     * 「フォロワー」のUserのリストを取得
     */
    public function followers()
    {

        /*
            「$this」のUserの「フォロワー」のUserのリストを取得
            言い換えると、「$this」のUserが、フォローされている側となってるUserのリストを取得

            belongsToMany(相手のモデル, ‘中間テーブル名’, ‘自モデルの外部キー名’, ‘相手モデルの外部キー名’)
            
            相手のモデル             - 相手もUser
            中間テーブル名           - follows
            自モデルの外部キー名     - to_user_id ( 自分「$this」が、フォローされている側だから )
            相手モデルの外部キー名   - from_user_id   上記と逆の項目を相手側として指定

            ->withPivot('id')
            ->orderBy('follows.id', 'desc')
            は、followsのidの降順、つまり、フォロー関係が作られたのが新しい順で取得するために必要。

            ->withTimestamps()は、created_at、updated_atの設定を自動化させるために必要。
        */

        return $this->belongsToMany(User::class, 'follows', 'to_user_id', 'from_user_id')
                    ->withPivot('id')
                    ->orderBy('follows.id', 'desc')
                    ->withTimestamps();
    }

    /**
     * フォローする。
     */
    public function follow($otherUserId)
    {
        // 「$this」のUserが、$otherUserIdのUserをフォローする。

        $exist = $this->isFollowings($otherUserId);
        if ($exist) {
            return false;
        } else {
            $this->followings()->attach($otherUserId);
            return true;
        }
    }

    /**
     * フォローを解除する。
     */
    public function unfollow($otherUserId)
    {
        // 「$this」のUserが、$otherUserIdのUserをフォローを解除する。

        $exist = $this->isFollowings($otherUserId);
        if ($exist) {
            $this->followings()->detach($otherUserId);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 「フォロー中」かどうか
     */
    public function isFollowings($otherUserId)
    {
        // 「$this」のUserが「$otherUserId」のUserを「フォロー中」かどうか

        return $this->followings()->where('to_user_id', $otherUserId)->exists();
    }

    /**
     * 「フォロワー」かどうか
     */
    public function isFollowers($otherUserId)
    {
        // 「$otherUserId」のUserが「$this」のUserの「フォロワー」かどうか

        return $this->followers()->where('from_user_id', $otherUserId)->exists();
    }

    /* #endregion */ // フォロー関連
}
