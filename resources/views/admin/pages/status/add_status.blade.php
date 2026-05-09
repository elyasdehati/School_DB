@extends('admin.admin_master')
@section('admin')

<div class="content">
    <div class="container-xxl">
        <div class="card mt-1">
            <div class="card-header">
                <h5 class="mb-0">Create Status</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('store.status') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 mb-3">
                            <label for="name">Title</label>
                            <input class="form-control" placeholder="Enter a Status" required="" name="name" type="text" id="name">
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label for="color">Color</label>
                            <input type="color" class="form-control form-control-color" name="color" id="color" required>
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

@endsection