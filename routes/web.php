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

    // Project Teachers
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/teachers/{id}', 'AllProjectsTeachers')->name('all.projects.teachers');
        Route::post('/store/projects/teachers/{id}', 'StoreProjectTeacher')->name('store.projects.teacher');
        Route::post('/update/project/teacher/{id}', 'UpdateProjectTeacher')->name('update.projects.teacher');
        Route::get('/delete/project/teacher/{id}', 'DeleteProjectTeacher')->name('delete.projects.teacher');
    });

    // Project Classes
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/class/{id}', 'AllProjectsClass')->name('all.projects.class');
        Route::post('/store/projects/class/{id}', 'StoreProjectClass')->name('store.projects.class');
        Route::post('/projects/classes/{id}/update', 'UpdateProjectClass')->name('update.projects.class');
        Route::get('/delete/project/class/{id}', 'DeleteProjectClass')->name('delete.projects.class');
    });

     // Project Students
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/students/{id}', 'AllProjectsStudents')->name('all.projects.students');
        Route::post('/store/projects/students/{id}', 'StoreProjectStudents')->name('store.projects.students');
        Route::post('/projects/students/{id}/update', 'UpdateProjectStudents')->name('update.projects.students');
        Route::get('/delete/project/students/{id}', 'DeleteProjectStudents')->name('delete.projects.students');
    });

});

require __DIR__.'/auth.php';
