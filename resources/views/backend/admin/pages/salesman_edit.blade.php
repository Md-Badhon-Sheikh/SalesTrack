@extends('backend.admin.includes.admin_layout')
@push('css')
@endpush
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class=" text-center mb-2">Salesman Edit</h3>
                    @if (session('success'))
                    <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong> Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="btn-close"></button>
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Failed!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="btn-close"></button>
                    </div>
                    @endif
                    <form action="{{route('admin.salesman.edit', $data['salesman']->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="" class="form-label"> Name *</label>
                                <input type="text" class="form-control" value="{{$data['salesman']->name}}" name="name"
                                    placeholder="Enter Name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="">Email *</label>
                                <input type="email" name="email" value="{{$data['salesman']->email}}" class="form-control"
                                    placeholder="Enter Email" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="">Phone</label>
                                <input type="text" name="phone" value="{{$data['salesman']->phone}}" class="form-control"
                                    placeholder="Enter Phone Number">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="">Password *</label>
                                <input type="password" name="password" value="" class="form-control"
                                    placeholder="Enter Password" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="">User Type *</label>
                                <select class="form-select js-example-basic-single" name="user_type" id="">
                                    <option value="{{$data['salesman']->user_type}}">Select Type</option>
                                    <option value="salesman" {{ (old('user_type', $data['salesman']->user_type) == 'salesman') ? 'selected' : '' }}>Salesman</option>
                                    <option value="salesman" {{ (old('user_type', $data['salesman']->user_type) == 'admin') ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="mb-3">
                                    <label class="form-label">Your Photo</label>
                                    <input name="photo" class="form-control" type="file" id="imgPreview"
                                        onchange="readpicture(this, '#imgPreviewId');">
                                </div>
                                <div class="text-center">
                                    <img id="imgPreviewId" onclick="image_upload()"
                                        src="{{asset($data['salesman']->photo ? $data['salesman']->photo : 'backend_assets/images/uploads_preview.png')}}">
                                </div>
                            </div>


                        </div>
                        <div class="text-center mt-2">
                            <button class="btn btn-xs btn-primary" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function image_upload() {

        $('#imgPreview').trigger('click');
    }

    function readpicture(input, preview_id) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(preview_id)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }

    }
</script>
@endpush