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
                                <label for="partner">Thematic Area</label>
                                <input class="form-control" placeholder="Thematic Area" name="thematic_area" type="text" value="{{ $project->thematic_area }}">
                            </div>

                            <div class="form-group col-lg-4 mb-3">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option>
                                        -- Select --
                                    </option>
                                    <option value="Completed" {{ $project->status=='Completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="Ongoing" {{ $project->status=='Ongoing' ? 'selected' : '' }}>
                                        Ongoing
                                    </option>
                                    <option value="Pipeline" {{ $project->status=='Pipeline' ? 'selected' : '' }}>
                                        Pipeline
                                    </option>
                                    <option value="Change" {{ $project->status=='Change' ? 'selected' : '' }}>
                                        Change
                                    </option>
                                    <option value="Suspend" {{ $project->status=='Suspend' ? 'selected' : '' }}>
                                        Suspend
                                    </option>
                                    <option value="Cancel" {{ $project->status=='Cancel' ? 'selected' : '' }}>
                                        Cancel
                                    </option>
                                </select>
                            </div>

                            @php
                                $selectedProvinces = json_decode($project->province ?? '[]');
                            @endphp
                            <div class="form-group col-lg-12 mb-3">
                                <label for="categories">Province</label>
                                <select class="form-control select2" name="categories[]" id="categories" multiple="multiple" style="width: 100%;">
                                    <option value="balkh" {{ in_array('balkh', $selectedProvinces) ? 'selected' : '' }}>Balkh</option>
                                    <option value="badakhshan" {{ in_array('badakhshan', $selectedProvinces) ? 'selected' : '' }}>Badakhshan</option>
                                    <option value="bamyan" {{ in_array('bamyan', $selectedProvinces) ? 'selected' : '' }}>Bamyan</option>
                                    <option value="ghazni" {{ in_array('ghazni', $selectedProvinces) ? 'selected' : '' }}>Ghazni</option>
                                    <option value="daikundi" {{ in_array('daikundi', $selectedProvinces) ? 'selected' : '' }}>Daikundi</option>
                                    <option value="parwan" {{ in_array('parwan', $selectedProvinces) ? 'selected' : '' }}>Parwan</option>
                                </select>
                            </div>

                            @php
                                $selectedDistricts = json_decode($project->district ?? '[]');
                            @endphp
                            <div class="form-group col-lg-12 mb-3">
                                <label for="districts">District</label>
                                <select class="form-control select2" name="districts[]" id="districts" multiple="multiple" style="width: 100%;">
                                    <option value="balkh" {{ in_array('balkh', $selectedDistricts) ? 'selected' : '' }}>Balkh</option>
                                    <option value="bamyan_center" {{ in_array('bamyan_center', $selectedDistricts) ? 'selected' : '' }}>Bamyan Center</option>
                                    <option value="kahmard" {{ in_array('kahmard', $selectedDistricts) ? 'selected' : '' }}>Kahmard</option>
                                    <option value="panjab" {{ in_array('panjab', $selectedDistricts) ? 'selected' : '' }}>Panjab</option>
                                    <option value="sayghan" {{ in_array('sayghan', $selectedDistricts) ? 'selected' : '' }}>Sayghan</option>
                                    <option value="shibar" {{ in_array('shibar', $selectedDistricts) ? 'selected' : '' }}>Shibar</option>
                                    <option value="waras" {{ in_array('waras', $selectedDistricts) ? 'selected' : '' }}>Waras</option>
                                    <option value="shahristan" {{ in_array('shahristan', $selectedDistricts) ? 'selected' : '' }}>Shahristan</option>
                                    <option value="shaikh_ali" {{ in_array('shaikh_ali', $selectedDistricts) ? 'selected' : '' }}>Shaikh Ali</option>
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
            // width: 'resolve'
            // dir: 'rtl'
        });
    });
</script>
@endpush

@endsection