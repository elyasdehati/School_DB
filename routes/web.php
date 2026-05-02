<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Provinces;
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

    // All Provinces
    Route::controller(Provinces::class)->group(function () {
        Route::get('/all/provinces', 'AllProvinces')->name('all.provinces');
        Route::get('/add/province', 'AddProvince')->name('add.province');
        Route::post('/store/province', 'StoreProvince')->name('store.province');
        Route::get('/edit/province/{id}', 'EditProvince')->name('edit.province');
        Route::post('/update/province/{id}', 'UpdateProvince')->name('update.province');
        Route::get('/delete/province/{id}', 'DeleteProvince')->name('delete.province');
    });

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

        Route::post('/import/projects/teachers/{id}', 'ImportProjectTeachers')->name('import.projects.teachers');
        Route::get('/export/projects/teachers/{id}/{type}', 'exportTeachers')->name('export.projects.teachers');
    });

    // Project Classes
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/class/{id}', 'AllProjectsClass')->name('all.projects.class');
        Route::post('/store/projects/class/{id}', 'StoreProjectClass')->name('store.projects.class');
        Route::post('/projects/classes/{id}/update', 'UpdateProjectClass')->name('update.projects.class');
        Route::get('/delete/project/class/{id}', 'DeleteProjectClass')->name('delete.projects.class');

        Route::post('/projects/classes/import/{id}','ImportProjectClasses')->name('import.projects.classes');
        Route::get('/export/classes/{id}/{type}', 'exportClasses')->name('export.projects.classes');
    });

     // Project Students
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/students/{id}', 'AllProjectsStudents')->name('all.projects.students');
        Route::post('/store/projects/students/{id}', 'StoreProjectStudents')->name('store.projects.students');
        Route::post('/projects/students/{id}/update', 'UpdateProjectStudents')->name('update.projects.students');
        Route::get('/delete/project/students/{id}', 'DeleteProjectStudents')->name('delete.projects.students');

        Route::post('/projects/students/import/{id}', 'ImportProjectStudents')->name('import.projects.students');
        Route::get('/export/projects/students/{id}/{type}', 'exportStudents')->name('export.projects.students');
    });

     // Project Shura
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/shura/{id}', 'AllProjectsShura')->name('all.projects.shura');
        Route::post('/store/projects/shura/{id}', 'StoreProjectShura')->name('store.projects.shura');
        Route::post('/projects/shura/{id}/update', 'UpdateProjectShura')->name('update.projects.shura');
        Route::get('/delete/project/shura/{id}', 'DeleteProjectShura')->name('delete.projects.shura');

        Route::post('/import/projects/shura/{id}', 'ImportProjectShura')->name('import.projects.shura');
        Route::get('/export/projects/shura/{id}/{type}', 'exportShura')->name('export.projects.shura');
    });

    // Project Shura Members
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/shura/members/{id}', 'AllProjectsShuraMembers')->name('all.projects.shura.members');
         Route::post('/store/projects/shura/members/{id}', 'StoreProjectShuraMembers')->name('store.projects.shura.members');
        Route::post('/update/projects/shura/members/{id}', 'UpdateProjectShuraMembers')->name('update.projects.shura.members');
        Route::get('/delete/projects/shura/members/{id}', 'DeleteProjectShuraMembers')->name('delete.projects.shura.members');

        Route::post('/import/projects/shura/members/{id}', 'ImportProjectShuraMembers')->name('import.projects.shura.members');
    });

});

require __DIR__.'/auth.php';
