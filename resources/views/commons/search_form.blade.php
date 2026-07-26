<div class="d-flex justify-content-center my-5">
    <div class="w-75">
        <form action="{{ route('posts.index') }}" method="GET">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select name="scope" class="custom-select">
                        @foreach ($scopeLabels as $scopeValue => $scopeLabel)
                            <option
                                value="{{ $scopeValue }}"
                                {{ $scope === $scopeValue ? 'selected' : '' }}
                            >
                                {{ $scopeLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="キーワードを入力して検索..."
                    value="{{ $search }}"
                    required
                >

                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i> 検索
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
