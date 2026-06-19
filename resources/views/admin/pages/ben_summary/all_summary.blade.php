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

@endsection