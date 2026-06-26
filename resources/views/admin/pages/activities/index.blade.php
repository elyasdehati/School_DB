@extends('admin.admin_master')

@section('admin')

<div class="content">
    <div class="container-xxl">
        <div class="card mt-1">

            <!-- Header -->
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">User Activity Logs</h5>
                    <span class="badge bg-dark">System Monitoring</span>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($logs as $key => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $key }}</td>

                                    <!-- USER NAME (NOT ID) -->
                                    <td>
                                        <span class="fw-semibold text-primary">
                                            {{ $log->user->name ?? 'System' }}
                                        </span>
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $log->action }}
                                        </span>
                                    </td>

                                    <!-- DESCRIPTION -->
                                    <td>
                                        {{ $log->description }}
                                    </td>

                                    <!-- DATE -->
                                    <td>
                                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>

            </div>

        </div>
    </div>
</div>

@endsection