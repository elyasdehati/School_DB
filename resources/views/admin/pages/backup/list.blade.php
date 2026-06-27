@extends('admin.admin_master')
@section('admin')

<div class="content mt-3 mb-3">
    <div class="container-xxl">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Backup Management</h4>

                <a href="{{ route('backup.run') }}" class="btn btn-primary">
                    <i data-feather="database" class="me-1"></i>
                    Create Backup
                </a>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Last Modified</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($files as $key => $file)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $file->getFilename() }}</td>
                                    <td>{{ number_format($file->getSize() / 1024 / 1024, 2) }} MB</td>
                                    <td>{{ date('Y-m-d H:i', $file->getMTime()) }}</td>
                                    <td>
                                        <a href="{{ route('backup.download', $file->getFilename()) }}" class="btn btn-success btn-sm">
                                            Download
                                        </a>

                                        <form action="{{ route('backup.delete', $file->getFilename()) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this backup?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No backup found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection