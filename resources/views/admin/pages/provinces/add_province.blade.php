@extends('admin.admin_master')
@section('admin')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="content">
    <div class="container-xxl">
        <div class="card mt-1">
            <div class="card-header">
                <h5 class="mb-0">Create Province</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('store.province') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 mb-3">
                            <label for="title">Title</label>
                            <input class="form-control" placeholder="Title" required="" name="province" type="text" id="title">
                            
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="districts">Districts</label>
                            <input type="text" class="form-control" id="district_input" placeholder="Type district and press Enter">
                            <div id="district_tags"></div>
                            <input type="hidden" name="districts[]" id="districts">
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

<style>
.tag {
    display:inline-block;
    background:#28a745;
    color:#fff;
    padding:5px 10px;
    margin:3px;
    border-radius:3px;
}
.tag span {
    margin-left:8px;
    cursor:pointer;
}
</style>

<script>
let districts = [];

document.getElementById('district_input').addEventListener('keypress', function(e){
    if(e.key === 'Enter'){
        e.preventDefault();
        let value = this.value.trim();

        if(value !== ''){
            districts.push(value);
            renderTags();
            this.value = '';
        }
    }
});

function renderTags(){
    let container = document.getElementById('district_tags');
    container.innerHTML = '';

    districts.forEach((d, index) => {
        let tag = document.createElement('div');
        tag.classList.add('tag');
        tag.innerHTML = d + ' <span onclick="removeTag('+index+')">x</span>';
        container.appendChild(tag);
    });

    document.getElementById('districts').value = JSON.stringify(districts);
}

function removeTag(index){
    districts.splice(index, 1);
    renderTags();
}
</script>

@endsection