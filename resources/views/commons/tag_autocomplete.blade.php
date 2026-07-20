<div class="form-group text-left position-relative">
    <label for="tags">
        タグ
    </label>

    <input
        type="text"
        id="tags"
        name="tags"
        class="form-control"
        value="{{ $tagValue }}"
        placeholder="例：仕事, うっかり, 勘違い"
        autocomplete="off"
        aria-autocomplete="list"
        aria-controls="tag-suggestions"
        aria-expanded="false"
    >

    <div
        id="tag-suggestions"
        class="list-group position-absolute w-100 shadow-sm"
        style="z-index: 1000; display: none;"
        role="listbox"
    ></div>

    <small class="form-text text-muted">
        タグはカンマ区切りで3個まで、1個につき20文字以内で入力してください。
    </small>

    @error('tags')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>

<script type="application/json" id="tag-suggestions-data">
    @json($tagSuggestions->values())
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('tags');
        const suggestionBox = document.getElementById('tag-suggestions');
        const dataElement = document.getElementById('tag-suggestions-data');

        if (! input || ! suggestionBox || ! dataElement) {
            return;
        }

        const tagSuggestions = JSON.parse(dataElement.textContent);
        let isComposing = false;

        // タグ名の前後の空白と先頭の#を除去
        function normalizeTag(tag) {
            return tag.trim().replace(/^#+/, '').trim();
        }

        // 候補欄を閉じる
        function hideSuggestions() {
            suggestionBox.innerHTML = '';
            suggestionBox.style.display = 'none';
            input.setAttribute('aria-expanded', 'false');
        }

        // 選択した候補を入力欄へ反映
        function selectSuggestion(selectedTag) {
            const inputParts = input.value.split(',');

            const completedTags = inputParts
                .slice(0, -1)
                .map(function (tag) {
                    return normalizeTag(tag);
                })
                .filter(function (tag) {
                    return tag !== '';
                });

            completedTags.push(selectedTag);

            input.value = completedTags.join(', ');
            input.focus();

            hideSuggestions();
        }

        // 現在の入力内容に一致する候補を表示
        function showSuggestions() {
            const inputParts = input.value.split(',');

            const selectedTags = inputParts
                .slice(0, -1)
                .map(function (tag) {
                    return normalizeTag(tag);
                })
                .filter(function (tag) {
                    return tag !== '';
                });

            const currentInput = normalizeTag(
                inputParts[inputParts.length - 1] || ''
            );

            if (selectedTags.length >= 3 || currentInput === '') {
                hideSuggestions();

                return;
            }

            const currentInputLower = currentInput.toLocaleLowerCase();

            const matchedTags = tagSuggestions.filter(function (tag) {
                const tagLower = tag.toLocaleLowerCase();

                const isMatched = tagLower.includes(currentInputLower);

                const isAlreadySelected = selectedTags.some(function (selectedTag) {
                    return selectedTag.toLocaleLowerCase() === tagLower;
                });

                return isMatched && ! isAlreadySelected;
            });

            suggestionBox.innerHTML = '';

            if (matchedTags.length === 0) {
                hideSuggestions();

                return;
            }

            // ブラウザの入力履歴と区別できるよう見出しを表示
            const suggestionLabel = document.createElement('div');

            suggestionLabel.className = 'px-3 py-2 small text-muted bg-light border-bottom';
            suggestionLabel.textContent = '既存タグから選択';

            suggestionBox.appendChild(suggestionLabel);

            matchedTags.forEach(function (tag) {
                const suggestionButton = document.createElement('button');
                const tagBadge = document.createElement('span');

                suggestionButton.type = 'button';
                suggestionButton.className =
                    'list-group-item list-group-item-action d-flex align-items-center';
                suggestionButton.setAttribute('role', 'option');

                tagBadge.className = 'badge';
                tagBadge.style.backgroundColor = '#97b7a4';
                tagBadge.style.color = '#ffffff';
                tagBadge.textContent = '#' + tag;

                suggestionButton.appendChild(tagBadge);

                suggestionButton.addEventListener('click', function () {
                    selectSuggestion(tag);
                });

                suggestionBox.appendChild(suggestionButton);
            });

            suggestionBox.style.display = 'block';
            input.setAttribute('aria-expanded', 'true');
        }

        // 日本語変換中は候補を更新しない
        input.addEventListener('compositionstart', function () {
            isComposing = true;
        });

        input.addEventListener('compositionend', function () {
            isComposing = false;
            showSuggestions();
        });

        input.addEventListener('input', function () {
            if (! isComposing) {
                showSuggestions();
            }
        });

        input.addEventListener('focus', function () {
            showSuggestions();
        });

        // 入力欄と候補欄の外側をクリックしたら閉じる
        document.addEventListener('click', function (event) {
            const clickedInput = input.contains(event.target);
            const clickedSuggestion = suggestionBox.contains(event.target);

            if (! clickedInput && ! clickedSuggestion) {
                hideSuggestions();
            }
        });
    });
</script>
