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
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.projects.shura') ? 'active' : '' }}" 
                href="{{ route('all.projects.shura', $project->id) }}">
                    <i class="bi bi-building"></i> Shura
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
                            <h5>{{ $project->name }} Students</h5>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                Add Student
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['No','Student ID','Project Name','Class Name','First Name', 'Last Name', 'Tazkira Number', 'Status', 'Action'];

                        $rows = [];

                        foreach($std as $key => $item){
                            $rows[] = [
                                $key + 1,
                                $item->student_id,
                                $project->name,
                                $item->class->class_name ?? '',
                                $item->first_name,
                                $item->last_name,
                                $item->tazkira_no,
                                $item->status,
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
                                            data-bs-target="#editStudentModal'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.projects.students', $item->id) . '" 
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
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.projects.students',$project->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Student ID</label>
                            <input type="text" name="student_id" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Project</label>
                            <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Province</label>
                            <input type="text" name="province" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>District</label>
                            <input type="text" name="district" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Village</label>
                            <input type="text" name="village" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Class ID</label>
                            <select name="class_id" id="add_class_id" class="form-control">
                                @foreach($classes as $class)
                                    <option value="{{ $class->class_id }}" data-name="{{ $class->class_name }}">
                                        {{ $class->class_id }} - {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Class Name</label>
                            <input type="text" name="class_name" id="add_class_name" class="form-control" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>ASAS No</label>
                            <input type="text" name="asas_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Enrollment Date</label>
                            <input type="date" name="enrollment_date" class="form-control">
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
                            <label>Tazkira No</label>
                            <input type="text" name="tazkira_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Year of Birth</label>
                            <input type="number" name="year_of_birth" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Native Language</label>
                            <select name="native_language" class="form-control">
                                <option value="Dari">Dari</option>
                                <option value="Pashto">Pashto</option>
                                <option value="Uzbeki">Uzbeki</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Residence Type</label>
                            <select name="residence_type" class="form-control">
                                <option value="Host Community">Host Community</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Disabled?</label>
                            <select name="is_disabled" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Disability Type</label>
                            <input type="text" name="disability_type" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Guardian Phone</label>
                            <input type="text" name="guardian_phone" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Guardian Relation</label>
                            <input type="text" name="guardian_relation" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Handed Over</option>
                                <option>Transited</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status Change Date</label>
                            <input type="date" name="status_change_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status Change Reason</label>
                            <select name="status_change_reason" class="form-control">
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Handed Over</option>
                                <option>Transited</option>
                            </select>
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
@foreach($std as $item)
    <div class="modal fade" id="editStudentModal{{$item->id}}" tabindex="-1">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.projects.students', $item->id) }}" method="POST">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>Student ID</label>
                                <input type="text" name="student_id" class="form-control" value="{{ $item->student_id }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Project</label>
                                <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Province</label>
                                <input type="text" name="province" class="form-control" value="{{ $item->province }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>District</label>
                                <input type="text" name="district" class="form-control" value="{{ $item->district }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Village</label>
                                <input type="text" name="village" class="form-control" value="{{ $item->village }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Class ID</label>
                                <select name="class_id" class="form-control class-select">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->class_id }}" data-name="{{ $class->class_name }}"
                                            {{ $item->class_id == $class->class_id ? 'selected' : '' }}>
                                            {{ $class->class_id }} - {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Class Name</label>
                                <input type="text" name="class_name" class="form-control class-name" value="{{ $item->class_name }}" readonly>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>ASAS No</label>
                                <input type="text" name="asas_no" class="form-control" value="{{ $item->asas_no }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Enrollment Date</label>
                                <input type="date" name="enrollment_date" class="form-control" value="{{ $item->enrollment_date }}">
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
                                <label>Tazkira No</label>
                                <input type="text" name="tazkira_no" class="form-control" value="{{ $item->tazkira_no }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Year of Birth</label>
                                <input type="number" name="year_of_birth" class="form-control" value="{{ $item->year_of_birth }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Age</label>
                                <input type="number" name="age" class="form-control" value="{{ $item->age }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" {{ $item->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $item->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Native Language</label>
                                <select name="native_language" class="form-control">
                                    <option value="Dari" {{ $item->native_language == 'Dari' ? 'selected' : '' }}>Dari</option>
                                    <option value="Pashto" {{ $item->native_language == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                    <option value="Uzbeki" {{ $item->native_language == 'Uzbeki' ? 'selected' : '' }}>Uzbeki</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Residence Type</label>
                                <select name="residence_type" class="form-control">
                                    <option value="Host Community" {{ $item->residence_type == 'Host Community' ? 'selected' : '' }}>Host Community</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Disabled?</label>
                                <select name="is_disabled" class="form-control">
                                    <option value="0" {{ $item->is_disabled == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $item->is_disabled == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Disability Type</label>
                                <input type="text" name="disability_type" class="form-control" value="{{ $item->disability_type }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Guardian Phone</label>
                                <input type="text" name="guardian_phone" class="form-control" value="{{ $item->guardian_phone }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Guardian Relation</label>
                                <input type="text" name="guardian_relation" class="form-control" value="{{ $item->guardian_relation }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Handed Over" {{ $item->status == 'Handed Over' ? 'selected' : '' }}>Handed Over</option>
                                    <option value="Transited" {{ $item->status == 'Transited' ? 'selected' : '' }}>Transited</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status Change Date</label>
                                <input type="date" name="status_change_date" class="form-control" value="{{ $item->status_change_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status Change Reason</label>
                                <select name="status_change_reason" class="form-control">
                                    <option value="Active" {{ $item->status_change_reason == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $item->status_change_reason == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Handed Over" {{ $item->status_change_reason == 'Handed Over' ? 'selected' : '' }}>Handed Over</option>
                                    <option value="Transited" {{ $item->status_change_reason == 'Transited' ? 'selected' : '' }}>Transited</option>
                                </select>
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
document.addEventListener('DOMContentLoaded', function () {

    // Add modal
    let classSelect = document.getElementById('add_class_id');
    let className = document.getElementById('add_class_name');

    function updateClassName() {
        let selected = classSelect.options[classSelect.selectedIndex];
        className.value = selected.dataset.name;
    }

    if (classSelect) {
        classSelect.addEventListener('change', updateClassName);
        updateClassName();
    }

    // Edit modal
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('class-select')) {
            let selected = e.target.options[e.target.selectedIndex];
            let classNameInput = e.target.closest('.row').querySelector('.class-name');
            classNameInput.value = selected.dataset.name;
        }
    });

});
</script>

@endsection