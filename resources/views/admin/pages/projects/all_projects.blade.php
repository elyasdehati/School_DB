@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="card mt-1">
            <div class="card-header">
                <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h5 class="mb-0">Projects</h5>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('add.project') }}" class="btn btn-secondary">Add Project</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive"> 
                                    <table id="datatable" class="table table-bordered nowrap">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Contract #</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Thematic Area</th>
                                                <th>Donnor</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($project as $key=> $item)
                                                <tr class="text-center">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->project_contract_no }}</td>
                                                    <td><a href="{{ route('edit.project',$item->id) }}">{{ $item->name }}</a></td>
                                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }} ⇒ {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</td>
                                                    <td>{{ $item->thematic_area }}</td>
                                                    <td>{{ $item->donor }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown dropstart dropend dropup">
                                                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                                                            id="dropdownMenuLink{{ $item->id }}"
                                                            data-bs-toggle="dropdown" 
                                                            data-bs-auto-close="outside" 
                                                            data-bs-display="dynamic"
                                                            aria-expanded="false">
                                                                <i class="bi bi-list"></i>
                                                            </a>

                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $item->id }}">
                                                                <li><a class="dropdown-item" href="{{ route('show.project', $item->id) }}">Show</a></li>
                                                                <li><a class="dropdown-item" href="{{ route('edit.project', $item->id) }}">Edit</a></li>
                                                                <li>
                                                                    <a href="{{ route('delete.project',$item->id) }}" 
                                                                    class="dropdown-item text-danger delete-confirm">
                                                                        Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- table-responsive -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div> <!-- container-fluid -->

</div> <!-- content -->

@endsection

@section('scripts') 
<script>
$(document).ready(function() {
    if (! $.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable({
            scrollX: true, 
            autoWidth: false
        });
    }
});
</script>
@endsection