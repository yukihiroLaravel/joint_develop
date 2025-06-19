@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="w-75 mx-auto">
            <div class="mb-4 b-3">
                <h4>{{ $post->user->name }} さんの投稿</h4>
                <div class="alert alert-info">
                    <strong>投稿内容：<br>
                    {{ $post->content }}<br>
                    </strong>
                    <small class="text-muted">{{ $post->created_at }}</small>
                </div>
                @include('commons.error_messages')
                <h5 class="mt-4">レビュー内容を編集する</h5>
                <form action="{{ route('reviews.update', [$post->id, $review->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <textarea name="comment" id="comment" class="form-control" rows="3">{{ old('comment', $review->comment) }}</textarea>
                        {{-- 接客・対応 --}}
                        <div class="form-group mt-3">
                            <label>接客・対応の満足度　（1〜5☆）※任意</label><br>
                            <label class="me-2">
                                <input type="radio" name="rating_service" value="" 
                                    {{ old('rating_service', $review->rating_service) === null ? 'checked' : '' }}>
                                未選択
                            </label>
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="me-2">
                                    <input type="radio" name="rating_service" value="{{ $i }}" 
                                        {{ old('rating_service', $review->rating_service) == $i ? 'checked' : '' }}>
                                    {{ $i }}<span style="color: gold;">★</span>
                                </label>
                            @endfor
                        </div>
                        {{-- 料金の妥当性 --}}
                        <div class="form-group mt-3">
                            <label>料金の妥当性について（1〜5☆）※任意</label><br>
                            <label class="me-2">
                                <input type="radio" name="rating_cost" value="" 
                                    {{ old('rating_cost', $review->rating_cost) === null ? 'checked' : '' }}>
                                未選択
                            </label>
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="me-2">
                                    <input type="radio" name="rating_cost" value="{{ $i }}" 
                                        {{ old('rating_cost', $review->rating_cost) == $i ? 'checked' : '' }}>
                                    {{ $i }}<span style="color: gold;">★</span>
                                </label>
                            @endfor
                        </div>
                        {{-- 技術・仕上がり --}}
                        <div class="form-group mt-3">
                            <label>修理の仕上がり精度（1〜5☆）※任意</label><br>
                            <label class="me-2">
                                <input type="radio" name="rating_quality" value="" 
                                    {{ old('rating_quality', $review->rating_quality) === null ? 'checked' : '' }}>
                                未選択
                            </label>
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="me-2">
                                    <input type="radio" name="rating_quality" value="{{ $i }}" 
                                        {{ old('rating_quality', $review->rating_quality) == $i ? 'checked' : '' }}>
                                    {{ $i }}<span style="color: gold;">★</span>
                                </label>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">更新する</button>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary mt-2">キャンセル</a>
                </form>
            </div>
        </div>
    </div>
@endsection