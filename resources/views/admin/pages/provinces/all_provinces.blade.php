@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="container-xxl">
        <div class="card mt-1">

            <div class="card-header">
                <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h5 class="mb-0">Provinces</h5>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('add.province') }}" class="btn btn-secondary">Add Province</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table">
                                        <thead class="thead">
                                            <tr>
                                                <th>No</th>
                                                <th>Title</th>
                                                <th>Districts</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($provinces as $key => $province)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $province->name }}</td>
                                                    <td>
                                                        @foreach($province->districts as $district)
                                                            <span class="badge bg-success rounded-0">{{ $district->name }}</span>
                                                        @endforeach
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="dropdown dropstart dropend dropup">
                                                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                                                            id="dropdownMenuLink{{ $province->id }}"
                                                            data-bs-toggle="dropdown" 
                                                            data-bs-auto-close="outside" 
                                                            data-bs-display="dynamic"
                                                            aria-expanded="false">
                                                                <i class="bi bi-list"></i>
                                                            </a>

                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $province->id }}">
                                                                <li><a class="dropdown-item" href="{{ route('edit.province',$province->id) }}">Edit</a></li>
                                                                <li>
                                                                    <a href="{{ route('delete.province',$province->id) }}" class="dropdown-item text-danger delete-confirm">
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

@endsection