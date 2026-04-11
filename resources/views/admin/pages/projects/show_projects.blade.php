@extends('admin.admin_master')
@section('admin')

<div class="col-md-12 mt-1">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Show Project</h5>

            <a href="{{ route('all.projects') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <strong>Code:</strong>
                {{ $project->project_contract_no }}
            </div>
            <div class="form-group mb-3">
                <strong>Name:</strong>
                {{ $project->name }}
            </div>
            <div class="form-group mb-3">
                <strong>Start Date:</strong>
                {{ $project->start_date }}
            </div>
            <div class="form-group mb-3">
                <strong>End Date:</strong>
                {{ $project->end_date }}
            </div>
            <div class="form-group mb-3">
                <strong>Donnor:</strong>
                {{ $project->donor }}
            </div>
            <div class="form-group mb-3">
                <strong>Partner:</strong>
                {{ $project->partner }}
            </div>
            <div class="form-group mb-3">
                <strong>Description:</strong>
                {{ $project->description }}
            </div>
            <div class="form-group mb-3">
                <strong>Status:</strong>
                {{ $project->status }}
            </div>
        </div>
    </div>
</div>

@endsection