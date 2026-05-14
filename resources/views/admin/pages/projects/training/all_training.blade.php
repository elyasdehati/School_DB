@extends('admin.admin_master')
@section('admin')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
                            <form action="{{ route('import.projects.classes', $project->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                <input type="file" name="excel_file" class="form-control form-control-sm d-inline" style="width:220px;">
                                <button type="submit" class="btn btn-success btn-sm">
                                    Upload Excel
                                </button>
                            </form>

                            <a href="{{ route('export.projects.classes', [$project->id, 'template']) }}" 
                            class="btn btn-info btn-sm">
                                Download Template
                            </a>

                            <a href="{{ route('export.projects.classes', [$project->id, 'data']) }}" 
                            class="btn btn-primary btn-sm">
                                Export Data
                            </a>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                                Add Training
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    @php
                        $headers = ['No','Project','Province','District','Village','Training Venue','Training Type','Training Topic','Training Start Date','Training End Date','Facilitator Name','Facilitator Position','Number of Participants (Male)','Number of Participants (Female)','Number of Participant from Gov Authorities','Status','Avg Pre Test (%)','Avg Post Test (%)','Objective','Remarks','Action'];

                        $rows = [];

                        // foreach($class as $key => $item){
                        //     $rows[] = [
                        //         // $key + 1,
                        //         $item->class_id,
                        //         $item->class_name,
                        //         implode(', ', json_decode($item->grades ?? '[]', true) ?? []),
                        //         $item->class_type,
                        //         $item->province?->name ?? '',
                        //         $item->district?->name ?? '',
                        //         $item->village,
                        //         $item->latitude,
                        //         $item->longitude,
                        //         $item->climate,
                        //         $item->infrastructure,
                        //         $item->boys_enrolled,
                        //         $item->girls_enrolled,
                        //         $item->total_enrolled,
                        //         $item->demographic,
                        //         $item->language,
                        //         // $item->class_status,
                        //         $item->establishment_date,
                        //         $item->start_time,
                        //         $item->end_time,
                        //         $item->shift,
                        //         $item->is_cluster ? 'Yes' : 'No',
                        //         $item->female_teachers,
                        //         $item->male_teachers,
                        //         $item->cbe_teachers,
                        //         $item->is_closed ? 'Yes' : 'No',
                        //         $item->closure_date,
                        //         $item->closure_reason,
                        //         $item->female_sms_members,
                        //         $item->male_sms_members,
                        //         $item->sms_members,
                        //         $item->has_hub_school ? 'Yes' : 'No',
                        //         $item->hub_school_name,
                        //         $item->hub_distance_km,
                        //         $item->sip_completed ? 'Yes' : 'No',
                        //         $item->remarks,
                        //         '<span class="badge" style="background-color: '.$item->status?->color.';">
                        //             '.$item->status?->name.'
                        //         </span>',
                        //         '<div class="dropdown dropstart dropend dropup">
                        //             <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button"
                        //             id="dropdownMenuLink'.$item->id.'"
                        //             data-bs-toggle="dropdown" 
                        //             data-bs-auto-close="outside" 
                        //             data-bs-display="dynamic"
                        //             aria-expanded="false">
                        //                 <i class="bi bi-list"></i>
                        //             </a>

                        //             <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$item->id.'">
                        //                 <li>
                        //                     <a class="dropdown-item" href="#" 
                        //                     data-bs-toggle="modal" 
                        //                     data-bs-target="#editClassModal'.$item->id.'">
                        //                         Edit
                        //                     </a>
                        //                 </li>
                        //                 <li>
                        //                     <a href="' . route('delete.projects.class', $item->id) . '" 
                        //                         class="dropdown-item text-danger delete-confirm">
                        //                             Delete
                        //                     </a>
                        //                 </li>
                        //             </ul>
                        //         </div>'
                        //     ];
                        // }
                    @endphp

                    <x-table :headers="$headers" :rows="$rows" />

                </div>
            </div>
        </div>
    </div>
</div>

@endsection