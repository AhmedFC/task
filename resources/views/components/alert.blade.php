@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="w-50 px-3 m-auto mb-2 alert alert-warning alert-dismissible fade show" role="alert">

    <div class="d-flex align-items-center justify-content-between">
        <p class="me-4 mb-0">{{$error}}</p>
        <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endforeach
@endif



