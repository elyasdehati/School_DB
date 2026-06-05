@extends('admin.admin_master')
@section('admin')

<style>
    .card.equal-card{
        height: 100px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-1"></i> Widgets
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.beneficiary') ? 'active' : '' }}" 
                href="{{ route('all.beneficiary') }}">
                    <i class="bi bi-people-fill me-1"></i> Beneficiary
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
            </div>
        </div>

        <div class="row g-2">

            <!-- Classes -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#4e73df,#224abe);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Classes</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $classes }}</h3>
                        </div>
                        <i data-feather="home" style="width:40px;height:40px;"></i>
                    </div>
                </div>
            </div>

            <!-- Teachers -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#1cc88a,#13855c);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Teachers</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $totalTeachers }}</h3>
                        </div>
                        <i class="fa-solid fa-chalkboard-user" style="font-size:35px;"></i>
                    </div>
                </div>
            </div>

            <!-- Students -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#36b9cc,#1a7a8c);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Students</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $totalStudents }}</h3>
                        </div>
                        <i data-feather="user" style="width:40px;height:40px;"></i>
                    </div>
                </div>
            </div>

            <!-- Shura -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#f6c23e,#dda20a);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Shura</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $shura }}</h3>
                        </div>
                        <i data-feather="home" style="width:40px;height:40px;"></i>
                    </div>
                </div>
            </div>

            <!-- Shura Members -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#e74a3b,#be2617);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Shura Members</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $totalShuraMembers }}</h3>
                        </div>
                        <i class="fa-solid fa-users" style="font-size:35px;"></i>
                    </div>
                </div>
            </div>

            <!-- Trainings -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#6f42c1,#4e2a84);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Trainings</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $trainings }}</h3>
                        </div>
                        <i class="fa-solid fa-graduation-cap" style="font-size:35px;"></i>
                    </div>
                </div>
            </div>

            <!-- Training Participants -->
            <div class="col-md-6 col-xl-3">
                <div class="card text-white border-0 shadow-sm rounded-4 equal-card"
                    style="background: linear-gradient(135deg,#1e3a8a,#0f172a);">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-18 fw-bold">Participants</div>
                            <h3 class="fw-bold mb-0" style="opacity: .9">{{ $totalParticipants }}</h3>
                        </div>
                        <i data-feather="user" style="width:40px;height:40px;"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Start Monthly Sales -->
        <div class="row">
            <div class="col-md-6 col-xl-8">
                <div class="card">
                    
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="bar-chart" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Project Bar Chart</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="project-chart" class="apex-charts"></div>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card overflow-hidden">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="tablet" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Project Progress Timeline</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0">
                                <tbody>

                                    @foreach($projectsProgress as $project)

                                    @php
                                        if($project->progress <= 25){
                                            $color = 'bg-danger';
                                        }elseif($project->progress <= 50){
                                            $color = 'bg-warning';
                                        }elseif($project->progress <= 75){
                                            $color = 'bg-info';
                                        }else{
                                            $color = 'bg-success';
                                        }
                                    @endphp

                                    <tr>
                                        <td style="min-width: 330px;">

                                            {{-- Project Name --}}
                                            <div class="fw-bold mb-2">
                                                {{ $project->name }}
                                            </div>

                                            {{-- Dates --}}
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}
                                                </small>

                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                                                </small>
                                            </div>

                                            {{-- Progress --}}
                                            <div class="d-flex align-items-center gap-2">
                                                
                                                <small class="fw-bold text-primary" style="min-width: 45px;">
                                                    {{ $project->progress }}%
                                                </small>

                                                <div class="progress mb-3 flex-grow-1"
                                                    style="height: 12px; border-radius: 10px; background: #e9ecef;">

                                                    <div class="progress-bar {{ $color }}"
                                                        role="progressbar"
                                                        style="
                                                            width: {{ $project->progress }}%;
                                                            border-radius: 0 10px 10px 0;
                                                        ">
                                                    </div>

                                                </div>

                                            </div>

                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Monthly Sales -->

        {{-- <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="minus-square" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Audiences By Time Of Day</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="audiences-daily" class="apex-charts mt-n3"></div>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="card overflow-hidden">
                    
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="table" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Most Visited Pages</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0">
                                <tbody>

                                    <thead>
                                        <tr>
                                            <th>Page name</th>
                                            <th>Visitors</th>
                                            <th>Unique</th>
                                            <th colspan="2">Bounce rate</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            /home
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>5,896</td>
                                        <td>3,654</td>
                                        <td>82.54%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-1" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /about.html
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>3,898</td>
                                        <td>3,450</td>
                                        <td>76.29%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-2" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /index.html 
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>3,057</td>
                                        <td>2,589</td>
                                        <td>72.68%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-3" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /invoice.html
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>867</td>
                                        <td>795</td>
                                        <td>44.78%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-4" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /docs/
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>958</td>
                                        <td>801</td>
                                        <td>41.15%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-5" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /service.html
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>658</td>
                                        <td>589</td>
                                        <td>32.65%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-6" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            /analytical.html
                                            <a href="#" class="ms-1" aria-label="Open website">
                                                <i data-feather="link" class="ms-1 text-primary" style="height: 15px; width: 15px;"></i>
                                            </a>
                                        </td>
                                        <td>457</td>
                                        <td>859</td>
                                        <td>32.65%</td>
                                        <td class="w-25">
                                            <div id="sparkline-bounce-7" class="apex-charts"></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> --}}

    </div> <!-- container-fluid -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        var options = {
            series: [{
                name: 'Total',
                data: @json($chartData)
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            colors: ['#0035c5'],
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    borderRadiusApplication: 'end'
                }
            },
            xaxis: {
                categories: @json($chartLabels)
            }
        };

        var chart = new ApexCharts(
            document.querySelector("#project-chart"),
            options
        );

        chart.render();

    });
</script>

@endsection