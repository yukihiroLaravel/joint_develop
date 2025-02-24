@if (session('success') || session('delete'))
    <div id="flash-message" class="alert text-center {{ session('success') ? 'alert-success' : 'alert-danger' }}">
        <i class="far fa-check-circle"></i>
        {{ session('success') ?? session('delete') }}
    </div>
@endif

<script>
    window.onload = function() {
        const flashMessage = document.getElementById("flash-message");
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.classList.add("fade-out");
                setTimeout(function() {
                    flashMessage.style.display = "none";
                }, 1000);
            }, 3000);
        }
    };
</script>
