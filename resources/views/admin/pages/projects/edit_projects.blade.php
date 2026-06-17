@extends('admin.admin_master')
@section('admin')

<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid rgba(0,0,0,0.2); 
    border-radius: 5px;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #f5f5f5; 
    color: #333;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e0e0e0;
    color: #333;
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

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('beneficiary.project.summary') ? 'active' : '' }}" 
                href="{{ route('beneficiary.project.summary', $project->id) }}">
                    <i class="bi bi-people-fill me-1"></i> Beneficiary Summary
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
                    <h5 class="mb-0">Edit Project</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('update.project', $project->id) }}" class="validate" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-4 mb-3">
                                <label for="project_contract_no">Project Contract Number</label>
                                <input class="form-control" placeholder="Project Contract Number" required="" name="project_contract_no" type="text" value="{{ $project->project_contract_no }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="name">Name</label>
                                <input class="form-control" placeholder="Name" required="" name="name" type="text" value="{{ $project->name }}" id="name">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="start_date">Start Date</label>
                                <input class="form-control start_date datepicker-input" placeholder="Start Date" required="" name="start_date" type="date" value="{{ $project->start_date }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="end_date">End Date</label>
                                <input class="form-control end_date datepicker-input" placeholder="End Date" required="" name="end_date" type="date" value="{{ $project->end_date }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="donnor">Donnor</label>
                                <input class="form-control" placeholder="Donnor" name="donnor" type="text" value="{{ $project->donor }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="partner">Partner</label>
                                <input class="form-control" placeholder="Partner" name="partner" type="text" value="{{ $project->partner }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="thematic_area">Thematic Area</label>

                                <select name="thematic_area" class="form-control">
                                    <option value="">-- Select --</option>

                                    @foreach($thematicAreas as $area)
                                        <option value="{{ $area->name }}"
                                            {{ $project->thematic_area == $area->name ? 'selected' : '' }}>
                                            {{ $area->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="status_id">Status</label>
                                <select name="status_id" class="form-control">
                                    <option value="">-- Select --</option>

                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ isset($project) && $project->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $selectedProvinces = json_decode($project->province ?? '[]', true) ?? [];
                            @endphp
                            <div class="form-group col-lg-12 mb-3">
                                <label for="categories">Province</label>

                                <select class="form-control select2" name="categories[]" id="categories" multiple>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ in_array($province->id, $selectedProvinces) ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $selectedDistricts = json_decode($project->district ?? '[]', true) ?? [];
                            @endphp
                            <div class="form-group col-lg-12 mb-3">
                                <label for="districts">District</label>

                                <select class="form-control select2" name="districts[]" id="districts" multiple>
                                    @foreach($provinces as $province)
                                        @foreach($province->districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ in_array($district->id, $selectedDistricts) ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-12 mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"cols="1" rows="3">{{ $project->description }}</textarea>
                            </div>
                                                    
                            <div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
                                <button type="submit" class="btn btn-primary ms-3">
                                    Save 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: "",
                allowClear: true
            });

            $('#districts').select2({
                placeholder: "",
                allowClear: true
            });

            // added
            $('#categories').on('change', function() {
                let province_ids = $(this).val();

                if(province_ids && province_ids.length > 0){
                    $.ajax({
                        url: '/get-project-districts',
                        type: 'POST',
                        data: {
                            province_ids: province_ids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data){
                            $('#districts').empty();

                            $.each(data, function(key, value){
                                $('#districts').append(
                                    `<option value="${value.id}">${value.name}</option>`
                                );
                            });

                            $('#districts').trigger('change');

                            let selectedDistricts = @json($selectedDistricts ?? []);
                            $('#districts').val(selectedDistricts).trigger('change');
                        }
                    });
                }
            });

            // added (load on edit)
            $('#categories').trigger('change');
            // end added
        });
    </script>
@endpush

@endsection