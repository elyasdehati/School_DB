@extends('admin.admin_master')
@section('admin')

<div class="content">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="mb-0">Beneficiary Summary Report</h4>
                    <small class="text-muted">UNICEF Project Monitoring Dashboard</small>
                </div>

                <a href=""
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered text-center align-middle">

                    {{-- HEADER --}}
                    <thead class="table-light">

                        <tr class="fw-bold">
                            <th rowspan="3">Project</th>
                            <th colspan="6">Beneficiaries</th>
                        </tr>

                        <tr>
                            <th colspan="2">Students</th>
                            <th colspan="2">Teachers</th>
                            <th rowspan="2">Shuras</th>
                            <th rowspan="2">Shura Members</th>
                        </tr>

                        <tr>
                            <th>Boys</th>
                            <th>Girls</th>
                            <th>Male</th>
                            <th>Female</th>
                        </tr>

                    </thead>

                    {{-- BODY --}}
                    <tbody>

                        @php
                            $total_boys = 0;
                            $total_girls = 0;
                            $total_male_teachers = 0;
                            $total_female_teachers = 0;
                            $total_shuras = 0;
                            $total_shura_members = 0;
                        @endphp

                        @foreach($projects as $project)

                            @php
                                $total_boys += $project->boys_students ?? 0;
                                $total_girls += $project->girls_students ?? 0;
                                $total_male_teachers += $project->male_teachers ?? 0;
                                $total_female_teachers += $project->female_teachers ?? 0;
                                $total_shuras += $project->shuras_count ?? 0;
                                $total_shura_members += $project->shura_members_count ?? 0;
                            @endphp

                            <tr>
                                <td class="text-start">{{ $project->name }}</td>

                                <td>{{ $project->boys_students ?? 0 }}</td>
                                <td>{{ $project->girls_students ?? 0 }}</td>

                                <td>{{ $project->male_teachers ?? 0 }}</td>
                                <td>{{ $project->female_teachers ?? 0 }}</td>

                                <td>{{ $project->shuras_count ?? 0 }}</td>
                                <td>{{ $project->shura_members_count ?? 0 }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                    {{-- TOTAL ROW (VERY IMPORTANT FOR UNICEF STYLE) --}}
                    <tfoot class="table-secondary fw-bold">

                        <tr>
                            <td>Total</td>

                            <td>{{ $total_boys }}</td>
                            <td>{{ $total_girls }}</td>

                            <td>{{ $total_male_teachers }}</td>
                            <td>{{ $total_female_teachers }}</td>

                            <td>{{ $total_shuras }}</td>
                            <td>{{ $total_shura_members }}</td>
                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection