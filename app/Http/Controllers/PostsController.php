<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;
use App\Helpers\Helper;

class PostsController extends Controller
{
    /**
     * トップページの投稿表示
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    /**
     * 新規投稿をする。
     */
    public function store(PostRequest $request)
    {
        $helper = Helper::getInstance();

        $content = $request->content;

        $fileUuids = $request->input('fileUuids', []); // デフォルト空配列
        $fileNames = $request->input('fileNames', []); // デフォルト空配列

        $post = new Post;
        \DB::transaction(function () use (
            $helper,
            $post,
            $content,
            $fileUuids,
            $fileNames
        ) {
            $post->user_id = \Auth::id();
            $post->content = $content;
            $post->save();

            $postId = $post->id;

            // $postImagesのinsertをする。
            $helper->insertPostImages($postId, $fileUuids, $fileNames);
        });

        $this->showFlashSuccess("投稿しました。");

        /*
            'submitSuccess'のセッション値が指定し「upload.blade.php」側で、
            画像のアップロードのUIの復元処理しない制御をしたいためflashで指定するため
            withで、'submitSuccess' => true,を指定している。

            また、当初、
            return back()->with([
                'submitSuccess' => true,
            ]);
            で、return back()していたが、下記の理由により、
            redirect('/')に変更した。

            トップページの投稿一覧は、投稿の新しいもの順に表示されるため
            今、投稿した内容は1ページ目の先頭に表示される

            投稿一覧のページャーの2ページ目以降を表示中に新規投稿したときに、
            return back()すると、その2ページ目以降を再表示するため、
            1ページ目の先頭位置に表示される
            「今まさに投稿した分」確認できない

            ユーザーからすると、「今まさに投稿した分」が表示されないので
            投稿できてないのではないかと、
            勘違いしてしまい、何度も投稿してしまうことになってしまう可能性があり
            それは、とても、わかりにくいと思われる。

            この状況を防ぐため、新規投稿したら1ページ目を表示するように、
            return redirect('/')をすることとした。
        */
        return redirect('/')->with([
            'submitSuccess' => true,
        ]);
    }

    /**
     * 投稿を削除する。
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->validateOwnership($post->user_id);

        \DB::transaction(function () use ($post) {
            $post->delete();
        });

        $this->showFlashSuccess("投稿を削除しました。");

        return back();
    }

    /**
     * 編集
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $this->validateOwnership($post->user_id);

        // クエリパラメータに乗ってる遷移元のURLを取得する。
        $previousUrl = $this->getPreviousUrlByQueryParameter();

        return view('posts.edit', [
            'post' => $post,
            'previousUrl' => $previousUrl,
        ]);
    }

    /**
     * 更新
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->validateOwnership($post->user_id);

        $post->content = $request->input('content');
        $post->save();

        $this->showFlashSuccess("投稿内容を更新しました。");

        return redirect($request->previousUrl);
    }
}
