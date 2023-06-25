<html>
<head>
    <link href="{{ $theme_css_url }}" rel="stylesheet">
</head>
<body>
<div id="app" class="p-4">
    <h1>配色テーマの変更</h1>
    <div v-for="(name,key) in themes">
        <label>
            <input type="radio" :value="key" v-model="theme"> <span v-text="name"></span>
        </label>
    </div>
    <button type="button" class="btn btn-primary mt-3" @click="onSubmit">保存する</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/vue@3.1.1/dist/vue.global.prod.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>

    Vue.createApp({
        data() {
            return {
                theme: '{{ $user->theme }}',
                themes: @json($themes)
            }
        },
        methods: {
            onSubmit() {

                if(confirm('送信します。よろしいですか？')) {

                    const url = '{{ route('user.theme.update') }}';
                    const params = {
                        theme: this.theme,
                        _method: 'PUT'
                    };

                    axios.post(url, params)
                        .then(response => {

                            if(response.data.result === true) {

                                location.reload(); // ページを再読込み

                            }

                        });

                }

            }
        }
    }).mount('#app');

</script>
</body>
</html>