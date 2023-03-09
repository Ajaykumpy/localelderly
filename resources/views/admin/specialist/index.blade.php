@extends('admin.layouts.default')
@section('title')
Admin - Specialist
@endsection
@section('head')
<!-- <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">  -->
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection
@section('content')
<!-- content -->
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="doc-badge me-3">Specialities <span class="ms-1">{{$count}}</span></div>
               <!--  <a href="{{route('admin.specialist.create')}}" data-bs-toggle="modal" data-bs-target="#addModal"
                    class="btn btn-primary btn-add"><i class="feather-plus-square me-1"></i> Add New</a> -->
                <a href="{{route('admin.specialist.create')}}" class="btn btn-primary btn-add"><i class="feather-plus-square me-1"></i> Add New</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Specialities</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example3" class="table table-bordered dt-responsive nowrap display data-table">
                            <thead class="thead-light">
                                            <tr>
                                                <th>SID</th>
                                                <th>Title</th>
												<th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Speciality as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>
                                                        {{-- <h2 class="table-avatar">
                                                            <a href="#" class="spl-img"><img
                                                                    src="{{ asset('storage/'.$item->icon) }}" class="img-fluid"
                                                                    alt="User Image"></a> --}}
                                                            <span>{{$item->name}}</span>
                                                        {{-- </h2> --}}
                                                    </td>
													<td>{!!($item->status)?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>'!!}</td>
                                                    <td class="">
                                                        <div class="actions">
                                                            <a class="text-black" href="{{route('admin.specialist.edit',$item->id)}}">
                                                                <i class="feather-edit-3 me-1"></i> Edit
                                                            </a>
                                                            <a class="text-danger delete-speciality pointer-link"  onclick="spec_del('{{$item->id}}')" data-id="{{$item->id}}">
                                                                <i class="feather-trash-2 me-1"></i> Delete
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
    function spec_del(id){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
            type:'post',
            url:'{!! route("admin.specialist.destroy",'+id+') !!}',
            data:{_token:'{{csrf_token()}}',_method:'delete',id:id},
            success:function(data){
                Swal.fire('Deleted!','Your file has been deleted.','success')
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var data=$.parseJSON(jqXHR.responseText);
                Swal.fire('Error!','Failed','error')
            }
        });


      }
    })
}
</script>

@endpush


@section('scripts')
<!-- script -->


<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<script>
    $(document).ready(function() {
        $('#example3').DataTable({
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
@stop
