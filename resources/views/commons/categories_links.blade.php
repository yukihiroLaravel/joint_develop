@php
    $categories = \App\Category::getSelectedCategoriesByPostId($post->id);
@endphp
@if ($categories->isNotEmpty())
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <ul>
            @foreach ($categories as $category)
                <li>
                    <a href="#">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
