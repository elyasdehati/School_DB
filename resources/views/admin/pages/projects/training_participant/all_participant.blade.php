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

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.training') ? 'active' : '' }}" 
                href="{{ route('all.training', $project->id) }}">
                    <i class="bi bi-clipboard2-check-fill"></i> Training
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.training.participant') ? 'active' : '' }}" 
                href="{{ route('all.training.participant', $project->id) }}">
                    <i class="bi bi-people"></i> Training Participant
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
                            <h5>{{ $project->name }} Training Participant</h5>
                        </div>

                        <div class="text-end me-2">
                            <form action="{{ route('import.training', $project->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="excel_file" class="form-control form-control-sm d-inline" style="width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Upload Excel
                                </button>
                            </form>

                            <a href="{{ route('export.training', [$project->id, 'template']) }}" 
                            class="btn btn-info btn-sm">
                                Download Template
                            </a>

                            <a href="{{ route('export.training', [$project->id, 'data']) }}"
                            class="btn btn-primary btn-sm">
                                Export Data
                            </a>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTrainingParticipant">
                                Add Participant
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['No','Project','Training Type','Province','District','Village','First Name','Last Name','Father Name','Trainee Type','Gender','Age','Is Disabled','Disability Type','Phone','Pre Test (%)', 'Post Test (%)','Remarks','Action'];

                        $rows = [];

                        foreach($part as $key => $item){
                            $rows[] = [
                                $key + 1,
                                $item->project?->name ?? '',
                                $item->training_type,
                                $item->province?->name ?? '',
                                $item->district?->name ?? '',
                                $item->village,
                                $item->first_name,
                                $item->last_name,
                                $item->father_name,
                                $item->trainee_type,
                                $item->gender,
                                $item->age,
                                $item->is_disabled ? 'Yes' : 'No',
                                $item->disability_type,
                                $item->phone,
                                $item->pre_test,
                                $item->post_test,
                                $item->remarks,
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
                                            data-bs-target="#editTrainingParticipant'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.training.participant', $item->id) . '" 
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
<div class="modal fade" id="addTrainingParticipant" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.training.participant', $project->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Participant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label for="name">Project Name</label>
                            <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Training Type</label>
                            <select class="form-control" name="training_type">
                                <option value="">-- Select --</option>
                                <option value="Core Training">Core Training</option>
                                <option value="Refresher Training">
                                    Refresher Training
                                </option>
                                <option value="GRM">GRM</option>
                            </select>
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
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Father Name</label>
                            <input type="text" name="father_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="trainee_type">Trainee Type</label>
                            <select class="form-control" name="trainee_type" id="trainee_type">
                                <option value="">-- Select --</option>
                                <option value="Teacher" {{ old('trainee_type') == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="School Teacher" {{ old('trainee_type') == 'School Teacher' ? 'selected' : '' }}>School Teacher</option>
                                <option value="PED" {{ old('trainee_type') == 'PED' ? 'selected' : '' }}>PED</option>
                                <option value="DED" {{ old('trainee_type') == 'DED' ? 'selected' : '' }}>DED</option>
                                <option value="PDoE" {{ old('trainee_type') == 'PDoE' ? 'selected' : '' }}>PDoE</option>
                                <option value="SMS Member" {{ old('trainee_type') == 'SMS Member' ? 'selected' : '' }}>SMS Member</option>
                                <option value="Community Mobilizer" {{ old('trainee_type') == 'Community Mobilizer' ? 'selected' : '' }}>Community Mobilizer</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Is Disabled</label>
                            <select name="is_disabled" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2 disability-box">
                            <label>Disability Type</label>
                            <input type="text" name="disability_type" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Pre Test</label>
                            <input type="text" name="pre_test" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Post Test</label>
                            <input type="text" name="post_test" class="form-control">
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

@foreach($part  as $item)
    <div class="modal fade" id="editTrainingParticipant{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.training.participant', $item->id) }}" method="POST">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Training</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>Project</label>
                                <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Training Type</label>

                                <select class="form-control" name="training_type">
                                    <option value="">-- Select --</option>

                                    <option value="Core Training"
                                        {{ $item->training_type == 'Core Training' ? 'selected' : '' }}>
                                        Core Training
                                    </option>

                                    <option value="Refresher Training"
                                        {{ $item->training_type == 'Refresher Training' ? 'selected' : '' }}>
                                        Refresher Training
                                    </option>

                                    <option value="GRM"
                                        {{ $item->training_type == 'GRM' ? 'selected' : '' }}>
                                        GRM
                                    </option>
                                </select>
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
                                <input type="text" name="village" class="form-control"
                                    value="{{ $item->village }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $item->first_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="{{ $item->last_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Father Name</label>
                                <input type="text" name="father_name" class="form-control"
                                    value="{{ $item->father_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Trainee Type</label>
                                <select class="form-control" name="trainee_type">
                                    <option value="">-- Select --</option>
                                    <option value="Teacher" {{ $item->trainee_type == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="School Teacher" {{ $item->trainee_type == 'School Teacher' ? 'selected' : '' }}>School Teacher</option>
                                    <option value="PED" {{ $item->trainee_type == 'PED' ? 'selected' : '' }}>PED</option>
                                    <option value="DED" {{ $item->trainee_type == 'DED' ? 'selected' : '' }}>DED</option>
                                    <option value="PDoE" {{ $item->trainee_type == 'PDoE' ? 'selected' : '' }}>PDoE</option>
                                    <option value="SMS Member" {{ $item->trainee_type == 'SMS Member' ? 'selected' : '' }}>SMS Member</option>
                                    <option value="Community Mobilizer" {{ $item->trainee_type == 'Community Mobilizer' ? 'selected' : '' }}>Community Mobilizer</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" {{ $item->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $item->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Age</label>
                                <input type="number" name="age" class="form-control"
                                    value="{{ $item->age }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Is Disabled</label>
                                <select name="is_disabled" class="form-control">
                                    <option value="0" {{ $item->is_disabled == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $item->is_disabled == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2 disability-box">
                                <label>Disability Type</label>
                                <input type="text" name="disability_type" class="form-control" value="{{ $item->disability_type }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ $item->phone }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Pre Test</label>
                                <input type="text" name="pre_test" class="form-control"
                                    value="{{ $item->pre_test }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Post Test</label>
                                <input type="text" name="post_test" class="form-control"
                                    value="{{ $item->post_test }}">
                            </div>

                            <div class="col-md-4 mb-2">
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
function toggleDisability(select) {
    let box = select.closest('.row').querySelector('.disability-box');

    if (select.value == "1") {
        box.style.opacity = "0.4";
        box.style.pointerEvents = "none";
        box.querySelector('input').disabled = true;
    } else {
        box.style.opacity = "1";
        box.style.pointerEvents = "auto";
        box.querySelector('input').disabled = false;
    }
}

// on load
document.querySelectorAll('select[name="is_disabled"]').forEach(function (el) {
    toggleDisability(el);

    el.addEventListener('change', function () {
        toggleDisability(this);
    });
});

document.addEventListener('change', function (e) {
    if (e.target.name === 'province_id') {

        let provinceId = e.target.value;
        let form = e.target.closest('form');
        let districtSelect = form.querySelector('[name="district_id"]');

        districtSelect.innerHTML = '<option>Loading...</option>';

        fetch('/get-participant-districts/' + provinceId)
            .then(res => res.text())
            .then(text => {
                let data = JSON.parse(text); // safe check

                districtSelect.innerHTML = '<option value="">-- Select --</option>';

                data.forEach(d => {
                    districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                });
            })
            .catch(err => {
                console.log(err);
                districtSelect.innerHTML = '<option>Error loading</option>';
            });
    }
});
</script>

@endsection