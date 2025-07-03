<div class="card mx-auto" style="max-width: 350px;">
    <div class="card-body p-4">
        <h5 class="text-center mb-4">いいね！ランキング</h5>
        @php
            $prevCount = null;
            $displayRank = 0;
        @endphp

        @foreach ($favorites as $index => $user)
            @php
                if ($user->likes_received_count !== $prevCount) {
                    $displayRank = $index + 1;
                    $prevCount = $user->likes_received_count;
                }
                $rankStyle = 'display: inline-block; width: 30px; height: 30px; text-align: center; line-height: 30px; vertical-align: middle;';
            @endphp
            <div class="d-flex align-items-center justify-content-center mb-2">
                @if ($displayRank === 1)
                    <img class="mr-3" src="{{ asset('images/icons/rank1.png') }}" alt="1位" style="width: 40px; height: 40px;">
                @elseif ($displayRank === 2)
                    <img class="mr-3" src="{{ asset('images/icons/rank2.png') }}" alt="2位" style="width: 40px; height: 40px;">
                @elseif ($displayRank === 3)
                    <img class="mr-3" src="{{ asset('images/icons/rank3.png') }}" alt="3位" style="width: 40px; height: 40px;">
                @else
                    <span class="mr-3" style="{{ $rankStyle }}">{{ $displayRank }}位</span>
                @endif

                <div>
                    <a href="{{ route('user.show', ['id' => $user->id]) }}" class="ml-2 text-dark">
                        <strong>{{ $user->name }}</strong><br>
                    </a>
                    いいね！された数：{{ $user->likes_received_count }}件
                </div>
            </div>
        @endforeach
    </div>
</div>
