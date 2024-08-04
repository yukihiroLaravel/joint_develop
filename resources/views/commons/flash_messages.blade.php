<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
    }

    @if (Session::has('flashSuccess'))
        toastr.success("{{ session('flashSuccess') }}");
    @endif

    @if (Session::has('flashError'))
        toastr.error("{{ session('flashError') }}");
    @endif

    @if (Session::has('flashInfo'))
        toastr.info("{{ session('flashInfo') }}");
    @endif

    @if (Session::has('flashWarning'))
        toastr.warning("{{ session('flashWarning') }}");
    @endif

    @if(session('flash_msg'))
        <div class="alert alert-{{ session('cls') }}">
        {{ session('flash_msg') }}
        </div>
    @endif
</script>