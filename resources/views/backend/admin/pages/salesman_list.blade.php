@extends('backend.admin.includes.admin_layout')
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-2" style="text-align:center">
                        <h3>Sales Man List</h3>
                    </div>
                    <div class="mt-3">
                        @if (session('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                        @endif
                        <div id="success"></div>
                        <div id="failed"></div>
                    </div>
                    <div class="table-responsive" id="print_data">
                        <table id="dataTableExample" class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="">SL</th>
                                    <th style="">Name</th>
                                    <th style="">Email</th>
                                    <th style="">Phone</th>
                                   
                                    <th style="">User Type</th>
                                    <th style="">Image</th>
                                    <th style="width:15%">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['salesman_list'] as $key => $single_salesman)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td> {{$single_salesman -> name}} </td>
                                    <td> {{$single_salesman -> email}} </td>
                                    <td> {{$single_salesman -> phone}} </td>
                                    
                                    <td> {{$single_salesman -> user_type}} </td>

                                    <td>
                                        <img src="{{ asset($single_salesman->photo ? $single_salesman->photo : 'backend_assets/images/user-dummy.png') }}"
                                            alt="" loading="lazy" style="width:1000px">
                                    </td>
                                    <td>
                                        <a href="{{route('admin.salesman.edit', $single_salesman->id)}}"
                                            class="btn btn-success btn-icon" href=""><i
                                                class="fa-solid fa-edit"></i></a>

                                        <a class="btn btn-danger btn-icon" data-delete="{{$single_salesman->id}}"
                                            id="delete"><i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).on('click', '#delete', function() {
        if (confirm('Are You Sure ?')) {
            let id = $(this).attr('data-delete');
            let row = $(this).closest('tr');
            $.ajax({
                url: '/admin/salesman/delete/' + id,
                success: function(data) {
                    var data_object = JSON.parse(data);
                    if (data_object.status == 'SUCCESS') {
                        row.remove();
                        $('#Table tbody tr').each(function(index) {
                            $(this).find('td:first').text(index + 1);
                        });
                        $('#success').css('display', 'block');
                        $('#success').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    } else {
                        $('#failed').html('display', 'block');
                        $('#failed').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    }

                }
            });
        }
    });
</script>
@endpush