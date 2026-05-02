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
                            <h5>{{ $project->name }} Shura</h5>
                        </div>

                        <div class="text-end me-2">
                            <form action="{{ route('import.projects.shura', $project->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="excel_file" class="form-control form-control-sm d-inline" style="width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Upload Excel
                                </button>
                            </form>

                            <a href="{{ route('export.projects.shura', [$project->id, 'template']) }}" 
                            class="btn btn-info btn-sm">
                                Download Template
                            </a>

                            <a href="{{ route('export.projects.shura', [$project->id, 'data']) }}" 
                            class="btn btn-primary btn-sm">
                                Export Data
                            </a>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addShuraModal">
                                Add Shura
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = [
                            'SNO',
                            'Project',
                            'Province',
                            'District',
                            'Village',
                            'Shura Name',
                            'Establishment Date',
                            'Classes',
                            'Status',
                            'Status Change Date',
                            'Status Change Reason',
                            'Remarks',
                            'Action'
                        ];

                        $rows = [];

                        foreach($shura as $key => $item){
                            $rows[] = [
                                $item->sno,
                                $project->name,
                                $item->province?->name ?? '',
                                $item->district?->name ?? '',
                                $item->village,
                                $item->shura_name,
                                $item->shura_establishment_date,
                                implode(', ', $item->classes->pluck('class_name')->toArray()),
                                $item->status,
                                $item->status_change_date,
                                $item->status_change_reason,
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
                                            data-bs-target="#editShuraModal'.$item->id.'">
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
<div class="modal fade" id="addShuraModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.projects.shura',$project->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>SNO</label>
                            <input type="text" name="sno" class="form-control" value="{{ $nextSno }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Project</label>
                            <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Establishment Date</label>
                            <input type="date" name="shura_establishment_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Shura Name</label>
                            <input type="text" name="shura_name" class="form-control">
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
                            <label>Classes</label>
                            <select class="form-control select2" name="class_ids[]" id="class_ids" multiple="multiple" style="width:100%;">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">
                                        {{ $class->class_id }} - {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control status-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Status Change Date</label>
                            <input type="date" name="status_change_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Status Change Reason</label>
                            <input type="text" name="status_change_reason" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
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
@foreach($shura as $item)
    <div class="modal fade" id="editShuraModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.projects.shura', $item->id) }}" method="POST">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Shura</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>SNO</label>
                                <input type="text" name="sno" class="form-control" value="{{ $item->sno }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Project</label>
                                <input type="text" class="form-control" value="{{ $project->name }}" readonly>
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                            </div>
                            
                            <div class="col-md-4 mb-2">
                                <label>Establishment Date</label>
                                <input type="date" name="shura_establishment_date" class="form-control" value="{{ $item->shura_establishment_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Shura Name</label>
                                <input type="text" name="shura_name" class="form-control" value="{{ $item->shura_name }}">
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

                            @php
                                $selectedClasses = $item->classes->pluck('id')->toArray();
                            @endphp

                            <div class="col-md-4 mb-2">
                                <label>Classes</label>
                                <select name="class_ids[]" class="form-control select2 edit-class-select" multiple>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ in_array($class->id, $selectedClasses) ? 'selected' : '' }}>
                                            {{ $class->class_id }} - {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-2 status-extra">
                                <label>Status Change Date</label>
                                <input type="date" name="status_change_date" class="form-control" value="{{ $item->status_change_date }}">
                            </div>

                            <div class="col-md-4 mb-2 status-extra">
                                <label>Status Change Reason</label>
                                <input type="text" name="status_change_reason" class="form-control" value="{{ $item->status_change_reason }}">
                            </div>

                            <div class="col-md-4 mb-2">
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

@push('scripts')
    <script>
        $(document).ready(function () {

            $('#class_ids').select2({
                placeholder: "",
                width: '100%',
                dropdownParent: $('#addShuraModal')
            });

        });

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
    </script>
@endpush

<script>
    document.querySelectorAll('form').forEach(function (form) {

    const status = form.querySelector('select[name="status"]');
    const extras = form.querySelectorAll('.status-extra');

    function toggleStatusFields() {
        if (!status) return;

        if (status.value === "Active") {
            extras.forEach(el => {
                el.style.opacity = "0.4";
                el.querySelector('input').disabled = true;
            });
        } else {
            extras.forEach(el => {
                el.style.opacity = "1";
                el.querySelector('input').disabled = false;
            });
        }
    }

    if (status) {
        status.addEventListener('change', toggleStatusFields);
        toggleStatusFields();
    }

});
</script>

@endsection