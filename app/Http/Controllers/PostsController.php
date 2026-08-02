<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\PostsRequest;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    //投稿一覧表示,検索機能
    public function index(Request $request)
    {
        $query = Post::with('reactions');
        $query->with('tags');

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $keyword = mb_convert_kana($keyword, 's');

            $keywordArray = preg_split('/[\s]+/', $keyword);

            $query->where(function ($q) use ($keywordArray) {
                foreach ($keywordArray as $word) {
                    $q->orWhere('content', 'like', "%{$word}%");
                }
            });
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);
        // 投稿の際にタグを表示
        $tags = Tag::all();

        return view('welcome', ['posts' => $posts, 'keyword' => $keyword, 'tags' => $tags]);
    }

    // 新規投稿
    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;

        // 画像アップロード（新規）
        $imagePath = $this->storeImage($request->file('image'));
        $post->image = $imagePath;

        $post->save();

        // タグ付け
        // 投稿にタグを紐付ける(チェックボックスで選択されたタグIDの配列をそのまま渡す)
        $post->tags()->attach($request->tags ?? []);

        return back()->with('success', '投稿しました！');
    }

    // 投稿削除
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは削除権限がありません。');
        }
        $this->deleteImage($post->image);
        $post->delete();
        return back()->with('success', '削除しました！');
    }

    // 投稿編集画面表示
    public function edit($postId)
    {
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $data = [
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    // 投稿更新
    public function update(PostsRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }
        // テキスト内容を一時保存
        $post->content = $request->content;

        // 画像アップロード(更新)---------------------------------//
        // アップされた情報を一時保存
        $imagePath = $this->storeImage($request->file('image')); // アップされた画像ファイルをstrageに保存してパスを取得
        $imageDeleteFlag = $request->delete_image; // 削除フラグを取得

        // strage内の既存の画像削除
        // 新規ファイルあり または 削除フラグON で、かつ既に画像が保存されている場合
        if (($imagePath || $imageDeleteFlag) && $post->image) {
            $this->deleteImage($post->image);
        }

        // 画像のパスの設定
        // 新規ファイルがある場合、新しい画像のパスを設定
        if ($imagePath) {
            $post->image = $imagePath;
        } elseif ($imageDeleteFlag) {
            // 新規ファイルがなく、削除フラグがonであればnullを設定
            $post->image = null;
        }
        // 新規ファイルも削除フラグもなければ、$post->imageは変更せずそのまま
        // 画像アップロード(更新) ここまで-------------------------//

        $post->save();

        return redirect()->route('posts')->with('success', '更新しました！');
    }

    // 投稿画像ファイルを保存して保存先のパスを返すメソッド
    private function storeImage($file)
    {
        if ($file) {
            return $file->store('post_images', 'public');
        }
        return null;
    }

    // strage内にある指定パスの画像を削除するメソッド
    private function deleteImage(?string $imagePath)
    {
        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
