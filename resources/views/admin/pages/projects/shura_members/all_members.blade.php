@extends('admin.admin_master')
@section('admin')

<style>
    .select2-container--default .select2-selection--multiple,
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
        border: 1px solid #ced4da;
        border-radius: .375rem;
    }

    .select2-container--default .select2-selection--multiple {
        display: flex;
        align-items: center;
    }
</style>

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
                            <h5>{{ $project->name }} Shura Members</h5>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addShuraMemberModal">
                                Add Member
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = [
                            'Shura Sno',
                            'Project',
                            'First Name',
                            'Last Name',
                            'Father Name',
                            'Tazkira No',
                            'Year Birth',
                            'Age',
                            'Gender',
                            'Education',
                            'Language',
                            'Residence',
                            'Disabled',
                            'Disability Type',
                            'Role',
                            'Phone',
                            'Status',
                            'Remarks',
                            'Action'
                        ];

                        $rows = [];

                        foreach($members as $key => $item){
                            $rows[] = [
                                $item->shura->sno ?? '',
                                $project->name,
                                $item->first_name,
                                $item->last_name,
                                $item->father_name,
                                $item->tazkira_no,
                                $item->year_of_birth,
                                $item->age,
                                $item->gender,
                                $item->education_level,
                                $item->language,
                                $item->residence_type,
                                $item->is_disabled ? 'Yes' : 'No',
                                $item->disability_type,
                                $item->role,
                                $item->phone,
                                $item->status ? 'Active' : 'Inactive',
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
                                            data-bs-target="#editShuraMembersModal'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.projects.shura', $item->id) . '" 
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
<div class="modal fade" id="addShuraMemberModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.projects.shura.members', $project->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Sno</label>
                            <select name="shura_id" class="form-control">
                                @foreach($shura as $item)
                                    {{-- <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->shura_name }}</option> --}}
                                    <option value="{{ $item->sno }}">{{ $item->sno }} - {{ $item->shura_name }}</option>
                                @endforeach
                            </select>
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
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Education Level</label>
                            <select name="education_level" class="form-control">
                                <option value="Illiterate">Illiterate</option>
                                <option value="Grade-6">Grade-6</option>
                                <option value="Grade-9">Grade-9</option>
                                <option value="Grade-12">Grade-12</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Language</label>
                            <select name="language" class="form-control">
                                <option value="Dari">Dari</option>
                                <option value="Pashto">Pashto</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Residence Type</label>
                            <select name="residence_type" class="form-control">
                                <option value="Host Community">Host Community</option>
                                <option value="IDP">IDP</option>
                                <option value="Returnee">Returnee</option>
                                <option value="Refugee">Refugee</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Is Disabled</label>
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
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option value="Shura Head">Shura Head</option>
                                <option value="Member">Member</option>
                                <option value="Assistant">Assistant</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
@foreach($members as $item)
    <div class="modal fade" id="editShuraMembersModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.projects.shura.members', $item->id) }}" method="POST">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Shura Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>Shura ID</label>
                                <select name="shura_id" class="form-control">
                                    @foreach($shura as $s)
                                        <option value="{{ $s->sno }}" {{ $item->shura_id == $s->sno ? 'selected' : '' }}>
                                            {{ $s->sno }} - {{ $s->shura_name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <label>Education Level</label>
                                <select name="education_level" class="form-control">
                                    <option value="Illiterate" {{ $item->education_level == 'Illiterate' ? 'selected' : '' }}>Illiterate</option>
                                    <option value="Grade-6" {{ $item->education_level == 'Grade-6' ? 'selected' : '' }}>Grade-6</option>
                                    <option value="Grade-9" {{ $item->education_level == 'Grade-9' ? 'selected' : '' }}>Grade-9</option>
                                    <option value="Grade-12" {{ $item->education_level == 'Grade-12' ? 'selected' : '' }}>Grade-12</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Language</label>
                                <select name="language" class="form-control">
                                    <option value="Dari" {{ $item->language == 'Dari' ? 'selected' : '' }}>Dari</option>
                                    <option value="Pashto" {{ $item->language == 'Pashto' ? 'selected' : '' }}>Pashto</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Residence Type</label>
                                <select name="residence_type" class="form-control">
                                    <option value="Host Community" {{ $item->residence_type == 'Host Community' ? 'selected' : '' }}>Host Community</option>
                                    <option value="IDP" {{ $item->residence_type == 'IDP' ? 'selected' : '' }}>IDP</option>
                                    <option value="Returnee" {{ $item->residence_type == 'Returnee' ? 'selected' : '' }}>Returnee</option>
                                    <option value="Refugee" {{ $item->residence_type == 'Refugee' ? 'selected' : '' }}>Refugee</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Is Disabled</label>
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
                                <label>Role</label>
                                <select name="role" class="form-control">
                                    <option value="Shura Head" {{ $item->role == 'Shura Head' ? 'selected' : '' }}>Shura Head</option>
                                    <option value="Member" {{ $item->role == 'Member' ? 'selected' : '' }}>Member</option>
                                    <option value="Assistant" {{ $item->role == 'Assistant' ? 'selected' : '' }}>Assistant</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $item->phone }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Inactive</option>
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

{{-- <script>
    document.addEventListener('change', function (e) {

        // Add modal
        if (e.target.id === 'class_id') {
            let selected = e.target.options[e.target.selectedIndex];
            document.getElementById('class_name').value = selected.dataset.name;
        }

        // Edit modal
        if (e.target.classList.contains('class-select')) {
            let selected = e.target.options[e.target.selectedIndex];
            let classNameInput = e.target.closest('.row').querySelector('.class-name');
            classNameInput.value = selected.dataset.name;
        }

    });
</script> --}}

{{-- @push('scripts')
<script>
    $(document).ready(function () {

        $('#class_ids').select2({
            placeholder: "",
            width: '100%',
            dropdownParent: $('#addShuraModal')
        });

    });
</script>

<script>
    $(document).ready(function () {

        // ADD modal
        $('#class_ids').select2({
            width: '100%',
            dropdownParent: $('#addShuraModal')
        });

        // EDIT modal
        $('.edit-class-select').each(function () {
            $(this).select2({
                width: '100%',
                dropdownParent: $(this).closest('.modal')
            });
        });

    });
</script> --}}
{{-- @endpush --}}

<script>
    // ================= AUTO AGE =================
    document.addEventListener('input', function (e) {

        if (e.target.name === 'year_of_birth') {

            let birthYear = parseInt(e.target.value);

            if (isNaN(birthYear)) return;

            let currentYear;

            if (birthYear > 1500) {
                currentYear = new Date().getFullYear(); 
            } else {
                currentYear = 1405; 
            }

            let age = currentYear - birthYear;

            let ageInput = e.target.closest('.row').querySelector('[name="age"]');

            if (ageInput) {
                ageInput.value = age >= 0 ? age : '';
            }
        }

    });

    // ================= DISABILITY TOGGLE =================
    document.querySelectorAll('form').forEach(function (form) {

        const isDisabled = form.querySelector('[name="is_disabled"]');
        const disabilityType = form.querySelector('[name="disability_type"]')?.closest('.col-md-4');

        function toggleDisability() {
            if (!isDisabled || !disabilityType) return;

            if (isDisabled.value == "0") {
                disabilityType.style.opacity = "0.4";
                disabilityType.querySelector('input').disabled = true;
            } else {
                disabilityType.style.opacity = "1";
                disabilityType.querySelector('input').disabled = false;
            }
        }

        if (isDisabled) {
            isDisabled.addEventListener('change', toggleDisability);
            toggleDisability();
        }

    });
</script>

@endsection