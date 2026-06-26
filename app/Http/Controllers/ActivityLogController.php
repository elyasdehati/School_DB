<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function AllActivityLogs(){
        $logs = ActivityLog::with('user')->latest()->paginate(20);

        return view('admin.pages.activities.index', compact('logs'));
    }
}
