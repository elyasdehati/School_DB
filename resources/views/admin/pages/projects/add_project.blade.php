@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Create Project</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('store.project') }}" class="validate" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-4 mb-3">
                                <label for="name">Name</label>
                                <input class="form-control" placeholder="Name" required="" name="name" type="text" id="name">
                                
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <label for="start_date">Start Date</label>
                                <input class="form-control start_date datepicker-input" placeholder="Start Date" required="" name="start_date" type="date" id="start_date">
                                
                            </div>
                            <div class="form-group col-lg-4 mb-3">
                                <label for="end_date">End Date</label>
                                <input class="form-control end_date datepicker-input" placeholder="End Date" required="" name="end_date" type="date" id="end_date">
                                
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

@endsection