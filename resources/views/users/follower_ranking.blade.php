<div class="card mx-auto mb-4" style="max-width: 350px;">
    <div class="card-body p-4">
        <h5 class="text-center mb-4">フォロワーランキング</h5>
        @php
            $prevCount = null;
            $displayRank = 0;
        @endphp

        @foreach ($rankingUsers as $index => $user)
            @php
                if ($user->followers_count !== $prevCount) {
                    $displayRank = $index + 1;
                    $prevCount = $user->followers_count;
                }
                $rankStyle = 'display: inline-block; width: 30px; height: 30px; text-align: center; line-height: 30px; vertical-align: middle;';
            @endphp
            <div class="d-flex align-items-center justify-content-center mb-2">
                {{-- ランキング表示（1位から3位はアイコン、それ以降は数字）--}}
                @if ($displayRank === 1)
                    <img class="mr-3" src="{{ asset('images/icons/rank1.png') }}" alt="1位" style="width: 40px; height: 40px;">
                @elseif ($displayRank === 2)
                    <img class="mr-3" src="{{ asset('images/icons/rank2.png') }}" alt="2位" style="width: 40px; height: 40px;">
                @elseif ($displayRank === 3)
                    <img class="mr-3" src="{{ asset('images/icons/rank3.png') }}" alt="3位" style="width: 40px; height: 40px;">
                @else
                    <span class="mr-3" style="{{ $rankStyle }}">{{ $displayRank }}位</span>
                @endif

                {{-- ユーザー情報 --}}
                <div>
                    <a href="{{ route('user.show', ['id' => $user->id]) }}" class="ml-2 text-dark">
                        <strong>{{ $user->name }}</strong><br>
                    </a>
                    フォロワー数：{{ $user->followers_count }}人
                </div>
            </div>
        @endforeach
    </div>
</div>       

            