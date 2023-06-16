@if (session('flash_message'))
<div class="alert alert-success alert-dismissible fade show" role="success">
    {{ session('flash_message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('withdraw_message'))
<div class="alert alert-danger alert-dismissible fade show" role="danger">
    {{ session('withdraw_message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

