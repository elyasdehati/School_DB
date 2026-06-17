@extends('admin.admin_master')
@section('admin')

<style>
.table tfoot td{
    padding: 4px 8px !important;
    vertical-align: middle !important;
    line-height: 1.2;
}

.table tfoot tr{
    height: 30px;
}
</style>

<div class="content">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mt-3">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">{{ $project->name }} Beneficiary Summary Report</h4>
                <small class="text-muted">{{ $project->name }}</small>
            </div>

            <a href="#" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light text-center">
                        <tr class="fw-bold">
                            <th rowspan="3" class="align-middle">Province</th>
                            <th rowspan="3" class="align-middle">District</th>
                            <th rowspan="3" class="align-middle">Total Classes</th>
                            <th colspan="4">Students</th>
                            <th colspan="2">Teachers</th>
                            <th rowspan="3" class="align-middle">SMS</th>
                            <th colspan="2">SMS Members</th>
                        </tr>
                        <tr>
                            <th colspan="2">Normal</th>
                            <th colspan="2">Disable</th>
                            <th rowspan="2" class="align-middle">Male</th>
                            <th rowspan="2" class="align-middle">Female</th>
                            <th rowspan="2" class="align-middle">Male</th>
                            <th rowspan="2" class="align-middle">Female</th>
                        </tr>
                        <tr>
                            <th>Boys</th>
                            <th>Girls</th>
                            <th>Boys</th>
                            <th>Girls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t_classes = 0;
                            $t_b_no = 0;
                            $t_g_no = 0;
                            $t_b_dis = 0;
                            $t_g_dis = 0;
                            $t_male_t = 0;
                            $t_female_t = 0;
                            $t_sms = 0;
                            $t_sms_m = 0;
                            $t_sms_f = 0;
                            $groupedData = collect($reportData)->groupBy('province');
                        @endphp
                        @foreach($groupedData as $province => $districts)

                            @foreach($districts as $index => $row)

                                @php
                                    $t_classes += $row['total_classes'];
                                    $t_b_no += $row['boys_no_disability'];
                                    $t_g_no += $row['girls_no_disability'];
                                    $t_b_dis += $row['boys_disability'];
                                    $t_g_dis += $row['girls_disability'];
                                    $t_male_t += $row['male_teachers'];
                                    $t_female_t += $row['female_teachers'];
                                    $t_sms += $row['total_sms'];
                                    $t_sms_m += $row['male_sms_members'];
                                    $t_sms_f += $row['female_sms_members'];
                                @endphp

                                <tr>
                                    @if($index == 0)
                                        <td rowspan="{{ count($districts) }}">
                                            {{ $province }}
                                        </td>
                                    @endif

                                    <td class="text-start">{{ $row['district'] }}</td>
                                    <td>{{ $row['total_classes'] }}</td>
                                    <td>{{ $row['boys_no_disability'] }}</td>
                                    <td>{{ $row['girls_no_disability'] }}</td>
                                    <td>{{ $row['boys_disability'] }}</td>
                                    <td>{{ $row['girls_disability'] }}</td>
                                    <td>{{ $row['male_teachers'] }}</td>
                                    <td>{{ $row['female_teachers'] }}</td>
                                    <td>{{ $row['total_sms'] }}</td>
                                    <td>{{ $row['male_sms_members'] }}</td>
                                    <td>{{ $row['female_sms_members'] }}</td>
                                </tr>

                            @endforeach

                        @endforeach

                    </tbody>

                    {{-- TOTAL --}}
                    @php
                        $total_students_without_disability = $t_b_no + $t_g_no;
                        $total_students_with_disability = $t_b_dis + $t_g_dis;
                        $grand_total_students = $total_students_without_disability + $total_students_with_disability;

                        $total_teachers = $t_male_t + $t_female_t;

                        $total_sms_members = $t_sms_m + $t_sms_f;
                    @endphp

                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="2" rowspan="3">TOTAL</td>
                            <td rowspan="3">{{ $t_classes }}</td>
                            <td>{{ $t_b_no }}</td>
                            <td>{{ $t_g_no }}</td>
                            <td>{{ $t_b_dis }}</td>
                            <td>{{ $t_g_dis }}</td>
                            <td>{{ $t_male_t }}</td>
                            <td>{{ $t_female_t }}</td>
                            <td rowspan="3">{{ $t_sms }}</td>
                            <td>{{ $t_sms_m }}</td>
                            <td>{{ $t_sms_f }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">{{ $total_students_without_disability }}</td>
                            <td colspan="2">{{ $total_students_with_disability }}</td>
                            <td colspan="2">{{ $total_teachers }}</td>
                            <td colspan="2">{{ $total_sms_members }}</td>
                        </tr>

                        <tr>
                            <td colspan="4">{{ $grand_total_students }}</td>
                            <td colspan="2"></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection