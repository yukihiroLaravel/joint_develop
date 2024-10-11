@php
    require_once app_path('Helpers/ViewHelper.php');
    $viewHelper = \App\Helpers\ViewHelper::getInstance();

    $categories = \App\Category::getAllCategoriesQuery()->get();
@endphp
<div style="margin-top: 10px; margin-left: 25px; display: flex; flex-wrap: wrap; width: 800px;">
    @foreach($categories as $category)
        <label style="margin-right: 15px;">
            <input style="margin-right: 5px;" type="checkbox" name="categories[]"
                   value="{{ $category->id }}"
                   {{ $viewHelper->getCurrentCategoryCheckedOrEmpty($category->id, $initialSelectedCategories)  }}
            >
            {{ $category->name }}
        </label>
    @endforeach
</div>
