@extends('admin.admin_master')
@section('admin')

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

<div class="row mt-3 mb-3">
    <div class="col-md-4">
        <label class="form-label fw-bold">Project</label>
        <select class="form-select" id="projectFilter">
            <option value="">All Projects</option>

            @foreach($projects as $project)
                <option value="{{ $project->id }}">
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="container-fluid">

    <div class="row">

        <!-- CLASS TYPE -->
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Class Type</h5>
                </div>
                <div class="card-body">
                    <div id="class-type" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <!-- TEACHERS -->
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Teachers</h5>
                </div>
                <div class="card-body">
                    <div id="teachers" class="apex-charts"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <!-- STUDENTS -->
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Students</h5>
                </div>
                <div class="card-body">
                    <div id="students" class="apex-charts"></div>
                </div>
            </div>
        </div>

        <!-- SMS MEMBERS -->
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>SMS Members</h5>
                </div>
                <div class="card-body">
                    <div id="sms-members" class="apex-charts"></div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
    <script>

        let classTypeChart;
        let teachersChart;
        let studentsChart;
        let smsMembersChart;

        document.addEventListener("DOMContentLoaded", function () {

            // CLASS TYPE
            classTypeChart = new ApexCharts(document.querySelector("#class-type"), {
                series: [{
                    name: 'Classes',
                    data: []
                }],
                chart: {
                    type: 'bar',
                    height: 250
                },
                colors: [
                    '#008FFB',
                    '#00E396',
                    '#FEB019',
                    '#FF4560',
                    '#775DD0',
                    '#3F51B5',
                    '#546E7A',
                    '#D4526E',
                    '#8D5B4C',
                    '#F86624'
                ],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        distributed: true
                    }
                },
                xaxis: {
                    categories: []
                }
            });

            classTypeChart.render();

            // TEACHERS
            teachersChart = new ApexCharts(document.querySelector("#teachers"), {
                series: [
                    {
                        name: 'Male',
                        data: []
                    },
                    {
                        name: 'Female',
                        data: []
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 250
                },
                colors: ['#1CABE2', '#F7941D'],
                plotOptions: {
                    bar: {
                        borderRadius: 8
                    }
                },
                xaxis: {
                    categories: []
                }
            });

            teachersChart.render();

            // STUDENTS
            studentsChart = new ApexCharts(document.querySelector("#students"), {
                series: [
                    {
                        name: 'Boys',
                        data: []
                    },
                    {
                        name: 'Girls',
                        data: []
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 250
                },
                colors: ['#1CABE2', '#F7941D'],
                plotOptions: {
                    bar: {
                        borderRadius: 8
                    }
                },
                xaxis: {
                    categories: []
                }
            });

            studentsChart.render();

            // SMS MEMBERS
            smsMembersChart = new ApexCharts(document.querySelector("#sms-members"), {
                series: [
                    {
                        name: 'Male',
                        data: []
                    },
                    {
                        name: 'Female',
                        data: []
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 250
                },
                colors: ['#1CABE2', '#F7941D'],
                plotOptions: {
                    bar: {
                        borderRadius: 8
                    }
                },
                xaxis: {
                    categories: ['SMS Members']
                }
            });

            smsMembersChart.render();

        });

        $('#projectFilter').on('change', function () {

            let project_id = $(this).val();

            $.ajax({
                url: "{{ route('beneficiary.project.data') }}",
                type: "GET",
                data: {
                    project_id: project_id
                },

                success: function(response){

                    // STUDENTS
                    studentsChart.updateSeries([
                        {
                            name: 'Boys',
                            data: response.students_by_class_type.map(i => Number(i.boys))
                        },
                        {
                            name: 'Girls',
                            data: response.students_by_class_type.map(i => Number(i.girls))
                        }
                    ]);

                    studentsChart.updateOptions({
                        xaxis: {
                            categories: response.students_by_class_type.map(i => i.class_type ?? 'N/A')
                        }
                    });

                    // TEACHERS
                    teachersChart.updateSeries([
                        {
                            name: 'Male',
                            data: response.teachers_by_class_type.map(i => Number(i.male))
                        },
                        {
                            name: 'Female',
                            data: response.teachers_by_class_type.map(i => Number(i.female))
                        }
                    ]);

                    teachersChart.updateOptions({
                        xaxis: {
                            categories: response.teachers_by_class_type.map(i => i.class_type ?? 'N/A')
                        }
                    });

                    // SMS MEMBERS
                    smsMembersChart.updateSeries([
                        {
                            name: 'Male',
                            data: [response.sms_members.male]
                        },
                        {
                            name: 'Female',
                            data: [response.sms_members.female]
                        }
                    ]);

                    // CLASS TYPE
                    classTypeChart.updateSeries([{
                        data: response.class_types.map(i => i.total)
                    }]);

                    classTypeChart.updateOptions({
                        xaxis: {
                            categories: response.class_types.map(i => i.class_type ?? 'N/A')
                        }
                    });

                },

                error: function(error){
                    console.log(error);
                }
            });

        });

        $(document).ready(function () {
            $('#projectFilter').trigger('change');
        });

    </script>
@endpush