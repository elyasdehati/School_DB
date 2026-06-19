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
                    <i class="bi bi-people"></i> Beneficiary
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('all.beneficiary.summary') ? 'active' : '' }}" 
                href="{{ route('all.beneficiary.summary') }}">
                    <i class="bi bi-people-fill me-1"></i> Beneficiary Summary
                </a>
            </li>
        </ul>
    </div>
</div>


<div class="card mt-3">
    <div class="card-header bg-white">
        <h5 class="mb-0">Beneficiary Summary Report</h5>
    </div>

    <div class="card-body table-responsive">

        @php
            $grouped = collect($reportData)->groupBy('project');

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
        @endphp

        <table class="table table-bordered text-center align-middle">

            <thead class="table-light">
                <tr>
                    <th>Project</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Classes</th>
                    <th>Boys</th>
                    <th>Girls</th>
                    <th>Dis Boys</th>
                    <th>Dis Girls</th>
                    <th>Male Teachers</th>
                    <th>Female Teachers</th>
                    <th>SMS</th>
                    <th>SMS Male</th>
                    <th>SMS Female</th>
                </tr>
            </thead>

            <tbody>

                @foreach($grouped as $projectName => $projectRows)

                    @php
                        $projectCount = $projectRows->count();
                    @endphp

                    @foreach($projectRows->groupBy('province') as $provinceName => $provinceRows)

                        @php
                            $provinceCount = $provinceRows->count();
                        @endphp

                        @foreach($provinceRows as $index => $row)

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

                                {{-- PROJECT --}}
                                @if($loop->parent->first && $loop->first)
                                    <td rowspan="{{ $projectCount }}" class="fw-bold bg-light">
                                        {{ $projectName }}
                                    </td>
                                @endif

                                {{-- PROVINCE --}}
                                @if($loop->first)
                                    <td rowspan="{{ $provinceCount }}">
                                        {{ $provinceName }}
                                    </td>
                                @endif

                                <td>{{ $row['district'] }}</td>
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
                @endforeach

            </tbody>

            @php
                $total_students_without_disability = $t_b_no + $t_g_no;
                $total_students_with_disability = $t_b_dis + $t_g_dis;
                $grand_total_students = $total_students_without_disability + $total_students_with_disability;

                $total_teachers = $t_male_t + $t_female_t;
                $total_sms_members = $t_sms_m + $t_sms_f;
            @endphp

            {{-- EXACT SAME 3 ROW FOOTER (LIKE ORIGINAL PAGE) --}}
            <tfoot class="table-secondary fw-bold">
                <tr>
                    <td colspan="3" rowspan="3">TOTAL</td>

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

@endsection