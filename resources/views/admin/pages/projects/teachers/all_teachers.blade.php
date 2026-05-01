@extends('admin.admin_master')
@section('admin')

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('edit.project') ? 'active' : '' }}" 
                href="{{ route('edit.project',$project->id) }}">
                    <i class="bi bi-pencil-square me-1"></i> Detail
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.class') ? 'active' : '' }}" 
                href="{{ route('all.projects.class', $project->id) }}">
                    <i class="bi bi-easel2 me-1"></i> Classes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.teachers') ? 'active' : '' }}" 
                href="{{ route('all.projects.teachers', $project->id) }}">
                    <i class="bi bi-person-video3 me-1"></i> Teachers
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.students') ? 'active' : '' }}" 
                href="{{ route('all.projects.students', $project->id) }}">
                    <i class="bi bi-people-fill me-1"></i> Students
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.shura') ? 'active' : '' }}" 
                href="{{ route('all.projects.shura', $project->id) }}">
                    <i class="bi bi-building"></i> Shura
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.shura.members') ? 'active' : '' }}" 
                href="{{ route('all.projects.shura.members', $project->id) }}">
                    <i class="bi bi-person-lines-fill"></i> Shura Members
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">
                    <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h5>{{ $project->name }} Teachers</h5>
                        </div>

                        <div class="text-end me-2">
                            <form action="{{ route('import.projects.teachers', $project->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="excel_file" class="form-control form-control-sm d-inline" style="width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Upload Excel
                                </button>
                            </form>

                            <a href="{{ route('export.projects.teachers', [$project->id, 'template']) }}" 
                            class="btn btn-info btn-sm">
                                Download Template
                            </a>

                            <a href="{{ route('export.projects.teachers', [$project->id, 'data']) }}" 
                            class="btn btn-primary btn-sm">
                                Export Data
                            </a>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                Add Teacher
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = [
                            'Serial Number',
                            'CBE List',
                            'Province',
                            'District',
                            'Village',
                            'First Name',
                            'Last Name',
                            'Father Name',
                            'Starting Date',
                            'Active',
                            'Tazkira',
                            'Year Birth',
                            'Gender',
                            'Teacher Type',
                            'Qualification',
                            'Phone',
                            'Core Training',
                            'Refresher Training',
                            'Action'
                        ];

                        $rows = [];

                        foreach($teachers as $key => $item){
                            $rows[] = [
                                $item->serial_number,
                                $item->cbe_list,
                                $item->province?->name ?? '',
                                $item->district?->name ?? '',
                                $item->village,
                                $item->first_name,
                                $item->last_name,
                                $item->father_name,
                                $item->starting_date,
                                $item->is_active ? 'Yes' : 'No',
                                $item->tazkira_number,
                                $item->year_of_birth,
                                $item->gender,
                                $item->teacher_type,
                                $item->qualification,
                                $item->phone,
                                $item->core_training ? 'Yes' : 'No',
                                $item->refresher_training ? 'Yes' : 'No',
                                '<div class="dropdown dropstart dropend dropup">
                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink'.$item->id.'"
                                    data-bs-toggle="dropdown" 
                                    data-bs-auto-close="outside" 
                                    data-bs-display="dynamic"
                                    aria-expanded="false">
                                        <i class="bi bi-list"></i>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$item->id.'">
                                        <li>
                                            <a class="dropdown-item" href="#" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editTeacherModal'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.projects.teacher', $item->id) . '" 
                                                class="dropdown-item text-danger delete-confirm">
                                                    Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>'
                            ];
                        }
                    @endphp

                    <x-table :headers="$headers" :rows="$rows" />

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD TEACHER MODAL -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.projects.teacher', $project->id) }}" method="POST">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Starting Date</label>
                            <input type="date" name="starting_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Serial Number</label>
                            <input type="text" name="serial_number" class="form-control" value="{{ $nextSerial }}" placeholder="Serial Number">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>CBE List</label>
                            <input type="text" name="cbe_list" class="form-control" placeholder="CBE List">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Father Name</label>
                            <input type="text" name="father_name" class="form-control" placeholder="Father Name">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tazkira Number</label>
                            <input type="text" name="tazkira_number" class="form-control" placeholder="Tazkira Number">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Year of Birth</label>
                            <input type="number" name="year_of_birth" class="form-control" placeholder="Year of Birth">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Qualification</label>
                            <input type="text" name="qualification" class="form-control" placeholder="Qualification">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Teacher Type</label>
                            <input type="text" name="teacher_type" class="form-control" placeholder="Teacher Type">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Province</label>
                            <select name="province_id" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>District</label>
                            <select name="district_id" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Village</label>
                            <input type="text" name="village" class="form-control" placeholder="Village">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Is Active?</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Core Training</label>
                            <select name="core_training" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Refresher Training</label>
                            <select name="refresher_training" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- EDIT TEACHER MODAL -->
@foreach($teachers as $item)
    <div class="modal fade" id="editTeacherModal{{$item->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('update.projects.teacher', $item->id) }}" method="POST">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>Starting Date</label>
                                <input type="date" name="starting_date" class="form-control" value="{{ $item->starting_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ $item->serial_number }}">
                                {{-- <input type="text" name="serial_number" class="form-control" value="{{ $nextSerial }}"> --}}
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>CBE List</label>
                                <input type="text" name="cbe_list" class="form-control" value="{{ $item->cbe_list }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $item->first_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $item->last_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control" value="{{ $item->father_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $item->phone }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Tazkira Number</label>
                                <input type="text" name="tazkira_number" class="form-control" value="{{ $item->tazkira_number }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Year of Birth</label>
                                <input type="number" name="year_of_birth" class="form-control" value="{{ $item->year_of_birth }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Qualification</label>
                                <input type="text" name="qualification" class="form-control" value="{{ $item->qualification }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Teacher Type</label>
                                <input type="text" name="teacher_type" class="form-control" value="{{ $item->teacher_type }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Province</label>
                                <select name="province_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                            {{ $item->province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>District</label>
                                <select name="district_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" 
                                            {{ $item->district_id == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Village</label>
                                <input type="text" name="village" class="form-control" value="{{ $item->village }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" {{ $item->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $item->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Is Active?</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $item->is_active == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->is_active == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Core Training</label>
                                <select name="core_training" class="form-control">
                                    <option value="1" {{ $item->core_training == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->core_training == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Refresher Training</label>
                                <select name="refresher_training" class="form-control">
                                    <option value="1" {{ $item->refresher_training == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->refresher_training == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection

@section('scripts') 
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                scrollX: true,
                autoWidth: false
            });
        });
    </script>
@endsection