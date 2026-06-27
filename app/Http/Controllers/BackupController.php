<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function BackupRun(){
        date_default_timezone_set('Asia/Kabul');
        $file = 'backup_' . date('Y_m_d_H_i_s') . '.sql';
        $path = storage_path("app/private/backups/$file");
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        $file = basename($file);
        $path = storage_path("app/private/backups/$file");
        $dumpPath = 'C:/xampp/mysql/bin/mysqldump.exe'; 
        exec("\"$dumpPath\" -u root school > \"$path\"");
        return redirect()->route('backup.list')
            ->with('success', 'Backup created successfully');
    }

    public function list(){
        $path = storage_path('app/private/backups');
        $files = File::exists($path) ? File::files($path) : [];
        return view('admin.pages.backup.list', compact('files'));
    }

    public function download($file){
        $file = basename($file);
        $path = storage_path("app/private/backups/{$file}");
        if (!File::exists($path)) {
            abort(404);
        }
        return response()->download($path);
    }

    public function delete($file){
        $file = basename($file);
        $path = storage_path("app/private/backups/{$file}");
        if (!File::exists($path)) {
            return back()->with('error', 'Backup file not found.');
        }
        File::delete($path);
        return back()->with('success', 'Backup deleted successfully.');
    }
}