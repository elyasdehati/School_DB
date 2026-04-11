<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TeachersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects', 'AllProjects')->name('all.projects');
        Route::get('/add/project', 'AddProject')->name('add.project');
        Route::post('/store/project', 'StoreProject')->name('store.project');
        Route::get('/edit/project/{id}', 'EditProject')->name('edit.project');
        Route::post('/update/project/{id}',  'UpdateProject')->name('update.project');
        Route::get('/show/project/{id}', 'ShowProject')->name('show.project');
        Route::get('/delete/project/{id}', 'DeleteProject')->name('delete.project');
    });

});

require __DIR__.'/auth.php';
