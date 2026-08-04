{{-- 投稿時のタグ追加機能 --}}
{{--
    design-update: 投稿時のタグ付け（見た目のみ）。
    - タグ機能実装時参考:
    - コントローラから $allTags（id, name を持つコレクション）を渡すと表示されます（未指定の間は何も表示しません）
    - チェックしたタグは name="tags[]" value="{タグID}" の配列で、この投稿フォームと一緒に送信されます
    - id衝突を避けるため、呼び出し側で $tagIdPrefix を指定してください（例: post-tag- / edit-tag-）※welcome.blade.phpとedit.blade.phpで対応済
--}}
{{-- design-update: 見た目確認用のサンプルを削除し、下の$allTagsのループに差し替え） --}}
@isset($allTags)
@foreach ($allTags as $tag)
<input type="checkbox" class="du-tag-checkbox" name="tags[]" value="{{ $tag->id }}" id="{{ $tagIdPrefix }}{{ $tag->id }}">
<label class="du-tag-pill-label" for="{{ $tagIdPrefix }}{{ $tag->id }}">#{{ $tag->type }}</label>
@endforeach
@endisset
