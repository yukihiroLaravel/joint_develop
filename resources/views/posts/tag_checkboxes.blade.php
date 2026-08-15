@isset($allTags)
@foreach ($allTags as $tag)
@php
    $isChecked = isset($post) && $post->tags->contains('id', $tag->id);
@endphp
<input
    type="checkbox"
    class="du-tag-checkbox js-tag-checkbox-limit"
    name="tags[]"
    value="{{ $tag->id }}"
    id="{{ $tagIdPrefix }}{{ $tag->id }}"
    @if ($isChecked)
        checked
    @endif
>
<label class="du-tag-select-pill" for="{{ $tagIdPrefix }}{{ $tag->id }}">#{{ $tag->type }}</label>
@endforeach
@endisset
