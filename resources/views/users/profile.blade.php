<aside class="col-sm-4 mb-5">
    <div class="card shadow-lg"
         style="background:#f9f7f1; border:2px solid #8b5e3c; border-radius:20px;">
        <div class="card-header text-center"
             style="background:#2e5c2b; border-radius:15px 15px 0 0;">
            <h3 class="card-title text-light mb-0">
                <i class="fas fa-campground"></i> {{ $user->name }}
            </h3>
        </div>
        <div class="card-body text-center">
            <img class="rounded-circle border border-success shadow-sm mb-3"
                 src="{{ Gravatar::src($user->email, 300) }}"
                 alt="{{ $user->name }}"
                 style="width:150px; height:150px; object-fit:cover;">
            @auth
                @if (Auth::id() === $user->id)
                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-success btn-block"
                           style="border-radius:12px;">
                           <i class="fas fa-user-edit"></i> ユーザ情報の編集
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</aside>