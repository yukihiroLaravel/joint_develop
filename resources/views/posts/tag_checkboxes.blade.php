@isset($allTags)
@foreach ($allTags as $tag)
<input type="checkbox" class="du-tag-checkbox js-tag-checkbox-limit" name="tags[]" value="{{ $tag->id }}" id="{{ $tagIdPrefix }}{{ $tag->id }}">
<label class="du-tag-select-pill" for="{{ $tagIdPrefix }}{{ $tag->id }}">#{{ $tag->type }}</label>
@endforeach
@endisset
