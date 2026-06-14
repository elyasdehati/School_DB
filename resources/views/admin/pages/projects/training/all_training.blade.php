@extends('admin.admin_master')
@section('admin')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<style>
    .select2-container {
        z-index: 99999 !important;
    }

    .select2-container--open {
        z-index: 999999 !important;
    }

    .select2-dropdown {
        z-index: 999999 !important;
    }

    /* Move Select2 remove (X) button to LEFT side */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding: 2px 8px 2px 25px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        right: auto !important;
        left: 6px !important;
    }
    .select2-container--default .select2-selection--multiple {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center;
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline {
        position: relative !important;
        width: auto !important;
        margin-top: 0 !important;
        flex: 1;
    }

    .select2-container--default .select2-selection--multiple .select2-search__field {
        width: 100% !important;
        min-width: 120px;
    }
    .select2-search--inline {
        width: 100% !important;
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
                            <h5>{{ $project->name }} Training</h5>
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
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTrainingModal">
                                Add Training
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['No','Project','Province','District','Village','Training Venue','Training Type','Training Topic','Training Start Date','Training End Date','Facilitator Name','Facilitator Position','Number of Participants (Male)','Number of Participants (Female)','Number of Participant from Gov Authorities', 'Avg Pre Test (%)','Avg Post Test (%)','Objective','Remarks','Status','Action'];

                        $rows = [];

                        foreach($train as $key => $item){
                            $rows[] = [
                                $key + 1,
                                $item->project?->name ?? '',
                                $item->province?->name,
                                $item->districts->pluck('name')->implode(', '),
                                $item->village,
                                $item->training_venue,
                                $item->trainingType?->name,
                                $item->training_topic,
                                $item->training_start_date,
                                $item->training_end_date,
                                $item->facilitator_name,
                                $item->facilitator_position,
                                $item->male_participants,
                                $item->female_participants,
                                $item->gov_participants,
                                $item->avg_pre_test,
                                $item->avg_post_test,
                                $item->objective,
                                $item->remarks,
                                '<span class="badge" style="background-color: '.$item->status?->color.';">
                                    '.$item->status?->name.'
                                </span>',
                                
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
                                            data-bs-target="#editTrainingModal'.$item->id.'">
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="' . route('delete.training', $item->id) . '" 
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
<div class="modal fade" id="addTrainingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('store.training',$project->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Training</h5>
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
                            <label>Training Start Date</label>
                            <input type="date" name="training_start_date" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Training End Date</label>
                            <input type="date" name="training_end_date" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Province</label>
                            <select name="province_id" id="province_id" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                       <div class="col-md-4 mb-2">
                            <label>District</label>
                            <select name="district_ids[]" class="form-control select2" multiple style="width:100%;">
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Village</label>
                            <input type="text" name="village" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Training Venue</label>
                            <input type="text" name="training_venue" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="training_type">Training Type</label>
                            <select class="form-control" name="training_type_id">
                                <option value="">-- Select --</option>

                                @foreach($trainingTypes as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Training Topic</label>
                            <input type="text" name="training_topic" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Facilitator Name</label>
                            <input type="text" name="facilitator_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Facilitator Position</label>
                            <input type="text" name="facilitator_position" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Male Participants</label>
                            <input type="number" name="male_participants" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Female Participants</label>
                            <input type="number" name="female_participants" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Gov Participants</label>
                            <input type="number" name="gov_participants" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status_id" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Avg Pre Test</label>
                            <input type="text" name="avg_pre_test" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2 status-extra">
                            <label>Avg Post Test</label>
                            <input type="text" name="avg_post_test" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Objective</label>
                            <textarea name="objective" class="form-control" rows="1" cols="1"></textarea>
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

@foreach($train as $item)
    <div class="modal fade" id="editTrainingModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl">

            <form action="{{ route('update.training', $item->id) }}" method="POST">
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
                                <label>Training Start Date</label>
                                <input type="date" name="training_start_date" class="form-control"
                                    value="{{ $item->training_start_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Training End Date</label>
                                <input type="date" name="training_end_date" class="form-control"
                                    value="{{ $item->training_end_date }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Province</label>
                                <select name="province_id" class="form-control edit-province">
                                    <option value="">-- Select --</option>

                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ $item->province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $selectedDistricts = $item->districts->pluck('id')->toArray();
                            @endphp

                            <div class="col-md-4 mb-2">
                                <label>District</label>
                                <select name="district_ids[]" 
                                    class="form-control select2" 
                                    multiple 
                                    style="width:100%;">
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ in_array($district->id, $selectedDistricts) ? 'selected' : '' }}>
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
                                <label>Training Venue</label>
                                <input type="text" name="training_venue" class="form-control"
                                    value="{{ $item->training_venue }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Training Type</label>

                                <select class="form-control" name="training_type_id">
                                    <option value="">-- Select --</option>

                                    @foreach($trainingTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $item->training_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Training Topic</label>
                                <input type="text" name="training_topic" class="form-control"
                                    value="{{ $item->training_topic }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Facilitator Name</label>
                                <input type="text" name="facilitator_name" class="form-control"
                                    value="{{ $item->facilitator_name }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Facilitator Position</label>
                                <input type="text" name="facilitator_position" class="form-control"
                                    value="{{ $item->facilitator_position }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Male Participants</label>
                                <input type="number" name="male_participants" class="form-control"
                                    value="{{ $item->male_participants }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Female Participants</label>
                                <input type="number" name="female_participants" class="form-control"
                                    value="{{ $item->female_participants }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Gov Participants</label>
                                <input type="number" name="gov_participants" class="form-control"
                                    value="{{ $item->gov_participants }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status</label>

                                <select name="status_id" class="form-control">
                                    <option value="">-- Select --</option>

                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ $item->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Avg Pre Test</label>
                                <input type="text" name="avg_pre_test" class="form-control"
                                    value="{{ $item->avg_pre_test }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Avg Post Test</label>
                                <input type="text" name="avg_post_test" class="form-control"
                                    value="{{ $item->avg_post_test }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Objective</label>
                                <textarea name="objective" class="form-control"
                                    rows="1" cols="1">{{ $item->objective }}</textarea>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control"
                                    rows="1" cols="1">{{ $item->remarks }}</textarea>
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
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('.select2').select2({
            width: '100%',
            dropdownParent: $(this)
        });
    });

    $('#province_id').on('change', function () {

        let province_id = $(this).val();

        if (!province_id) {
            $('.select2').html('<option disabled>Select a province first</option>');
            return;
        }

        $.ajax({
            url: '/get-training-districts/' + province_id,
            type: 'GET',
            success: function (data) {

                let options = '';

                data.forEach(function (item) {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });

                $('#addTrainingModal select[name="district_ids[]"]').html(options).trigger('change');
            }
        });
    });

    $(document).on('change', '.edit-province', function () {

        let province_id = $(this).val();

        let modal = $(this).closest('.modal');

        if (!province_id) {
            modal.find('select[name="district_ids[]"]').html('<option disabled>Select a province first</option>');
            return;
        }

        $.ajax({
            url: '/get-training-districts/' + province_id,
            type: 'GET',
            success: function (data) {

                let options = '';

                data.forEach(function (item) {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });

                modal.find('select[name="district_ids[]"]').html(options).trigger('change');
            }
        });
    });
</script>

@endsection