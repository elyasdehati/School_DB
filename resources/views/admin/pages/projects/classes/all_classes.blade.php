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
                            <h5>{{ $project->name }} Class</h5>
                        </div>

                        <div class="text-end me-2">
                            <form action="{{ route('import.projects.classes', $project->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="excel_file" class="form-control form-control-sm d-inline" style="width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Upload Excel
                                </button>
                            </form>

                            <a href="{{ route('export.projects.classes', [$project->id, 'template']) }}" 
                            class="btn btn-info btn-sm">
                                Download Template
                            </a>

                            <a href="{{ route('export.projects.classes', [$project->id, 'data']) }}" 
                            class="btn btn-primary btn-sm">
                                Export Data
                            </a>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                                Add Class
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['Class Id','Class Name','grades','Class Type','Province','District','Village','Latitude','Longitude','Climate','Infrastructure','Boys Enrolled','Girls Enrolled','Total Enrolled','Demographic','Language','Establishment Date','Start Time','End Time','Shift','Is Cluster','Female Teachers','Male Teachers','Total Teachers','Is the Class Closed','Closure Date','Closure Reason','Female SMS Members','MaleSMS Members','SMS Members','Has Hub School','Hub School Name','Hub Distance KM','SIP Completed','Remarks','Class Status', 'Action'];

                        $rows = [];

                        foreach($class as $key => $item){
                            $rows[] = [
                                // $key + 1,
                                $item->class_id,
                                $item->class_name,
                                $item->grades,
                                $item->class_type,
                                $item->province?->name ?? '',
                                $item->district?->name ?? '',
                                $item->village,
                                $item->latitude,
                                $item->longitude,
                                $item->climate,
                                $item->infrastructure,
                                $item->boys_enrolled,
                                $item->girls_enrolled,
                                $item->total_enrolled,
                                $item->demographic,
                                $item->language,
                                // $item->class_status,
                                $item->establishment_date,
                                $item->start_time,
                                $item->end_time,
                                $item->shift,
                                $item->is_cluster ? 'Yes' : 'No',
                                $item->female_teachers,
                                $item->male_teachers,
                                $item->cbe_teachers,
                                $item->is_closed ? 'Yes' : 'No',
                                $item->closure_date,
                                $item->closure_reason,
                                $item->female_sms_members,
                                $item->male_sms_members,
                                $item->sms_members,
                                $item->has_hub_school ? 'Yes' : 'No',
                                $item->hub_school_name,
                                $item->hub_distance_km,
                                $item->sip_completed ? 'Yes' : 'No',
                                $item->remarks,
                                $item->class_status ? 'Active' : 'Inactive',
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
                                            data-bs-target="#editClassModal'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.projects.class', $item->id) . '" 
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
{{-- ================= ADD CLASS MODAL (FULL MIGRATION) ================= --}}
<div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <form action="{{ route('store.projects.class', $project->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Registration Date</label>
                            <input type="date" name="registration_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="name">Project Name</label>
                            <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="donnor">Donnor</label>
                            <input class="form-control" placeholder="Donnor" name="donnor" type="text" value="{{ $project->donor }}" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Class Id</label>
                            <input type="text" name="class_id" class="form-control" value="{{ $nextClassId }}">
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label>Class Name</label>
                            <input type="text" name="class_name" class="form-control">
                        </div> --}}

                        <div class="col-md-4 mb-2">
                            <label for="class_name">Class Name</label>
                            <input type="text" name="class_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="grades">Grades</label>
                            <select class="form-control" name="grades" id="grades">
                                <option value="">-- Select --</option>
                                <option value="grade1" {{ old('grades') == 'grade1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="grade2" {{ old('grades') == 'grade2' ? 'selected' : '' }}>Grade 2</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Class Type</label>
                            <input type="text" name="class_type" class="form-control">
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
                            <input type="text" name="village" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control latitude">
                            <div class="invalid-feedback">
                                Please enter a valid latitude value between -90 and 90.
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control longitude">
                            <div class="invalid-feedback">
                                Please enter a valid longitude value between -180 and 180.
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="climate">Climate</label>
                            <select class="form-control" name="climate" id="climate">
                                <option value="">-- Select --</option>
                                <option value="Cold" {{ old('climate') == 'Cold' ? 'selected' : '' }}>Cold</option>
                                <option value="Hot" {{ old('climate') == 'Hot' ? 'selected' : '' }}>Hot</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="infrastructure">Infrastructure</label>
                            <select class="form-control" name="infrastructure" id="infrastructure">
                                <option value="">-- Select --</option>
                                <option value="Mosque" {{ old('infrastructure') == 'Mosque' ? 'selected' : '' }}>Mosque</option>
                                <option value="Community Space" {{ old('infrastructure') == 'Community Space' ? 'selected' : '' }}>Community Space</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Boys Enrolled</label>
                            <input type="number" name="boys_enrolled" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Girls Enrolled</label>
                            <input type="number" name="girls_enrolled" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Total Enrolled</label>
                            <input type="number" name="total_enrolled" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="demographic">Demographic</label>
                            <select class="form-control" name="demographic" id="demographic">
                                <option value="">-- Select --</option>
                                <option value="Boys" {{ old('demographic') == 'Boys' ? 'selected' : '' }}>Boys</option>
                                <option value="Girls" {{ old('demographic') == 'Girls' ? 'selected' : '' }}>Girls</option>
                                <option value="Mixed" {{ old('demographic') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="language">Language</label>
                            <select class="form-control" name="language" id="language">
                                <option value="">-- Select --</option>
                                <option value="Pashto" {{ old('language') == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                <option value="Persian" {{ old('language') == 'Persian' ? 'selected' : '' }}>Persian</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Class Status</label>
                            <select name="class_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Start Time</label>
                            <input type="time" name="start_time" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="shift">Shift</label>
                            <select class="form-control" name="shift" id="shift">
                                <option value="">-- Select --</option>
                                <option value="Morning" {{ old('shift') == 'Morning' ? 'selected' : '' }}>Morning</option>
                                <option value="Evening" {{ old('shift') == 'Evening' ? 'selected' : '' }}>Evening</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Is Cluster</label>
                            <select name="is_cluster" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Female Teachers</label>
                            <input type="number" name="female_teachers" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Male Teachers</label>
                            <input type="number" name="male_teachers" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Total Teachers</label>
                            <input type="text" name="cbe_teachers" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Is the Class Closed</label>
                            <select name="is_closed" class="form-control">
                                <option value="1" {{ old('is_closed', 0) == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('is_closed', 0) == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Closure Date</label>
                            <input type="date" name="closure_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Closure Reason</label>
                            <textarea name="closure_reason" class="form-control" rows="1" cols="1"></textarea>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Female SMS Members</label>
                            <input type="number" name="female_sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter a valid number for female SMS members.
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Male SMS Members</label>
                            <input type="number" name="male_sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter a valid number for male SMS members.
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Total SMS Members</label>
                            <input type="text" name="sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter SMS members information.
                            </div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Has Hub School</label>
                            <select name="has_hub_school" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Hub School Name</label>
                            <input type="text" name="hub_school_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Hub Distance KM</label>
                            <input type="number" step="0.01" name="hub_distance_km" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>SIP Completed</label>
                            <select name="sip_completed" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-8 mb-2">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="1" cols="1"></textarea>
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

{{-- ================= EDIT CLASS MODAL ================= --}}
@foreach($class as $item)
    <div class="modal fade" id="editClassModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.projects.class', $item->id) }}" method="POST" class="needs-validation">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>Registration Date</label>
                                <input type="date" name="registration_date" class="form-control" value="{{ $item->registration_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="name">Project Name</label>
                                <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name" readonly>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="donnor">Donnor</label>
                                <input class="form-control" placeholder="Donnor" name="donnor" type="text" value="{{ $project->donor }}" readonly>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Class Id</label>
                                <input type="text" name="class_id" class="form-control" value="{{ $item->class_id }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="class_name">Class Name</label>
                                <input type="text" name="class_name" class="form-control" value="{{ $item->class_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="grades">Grades</label>
                                <select class="form-control" name="grades" id="grades">
                                    <option value="">-- Select --</option>
                                    <option value="grade1" {{ $item->grades == 'grade1' ? 'selected' : '' }}>Grade 1</option>
                                    <option value="grade2" {{ $item->grades == 'grade2' ? 'selected' : '' }}>Grade 2</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Class Type</label>
                                <input type="text" name="class_type" class="form-control" value="{{ $item->class_type }}">
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

                                @php
                                    $filteredDistricts = \App\Models\District::where('province_id', $item->province_id)->get();
                                @endphp

                                <select name="district_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($filteredDistricts as $district)
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
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control latitude" value="{{ $item->latitude }}">
                                <div class="invalid-feedback">
                                    Please enter a valid latitude value between -90 and 90.
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control longitude" value="{{ $item->longitude }}">
                                <div class="invalid-feedback">
                                    Please enter a valid longitude value between -180 and 180.
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="climate">Climate</label>
                                <select class="form-control" name="climate" id="climate">
                                    <option value="">-- Select --</option>
                                    <option value="Cold" {{ $item->climate == 'Cold' ? 'selected' : '' }}>Cold</option>
                                    <option value="Hot" {{ $item->climate == 'Hot' ? 'selected' : '' }}>Hot</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="infrastructure">Infrastructure</label>
                                <select class="form-control" name="infrastructure" id="infrastructure">
                                    <option value="">-- Select --</option>
                                    <option value="Mosque" {{ $item->infrastructure == 'Mosque' ? 'selected' : '' }}>Mosque</option>
                                    <option value="Community Space" {{ $item->infrastructure == 'Community Space' ? 'selected' : '' }}>Community Space</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Boys Enrolled</label>
                                <input type="number" name="boys_enrolled" class="form-control" value="{{ $item->boys_enrolled }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Girls Enrolled</label>
                                <input type="number" name="girls_enrolled" class="form-control" value="{{ $item->girls_enrolled }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Total Enrolled</label>
                                <input type="number" name="total_enrolled" class="form-control" value="{{ $item->total_enrolled }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="demographic">Demographic</label>
                                <select class="form-control" name="demographic" id="demographic">
                                    <option value="">-- Select --</option>
                                    <option value="Girls" {{ $item->demographic == 'Girls' ? 'selected' : '' }}>Girls</option>
                                    <option value="Boys" {{ $item->demographic == 'Boys' ? 'selected' : '' }}>Boys</option>
                                    <option value="Mixed" {{ $item->demographic == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="language">Language</label>
                                <select class="form-control" name="language" id="language">
                                    <option value="">-- Select --</option>
                                    <option value="Pashto" {{ $item->language == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                    <option value="Persian" {{ $item->language == 'Persian' ? 'selected' : '' }}>Persian</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Class Status</label>
                                <select name="class_status" class="form-control">
                                    <option value="1" {{ $item->class_status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $item->class_status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            {{-- <div class="col-md-4 mb-2">
                                <label>Establishment Date</label>
                                <input type="date" name="establishment_date" class="form-control" value="{{ $item->establishment_date }}">
                            </div> --}}

                            <div class="col-md-4 mb-2">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control" value="{{ $item->start_time }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control" value="{{ $item->end_time }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="shift">Shift</label>
                                <select class="form-control" name="shift" id="shift">
                                    <option value="">-- Select --</option>
                                    <option value="Morning" {{ $item->shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                                    <option value="Evening" {{ $item->shift == 'Evening' ? 'selected' : '' }}>Evening</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Is Cluster</label>
                                <select name="is_cluster" class="form-control">
                                    <option value="1" {{ $item->is_cluster == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->is_cluster == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Female Teachers</label>
                                <input type="number" name="female_teachers" class="form-control" value="{{ $item->female_teachers }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Male Teachers</label>
                                <input type="number" name="male_teachers" class="form-control" value="{{ $item->male_teachers }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Total Teachers</label>
                                <input type="text" name="cbe_teachers" class="form-control" value="{{ $item->cbe_teachers }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Is the Class Closed</label>
                                <select name="is_closed" class="form-control">
                                    <option value="1" {{ $item->is_closed == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->is_closed == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Closure Date</label>
                                <input type="date" name="closure_date" class="form-control" value="{{ $item->closure_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Closure Reason</label>
                                <textarea name="closure_reason" class="form-control"rows="1" cols="1">{{ $item->closure_reason }}</textarea>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Female SMS Members</label>
                                <input type="number" name="female_sms_members" class="form-control" value="{{ $item->female_sms_members }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Male SMS Members</label>
                                <input type="number" name="male_sms_members" class="form-control" value="{{ $item->male_sms_members }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Total SMS Members</label>
                                <input type="text" name="sms_members" class="form-control" value="{{ $item->sms_members }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Has Hub School</label>
                                <select name="has_hub_school" class="form-control">
                                    <option value="1" {{ $item->has_hub_school == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->has_hub_school == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Hub School Name</label>
                                <input type="text" name="hub_school_name" class="form-control" value="{{ $item->hub_school_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Hub Distance KM</label>
                                <input type="number" step="0.01" name="hub_distance_km" class="form-control" value="{{ $item->hub_distance_km }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>SIP Completed</label>
                                <select name="sip_completed" class="form-control">
                                    <option value="1" {{ $item->sip_completed == 1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $item->sip_completed == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-8 mb-2">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="1" cols="1">{{ $item->remarks }}</textarea>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {

        function onlyNumbers(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }

        // ================= TOTAL AUTO CALC (ADDED) =================
        function bindTotalCalculation(form) {
            const boys = form.querySelector("input[name='boys_enrolled']");
            const girls = form.querySelector("input[name='girls_enrolled']");
            const total = form.querySelector("input[name='total_enrolled']");

            if (!boys || !girls || !total) return;

            function calc() {
                let b = parseInt(boys.value) || 0;
                let g = parseInt(girls.value) || 0;
                total.value = b + g;
            }

            boys.addEventListener("input", calc);
            girls.addEventListener("input", calc);
        }
        // ==========================================================

        // ================= ADDED: TOTAL TEACHERS CALC =================
        function bindTeacherTotal(form) {
            const female = form.querySelector("input[name='female_teachers']");
            const male = form.querySelector("input[name='male_teachers']");
            const total = form.querySelector("input[name='cbe_teachers']");

            if (!female || !male || !total) return;

            function calc() {
                let f = parseInt(female.value) || 0;
                let m = parseInt(male.value) || 0;
                total.value = f + m;
            }

            female.addEventListener("input", calc);
            male.addEventListener("input", calc);
        }
        // ==========================================================

        // ================= ADDED: TOTAL SMS CALC =================
        function bindSmsTotal(form) {
            const female = form.querySelector("input[name='female_sms_members']");
            const male = form.querySelector("input[name='male_sms_members']");
            const total = form.querySelector("input[name='sms_members']");

            if (!female || !male || !total) return;

            function calc() {
                let f = parseInt(female.value) || 0;
                let m = parseInt(male.value) || 0;
                total.value = f + m;
            }

            female.addEventListener("input", calc);
            male.addEventListener("input", calc);
        }
        // ==========================================================

        // ================= ADDED: DEMOGRAPHIC AUTO =================
        function bindDemographicAuto(form) {
            const boys = form.querySelector("input[name='boys_enrolled']");
            const girls = form.querySelector("input[name='girls_enrolled']");
            const demo = form.querySelector("select[name='demographic']");

            if (!boys || !girls || !demo) return;

            function setDemo() {
                let b = parseInt(boys.value) || 0;
                let g = parseInt(girls.value) || 0;

                if (b > 0 && g > 0) {
                    demo.value = "Mixed";
                } else if (b > 0) {
                    demo.value = "Boys";
                } else if (g > 0) {
                    demo.value = "Girls";
                } else {
                    demo.value = "";
                }
            }

            boys.addEventListener("input", setDemo);
            girls.addEventListener("input", setDemo);
        }
        // ==========================================================

        // ================= ALL FORMS =================
        document.querySelectorAll(".needs-validation").forEach(function (form) {

            const lat = form.querySelector(".latitude");
            const lng = form.querySelector(".longitude");

            // Latitude validation
            if (lat) {
                lat.addEventListener("input", function () {
                    if (this.value >= -90 && this.value <= 90) {
                        this.classList.remove("is-invalid");
                        this.classList.add("is-valid");
                    } else {
                        this.classList.add("is-invalid");
                    }
                });
            }

            // Longitude validation
            if (lng) {
                lng.addEventListener("input", function () {
                    if (this.value >= -180 && this.value <= 180) {
                        this.classList.remove("is-invalid");
                        this.classList.add("is-valid");
                    } else {
                        this.classList.add("is-invalid");
                    }
                });
            }

            // Submit validation per form
            form.addEventListener("submit", function (e) {

                let valid = true;

                if (lat && (lat.value < -90 || lat.value > 90)) {
                    lat.classList.add("is-invalid");
                    valid = false;
                }

                if (lng && (lng.value < -180 || lng.value > 180)) {
                    lng.classList.add("is-invalid");
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            // Numbers only fields
            form.querySelectorAll("[name='female_sms_members']").forEach(el =>
                el.addEventListener("input", function () {
                    onlyNumbers(this);
                })
            );

            form.querySelectorAll("[name='male_sms_members']").forEach(el =>
                el.addEventListener("input", function () {
                    onlyNumbers(this);
                })
            );

            form.querySelectorAll("[name='sms_members']").forEach(el =>
                el.addEventListener("input", function () {
                    onlyNumbers(this);
                })
            );

            form.querySelectorAll("[name='hub_distance_km']").forEach(el =>
                el.addEventListener("input", function () {
                    onlyNumbers(this);
                })
            );

            // ================= CLOSE FIELDS TOGGLE =================
            const isClosed = form.querySelector("[name='is_closed']");
            const closureDate = form.querySelector("[name='closure_date']")?.closest(".col-md-4");
            const closureReason = form.querySelector("[name='closure_reason']")?.closest(".col-md-4");

            function toggleClosureFields() {
                if (!isClosed || !closureDate || !closureReason) return;

                if (isClosed.value == "0") {
                    closureDate.style.opacity = "0.4";
                    closureReason.style.opacity = "0.4";

                    closureDate.querySelector("input").disabled = true;
                    closureReason.querySelector("textarea").disabled = true;
                } else {
                    closureDate.style.opacity = "1";
                    closureReason.style.opacity = "1";

                    closureDate.querySelector("input").disabled = false;
                    closureReason.querySelector("textarea").disabled = false;
                }
            }

            if (isClosed) {
                isClosed.addEventListener("change", toggleClosureFields);
                toggleClosureFields();
            }

            // ================= HUB SCHOOL TOGGLE =================
            const hasHub = form.querySelector("[name='has_hub_school']");
            const hubName = form.querySelector("[name='hub_school_name']")?.closest(".col-md-4");
            const hubKm = form.querySelector("[name='hub_distance_km']")?.closest(".col-md-4");

            function toggleHub() {
                if (!hasHub || !hubName || !hubKm) return;

                if (hasHub.value == "0") {
                    hubName.style.opacity = "0.4";
                    hubKm.style.opacity = "0.4";

                    hubName.querySelector("input").disabled = true;
                    hubKm.querySelector("input").disabled = true;
                } else {
                    hubName.style.opacity = "1";
                    hubKm.style.opacity = "1";

                    hubName.querySelector("input").disabled = false;
                    hubKm.querySelector("input").disabled = false;
                }
            }

            if (hasHub) {
                hasHub.addEventListener("change", toggleHub);
                toggleHub();
            }

           // ================= PROVINCE → DISTRICT =================
            const province = form.querySelector("[name='province_id']");
            const district = form.querySelector("[name='district_id']");

            if (province && district) {
                province.addEventListener("change", function () {

                    let province_id = this.value;

                    district.innerHTML = `<option value="">-- Select --</option>`;

                    if (province_id) {
                        fetch(`/get-classes-districts/${province_id}`)
                            .then(res => res.json())
                            .then(data => {
                                district.innerHTML = `<option value="">-- Select --</option>`;
                                data.forEach(d => {
                                    district.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                                });
                            })
                            .catch(err => console.log(err));
                    }
                });
            }
            // ================= ADDED: TOTAL CALC =================
            bindTotalCalculation(form);
            bindTeacherTotal(form);
            bindSmsTotal(form);
            bindDemographicAuto(form);

        });

    });
</script>

@endsection