@if (session('flash_message'))
    <dialog id="flashMessage" class="col-xs-10 bg-success text-white text-center py-3 transition">
        <div class="model-content">
            {{ session('flash_message') }}
        </div>
    </dialog>

    <script>
        // ブラウザバックした時に表示されてしまうのを防止する
        if (window.performance.navigation.type === window.performance.navigation.TYPE_NAVIGATE) {
            const dialog = document.getElementById("flashMessage");
            dialog.showModal();
            setTimeout(() => {
                dialog.style.opacity = 0;
                setTimeout(() => {
                    dialog.close();
                }, 1000)
            }, 1500);
        }
    </script>

    <style>
        #flashMessage {
            width: 500px;
        }

        @media screen and (max-width:600px) {
            #flashMessage {
                width: 80%;
            }
        }

        #flashMessage::backdrop{
            background-color: transparent;
        }

        .transition {
            transition: opacity 1s ease;
        }
    </style>
@endif
