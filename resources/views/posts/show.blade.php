@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="w-75 mx-auto">
            <div class="mb-4 b-3">
                <h4>{{ $post->user->name }} さんの投稿</h4>
                <div class="alert alert-info">
                    <strong>投稿内容：<br>
                    <div class="text-break"> {{ $post->content }}</div>
                    </strong>
                    <small class="text-muted">{{ $post->created_at }}</small>
                </div>
                @if ($averageRatings)
                    <div class="mb-2">
                        <h5 class="mb-1">
                            平均評価：
                            <span style="font-size: 1.5rem; color: #000;">
                                {{ $averageRatings['overall'] !== null ? number_format($averageRatings['overall'], 1) : '-' }}
                            </span>
                            <span style="color: gold; font-size: 1.5rem;">
                                {{ $averageRatings['overall'] !== null ? '★' : '' }}
                            </span>
                        </h5>
                        <small class="text-muted">
                            接客：{{ display_star_rating($averageRatings['service']) }}
                            料金：{{ display_star_rating($averageRatings['cost']) }}
                            技術：{{ display_star_rating($averageRatings['quality']) }}
                        </small>
                    </div>
                @endif
                @php
                    $defaultImage = config('constants.no_image_path');
                    $imageUrl = $post->image
                        ? asset('storage/' . $post->image)
                        : asset($defaultImage);
                @endphp
                <img src="{{ $imageUrl }}"
                    class="img-fluid rounded mb-3 d-block mx-auto"
                    style="max-height: 400px; object-fit: contain; background-color: #f8f9fa;"
                    alt="投稿画像">
            </div>
            @include('commons.error_messages')
            @if (Auth::check() && Auth::id() !== $post->user_id)
                @if ($hasReviewed)
                    <p class="text-muted">※あなたはこの投稿にすでにレビューしています</p>
                @endif
                <form action="{{ route('reviews.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment">レビュー内容</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                    </div>
                    {{-- 接客・対応 --}}
                    <div class="form-group mt-3">
                        <label>接客・対応の満足度（1〜5☆）※任意</label><br>
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="me-2">
                                <input type="radio" name="rating_service" value="{{ $i }}" {{ old('rating_service') == $i ? 'checked' : '' }}>
                                {{ $i }}<span style="color: gold;">★</span>
                            </label>
                        @endfor
                    </div>
                    {{-- 料金の妥当性 --}}
                    <div class="form-group mt-2">
                        <label>料金の妥当性について（1〜5☆）※任意</label><br>
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="me-2">
                                <input type="radio" name="rating_cost" value="{{ $i }}" {{ old('rating_cost') == $i ? 'checked' : '' }}>
                                {{ $i }}<span style="color: gold;">★</span>
                            </label>
                        @endfor
                    </div>
                    {{-- 技術・仕上がり --}}
                    <div class="form-group mt-2">
                        <label>修理の仕上がり精度（1〜5☆）※任意</label><br>
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="me-2">
                                <input type="radio" name="rating_quality" value="{{ $i }}" {{ old('rating_quality') == $i ? 'checked' : '' }}>
                                {{ $i }}<span style="color: gold;">★</span>
                            </label>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">レビューする</button>
                </form>
            @elseif (Auth::check() && Auth::id() === $post->user_id)
                <p class="text-muted">※自分の投稿にはレビューできません。</p>
            @else
                <p class="text-muted">※レビューするにはログインが必要です。</p>
            @endif
            <hr>
            <h5>みんなのレビュー（{{ $countReviews }} 件）</h5>
            @if ($reviews->isEmpty())
                <p class="text-muted">まだレビューはありません。</p>
            @else
                @foreach ($reviews as $review)
                    <div
                        class="card mb-3 {{ $latestReview && $review->id === $latestReview->id ? 'border border-info' : '' }}"
                        @if ($latestReview && $review->id === $latestReview->id)
                            style="background-color: #f0fafd;"
                        @endif
                    >
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>
                                    {{ $review->user->name }}
                                    @if ($latestReview && $review->id === $latestReview->id)
                                        <span class="badge border border-info text-info ms-2">最新</span>
                                    @endif
                                </strong>
                                <small class="text-muted">{{ $review->created_at }}</small>
                            </div>
                            <p class="mt-2 mb-2">{{ $review->comment }}</p>
                            <ul class="list-unstyled ms-2">
                                <li>
                                    接客・対応の満足度　：
                                    @if ($review->rating_service !== null)
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $review->rating_service ? 'gold' : 'lightgray' }}">★</span>
                                        @endfor
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </li>
                                <li>
                                    料金の妥当性について：
                                    @if ($review->rating_cost !== null)
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $review->rating_cost ? 'gold' : 'lightgray' }}">★</span>
                                        @endfor
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </li>
                                <li>
                                    修理の仕上がり精度　：
                                    @if ($review->rating_quality !== null)
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $review->rating_quality ? 'gold' : 'lightgray' }}">★</span>
                                        @endfor
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </li>
                            </ul>
                            @if (Auth::check() && Auth::id() === $review->user_id)
                                <div class="text-end">
                                    <a href="{{ route('reviews.edit', ['post_id' => $post->id, 'review_id' => $review->id]) }}" class="btn btn-sm btn-outline-primary me-1">編集</a>
                                    <form action="{{ route('reviews.delete', ['review_id' => $review->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="m-auto" style="width: fit-content">
    {{ $reviews->links('pagination::bootstrap-4') }}
    </div>
@endsection