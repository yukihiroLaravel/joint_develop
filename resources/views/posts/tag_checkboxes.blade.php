{{-- design-update: 投稿時のタグ付け --}}
{{-- design-update: 見た目確認用のサンプルを削除し、下の$allTagsのループに差し替え --}}
@isset($allTags)
@foreach ($allTags as $tag)
<input type="checkbox" class="du-tag-checkbox" name="tags[]" value="{{ $tag->id }}" id="{{ $tagIdPrefix }}{{ $tag->id }}">
<label class="du-tag-select-pill" for="{{ $tagIdPrefix }}{{ $tag->id }}">#{{ $tag->type }}</label>
@endforeach
@endisset
