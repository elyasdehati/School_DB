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
                <a class="nav-link {{ request()->routeIs('all.projects.teachers') ? 'active' : '' }}" 
                href="{{ route('all.projects.teachers', $project->id) }}">
                    <i class="bi bi-person-video3 me-1"></i> Teachers
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.class') ? 'active' : '' }}" 
                href="{{ route('all.projects.class', $project->id) }}">
                    <i class="bi bi-easel2 me-1"></i> Classes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.students') ? 'active' : '' }}" 
                href="{{ route('all.projects.students', $project->id) }}">
                    <i class="bi bi-people-fill me-1"></i> Students
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

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                                Add Class
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['No','Class Id','Class Name','Total Enrolled', 'Female Teachers', 'Male Teacher', 'Active', 'Action'];

                        $rows = [];

                        foreach($class as $key => $item){
                            $rows[] = [
                                $key + 1,
                                $item->class_id,
                                $item->class_name,
                                $item->total_enrolled,
                                $item->female_teachers,
                                $item->male_teachers,
                                $item->class_status ? 'Yes' : 'No',
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
    <div class="modal-dialog modal-lg">

        <form action="{{ route('store.projects.class', $project->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <label>Registration Date</label>
                            <input type="date" name="registration_date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="name">Project Name</label>
                            <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="donnor">Donnor</label>
                            <input class="form-control" placeholder="Donnor" name="donnor" type="text" value="{{ $project->donor }}" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Class Id</label>
                            <input type="text" name="class_id" class="form-control">
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Class Name</label>
                            <input type="text" name="class_name" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="class_name">Class Name</label>
                            <select class="form-control" name="class_name" id="class_name">
                                <option value="">-- Select --</option>
                                <option value="CBS" {{ old('class_name') == 'CBS' ? 'selected' : '' }}>CBS</option>
                                <option value="Ongoing" {{ old('class_name') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Grades</label>
                            <input type="text" name="grades" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="grades">Grades</label>
                            <select class="form-control" name="grades" id="grades">
                                <option value="">-- Select --</option>
                                <option value="grade1" {{ old('grades') == 'grade1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="grade2" {{ old('grades') == 'grade2' ? 'selected' : '' }}>Grade 2</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Class Type</label>
                            <input type="text" name="class_type" class="form-control">
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Province</label>
                            <input type="text" name="province" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="province">Province</label>
                            <select class="form-control" name="province" id="province">
                                <option value="">-- Select --</option>
                                <option value="Kunar" {{ old('province') == 'Kunar' ? 'selected' : '' }}>Kunar</option>
                                <option value="Kabul" {{ old('province') == 'Kabul' ? 'selected' : '' }}>Kabul</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>District</label>
                            <input type="text" name="district" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="district">District</label>
                            <select class="form-control" name="district" id="district">
                                <option value="">-- Select --</option>
                                <option value="Ghazi Abad" {{ old('district') == 'Ghazi Abad' ? 'selected' : '' }}>Ghazi Abad</option>
                                <option value="Kabul" {{ old('district') == 'Kabul' ? 'selected' : '' }}>Kabul</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Village</label>
                            <input type="text" name="village" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Latitude</label>
                            <input type="text" name="latitude" class="form-control latitude">
                            <div class="invalid-feedback">
                                Please enter a valid latitude value between -90 and 90.
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Longitude</label>
                            <input type="text" name="longitude" class="form-control longitude">
                            <div class="invalid-feedback">
                                Please enter a valid longitude value between -180 and 180.
                            </div>
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Climate</label>
                            <input type="text" name="climate" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="climate">Climate</label>
                            <select class="form-control" name="climate" id="climate">
                                <option value="">-- Select --</option>
                                <option value="Cold" {{ old('climate') == 'Cold' ? 'selected' : '' }}>Cold</option>
                                <option value="Hot" {{ old('climate') == 'Hot' ? 'selected' : '' }}>Hot</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Infrastructure</label>
                            <input type="text" name="infrastructure" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="infrastructure">Infrastructure</label>
                            <select class="form-control" name="infrastructure" id="infrastructure">
                                <option value="">-- Select --</option>
                                <option value="Mosque" {{ old('infrastructure') == 'Mosque' ? 'selected' : '' }}>Mosque</option>
                                <option value="Community Space" {{ old('infrastructure') == 'Community Space' ? 'selected' : '' }}>Community Space</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Boys Enrolled</label>
                            <input type="number" name="boys_enrolled" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Girls Enrolled</label>
                            <input type="number" name="girls_enrolled" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Total Enrolled</label>
                            <input type="number" name="total_enrolled" class="form-control">
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Demographic</label>
                            <input type="text" name="demographic" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="demographic">Demographic</label>
                            <select class="form-control" name="demographic" id="demographic">
                                <option value="">-- Select --</option>
                                <option value="Mixed" {{ old('demographic') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Language</label>
                            <input type="text" name="language" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="language">Language</label>
                            <select class="form-control" name="language" id="language">
                                <option value="">-- Select --</option>
                                <option value="Pashto" {{ old('language') == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                <option value="Persian" {{ old('language') == 'Persian' ? 'selected' : '' }}>Persian</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Class Status</label><br>
                            <input type="radio" name="class_status" value="1"> Active
                            <input type="radio" name="class_status" value="0"> Inactive
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Establishment Date</label>
                            <input type="date" name="establishment_date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Start Time</label>
                            <input type="time" name="start_time" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control">
                        </div>

                        {{-- <div class="col-md-6 mb-2">
                            <label>Shift</label>
                            <input type="text" name="shift" class="form-control">
                        </div> --}}

                        <div class="col-md-6 mb-2">
                            <label for="shift">Shift</label>
                            <select class="form-control" name="shift" id="shift">
                                <option value="">-- Select --</option>
                                <option value="Morning" {{ old('shift') == 'Morning' ? 'selected' : '' }}>Morning</option>
                                <option value="Evening" {{ old('shift') == 'Evening' ? 'selected' : '' }}>Evening</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Is Cluster</label><br>
                            <input type="radio" name="is_cluster" value="1"> Yes
                            <input type="radio" name="is_cluster" value="0"> No
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Female Teachers</label>
                            <input type="number" name="female_teachers" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Male Teachers</label>
                            <input type="number" name="male_teachers" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>CBE Teachers</label>
                            <input type="text" name="cbe_teachers" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Is Closed</label><br>
                            <input type="radio" name="is_closed" value="1"> Yes
                            <input type="radio" name="is_closed" value="0"> No
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Closure Date</label>
                            <input type="date" name="closure_date" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>Closure Reason</label>
                            <textarea name="closure_reason" class="form-control"></textarea>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Female SMS Members</label>
                            <input type="number" name="female_sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter a valid number for female SMS members.
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Male SMS Members</label>
                            <input type="number" name="male_sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter a valid number for male SMS members.
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>SMS Members</label>
                            <input type="text" name="sms_members" class="form-control">
                            <div class="invalid-feedback">
                                Please enter SMS members information.
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Has Hub School</label><br>
                            <input type="radio" name="has_hub_school" value="1"> Yes
                            <input type="radio" name="has_hub_school" value="0"> No
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Hub School Name</label>
                            <input type="text" name="hub_school_name" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Hub Distance KM</label>
                            <input type="number" step="0.01" name="hub_distance_km" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>SIP Completed</label><br>
                            <input type="radio" name="sip_completed" value="1"> Yes
                            <input type="radio" name="sip_completed" value="0"> No
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
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
        <div class="modal-dialog modal-lg">

            <form action="{{ route('update.projects.class', $item->id) }}" method="POST" class="needs-validation">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-2">
                                <label>Registration Date</label>
                                <input type="date" name="registration_date" class="form-control" value="{{ $item->registration_date }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="name">Project Name</label>
                                <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name" readonly>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="donnor">Donnor</label>
                                <input class="form-control" placeholder="Donnor" name="donnor" type="text" value="{{ $project->donor }}" readonly>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Class Id</label>
                                <input type="text" name="class_id" class="form-control" value="{{ $item->class_id }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="class_name">Class Name</label>
                                <select class="form-control" name="class_name" id="class_name">
                                    <option value="">-- Select --</option>
                                    <option value="CBS" {{ $item->class_name == 'CBS' ? 'selected' : '' }}>CBS</option>
                                    <option value="Ongoing" {{ $item->class_name == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="grades">Grades</label>
                                <select class="form-control" name="grades" id="grades">
                                    <option value="">-- Select --</option>
                                    <option value="grade1" {{ $item->grades == 'grade1' ? 'selected' : '' }}>Grade 1</option>
                                    <option value="grade2" {{ $item->grades == 'grade2' ? 'selected' : '' }}>Grade 2</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-6 mb-2">
                            <label for="grades">Grades</label>
                            <select class="form-control" name="grades" id="grades">
                                <option>
                                    -- Select --
                                </option>
                                <option value="grade1" {{ old('grades') == 'grade1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="grade2" {{ old('grades') == 'grade2' ? 'selected' : '' }}>Grade 2</option>
                            </select>
                        </div> --}}

                            <div class="col-md-6 mb-2">
                                <label>Class Type</label>
                                <input type="text" name="class_type" class="form-control" value="{{ $item->class_type }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="province">Province</label>
                                <select class="form-control" name="province" id="province">
                                    <option value="">-- Select --</option>
                                    <option value="Kunar" {{ $item->province == 'Kunar' ? 'selected' : '' }}>Kunar</option>
                                    <option value="Kabul" {{ $item->province == 'Kabul' ? 'selected' : '' }}>Kabul</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="district">District</label>
                                <select class="form-control" name="district" id="district">
                                   <option value="">-- Select --</option>
                                    <option value="Ghazi Abad" {{ $item->district == 'Ghazi Abad' ? 'selected' : '' }}>Ghazi Abad</option>
                                    <option value="Kabul" {{ $item->district == 'Kabul' ? 'selected' : '' }}>Kabul</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Village</label>
                                <input type="text" name="village" class="form-control" value="{{ $item->village }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control latitude" value="{{ $item->latitude }}">
                                <div class="invalid-feedback">
                                    Please enter a valid latitude value between -90 and 90.
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control longitude" value="{{ $item->longitude }}">
                                <div class="invalid-feedback">
                                    Please enter a valid longitude value between -180 and 180.
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="climate">Climate</label>
                                <select class="form-control" name="climate" id="climate">
                                    <option value="">-- Select --</option>
                                    <option value="Cold" {{ $item->climate == 'Cold' ? 'selected' : '' }}>Cold</option>
                                    <option value="Hot" {{ $item->climate == 'Hot' ? 'selected' : '' }}>Hot</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="infrastructure">Infrastructure</label>
                                <select class="form-control" name="infrastructure" id="infrastructure">
                                    <option value="">-- Select --</option>
                                    <option value="Mosque" {{ $item->infrastructure == 'Mosque' ? 'selected' : '' }}>Mosque</option>
                                    <option value="Community Space" {{ $item->infrastructure == 'Community Space' ? 'selected' : '' }}>Community Space</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Boys Enrolled</label>
                                <input type="number" name="boys_enrolled" class="form-control" value="{{ $item->boys_enrolled }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Girls Enrolled</label>
                                <input type="number" name="girls_enrolled" class="form-control" value="{{ $item->girls_enrolled }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Total Enrolled</label>
                                <input type="number" name="total_enrolled" class="form-control" value="{{ $item->total_enrolled }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="demographic">Demographic</label>
                                <select class="form-control" name="demographic" id="demographic">
                                    <option value="">-- Select --</option>
                                    <option value="Mixed" {{ $item->demographic == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="language">Language</label>
                                <select class="form-control" name="language" id="language">
                                    <option value="">-- Select --</option>
                                    <option value="Pashto" {{ $item->language == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                    <option value="Persian" {{ $item->language == 'Persian' ? 'selected' : '' }}>Persian</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Class Status</label><br>
                                <input type="radio" name="class_status" value="1" {{ $item->class_status == 1 ? 'checked' : '' }}> Active
                                <input type="radio" name="class_status" value="0" {{ $item->class_status == 0 ? 'checked' : '' }}> Inactive
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Establishment Date</label>
                                <input type="date" name="establishment_date" class="form-control" value="{{ $item->establishment_date }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control" value="{{ $item->start_time }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control" value="{{ $item->end_time }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="shift">Shift</label>
                                <select class="form-control" name="shift" id="shift">
                                    <option value="">-- Select --</option>
                                    <option value="Morning" {{ $item->shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                                    <option value="Evening" {{ $item->shift == 'Evening' ? 'selected' : '' }}>Evening</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Is Cluster</label><br>
                                <input type="radio" name="is_cluster" value="1" {{ $item->is_cluster == 1 ? 'checked' : '' }}> Yes
                                <input type="radio" name="is_cluster" value="0" {{ $item->is_cluster == 0 ? 'checked' : '' }}> No
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Female Teachers</label>
                                <input type="number" name="female_teachers" class="form-control" value="{{ $item->female_teachers }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Male Teachers</label>
                                <input type="number" name="male_teachers" class="form-control" value="{{ $item->male_teachers }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>CBE Teachers</label>
                                <input type="text" name="cbe_teachers" class="form-control" value="{{ $item->cbe_teachers }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Is Closed</label><br>
                                <input type="radio" name="is_closed" value="1" {{ $item->is_closed == 1 ? 'checked' : '' }}> Yes
                                <input type="radio" name="is_closed" value="0" {{ $item->is_closed == 0 ? 'checked' : '' }}> No
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Closure Date</label>
                                <input type="date" name="closure_date" class="form-control" value="{{ $item->closure_date }}">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>Closure Reason</label>
                                <textarea name="closure_reason" class="form-control">{{ $item->closure_reason }}</textarea>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Female SMS Members</label>
                                <input type="number" name="female_sms_members" class="form-control" value="{{ $item->female_sms_members }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Male SMS Members</label>
                                <input type="number" name="male_sms_members" class="form-control" value="{{ $item->male_sms_members }}">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>SMS Members</label>
                                <input type="text" name="sms_members" class="form-control" value="{{ $item->sms_members }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Has Hub School</label><br>
                                <input type="radio" name="has_hub_school" value="1" {{ $item->has_hub_school == 1 ? 'checked' : '' }}> Yes
                                <input type="radio" name="has_hub_school" value="0" {{ $item->has_hub_school == 0 ? 'checked' : '' }}> No
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Hub School Name</label>
                                <input type="text" name="hub_school_name" class="form-control" value="{{ $item->hub_school_name }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Hub Distance KM</label>
                                <input type="number" step="0.01" name="hub_distance_km" class="form-control" value="{{ $item->hub_distance_km }}">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>SIP Completed</label><br>
                                <input type="radio" name="sip_completed" value="1" {{ $item->sip_completed == 1 ? 'checked' : '' }}> Yes
                                <input type="radio" name="sip_completed" value="0" {{ $item->sip_completed == 0 ? 'checked' : '' }}> No
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control">{{ $item->remarks }}</textarea>
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

        const form = document.querySelector(".needs-validation");

        const lat = document.querySelector(".latitude");
        const lng = document.querySelector(".longitude");

        // realtime latitude
        lat.addEventListener("input", function () {
            if (this.value >= -90 && this.value <= 90) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.add("is-invalid");
            }
        });

        // realtime longitude
        lng.addEventListener("input", function () {
            if (this.value >= -180 && this.value <= 180) {
                this.classList.remove("is-invalid");
                this.classList.add("is-valid");
            } else {
                this.classList.add("is-invalid");
            }
        });

        // submit validation
        form.addEventListener("submit", function (e) {

            let valid = true;

            if (lat.value < -90 || lat.value > 90) {
                lat.classList.add("is-invalid");
                valid = false;
            }

            if (lng.value < -180 || lng.value > 180) {
                lng.classList.add("is-invalid");
                valid = false;
            }

            // let boys = document.querySelector("[name='boys_enrolled']").value || 0;
            // let girls = document.querySelector("[name='girls_enrolled']").value || 0;
            // let total = document.querySelector("[name='total_enrolled']");

            // if (parseInt(boys) + parseInt(girls) != total.value) {
            //     total.classList.add("is-invalid");
            //     valid = false;
            // }

            // if (!valid) {
            //     e.preventDefault();
            //     e.stopPropagation();
            // }

        });

    });

    function onlyNumbers(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    document.querySelector("[name='female_sms_members']")
    .addEventListener("input", function () {
        onlyNumbers(this);
    });

    document.querySelector("[name='male_sms_members']")
    .addEventListener("input", function () {
        onlyNumbers(this);
    });

    document.querySelector("[name='sms_members']")
    .addEventListener("input", function () {
        onlyNumbers(this);
    });

    document.querySelector("[name='hub_distance_km']")
        .addEventListener("input", function () {
            onlyNumbers(this);
        });

    // ================= FIX FOR EDIT MODALS (ADDED ONLY) =================
    document.addEventListener("DOMContentLoaded", function () {

        const forms = document.querySelectorAll(".needs-validation");

        forms.forEach(function (form) {

            const lat = form.querySelector(".latitude");
            const lng = form.querySelector(".longitude");

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

                // let boys = form.querySelector("[name='boys_enrolled']")?.value || 0;
                // let girls = form.querySelector("[name='girls_enrolled']")?.value || 0;
                // let total = form.querySelector("[name='total_enrolled']");

                // if (total && parseInt(boys) + parseInt(girls) != total.value) {
                //     total.classList.add("is-invalid");
                //     valid = false;
                // }

                // if (!valid) {
                //     e.preventDefault();
                //     e.stopPropagation();
                // }

            });

        });

    });

    document.querySelectorAll("[name='female_sms_members']").forEach(el =>
        el.addEventListener("input", function () {
            onlyNumbers(this);
        })
    );

    document.querySelectorAll("[name='male_sms_members']").forEach(el =>
        el.addEventListener("input", function () {
            onlyNumbers(this);
        })
    );

    document.querySelectorAll("[name='sms_members']").forEach(el =>
        el.addEventListener("input", function () {
            onlyNumbers(this);
        })
    );

    document.querySelectorAll("[name='hub_distance_km']").forEach(el =>
        el.addEventListener("input", function () {
            onlyNumbers(this);
        })
    );
</script>

@endsection