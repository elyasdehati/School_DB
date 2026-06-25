@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="container-xxl">
        <div class="card mt-1">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Residence </h5>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('update.residence',$res->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 mb-3">
                            <label for="title">Title</label>
                            <input class="form-control" name="name" type="text" value="{{ $res->name }}">
                            
                        </div>
                        
                        <div class="col-md-12 d-flex justify-content-end align-items-center mt-3">
                            <button type="submit" class="btn btn-primary ms-3">
                                Update 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection