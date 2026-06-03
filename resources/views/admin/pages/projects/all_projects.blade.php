@extends('admin.admin_master')
@section('admin')

<style>
.dataTables_scrollBody {
    overflow: visible !important;
}
.dropdown-menu {
    z-index: 99999;
}
</style>

<div class="content">

    <div class="container-xxl">

        <div class="row">
            <div class="col-12">
                <div class="card mt-2">

                    <div class="card-header">
                        <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                <h5>Projects</h5>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('add.project') }}" class="btn btn-secondary btn-md">
                                    Add Project
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            @php
                                $headers = [
                                    'No',
                                    'Name',
                                    'Date',
                                    'Province',
                                    'Thematic Area',
                                    'Donnor',
                                    'Status',
                                    'Actions'
                                ];

                                $rows = [];

                                foreach ($project as $key => $item) {
                                    $rows[] = [
                                        $key + 1,
                                        '<a href="'.route('edit.project', $item->id).'">'.$item->name.'</a>',
                                        \Carbon\Carbon::parse($item->start_date)->format('d M Y').' ⇒ '.\Carbon\Carbon::parse($item->end_date)->format('d M Y'),
                                        \App\Models\Province::whereIn('id', json_decode($item->province ?? '[]'))->pluck('name')->implode(', '),
                                        $item->thematic_area,
                                        $item->donor,
                                        $item->status ? '<span style="background-color: '.$item->status->color.'; color:#fff; padding:5px 10px; border-radius:6px;">'.$item->status->name.'</span>' : '',
                                        '<div class="dropdown dropstart dropend dropup">
                                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside"
                                            data-bs-display="dynamic"
                                            aria-expanded="false"
                                            style="z-index: 999;">
                                                <i class="bi bi-list"></i>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="'.route('show.project', $item->id).'">Show</a></li>
                                                <li><a class="dropdown-item" href="'.route('edit.project', $item->id).'">Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="'.route('delete.project', $item->id).'">Delete</a></li>
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

    </div>

</div>

<script>
$(document).on('show.bs.dropdown', '.dropdown', function () {
    const $menu = $(this).find('.dropdown-menu');

    // فقط اگر داخل DataTable هست
    if (!$(this).closest('.dataTables_wrapper').length) return;

    $('body').append($menu.detach().css({
        position: 'absolute',
        zIndex: 99999
    }));
});

$(document).on('hide.bs.dropdown', '.dropdown', function () {
    const $toggle = $(this).find('[data-bs-toggle="dropdown"]');

    if (!$toggle.length) return;

    $toggle.after($('.dropdown-menu').detach());
});
</script>

@endsection