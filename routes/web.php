<?php

use App\Http\Controllers\Beneficiary;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BeneficiarySummaryController;
use App\Http\Controllers\ClassTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfastractorController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Provinces;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ThematicAreaController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    // Projects
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects', 'AllProjects')->name('all.projects');
        Route::get('/add/project', 'AddProject')->name('add.project');
        Route::post('/store/project', 'StoreProject')->name('store.project');
        Route::get('/edit/project/{id}', 'EditProject')->name('edit.project');
        Route::post('/update/project/{id}',  'UpdateProject')->name('update.project');
        Route::get('/show/project/{id}', 'ShowProject')->name('show.project');
        Route::get('/delete/project/{id}', 'DeleteProject')->name('delete.project');
        Route::post('/get-project-districts', 'getProjectDistricts');
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
        Route::get('/get-classes-districts/{province_id}', 'getClassesDistricts');
    });

     // Project Students
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/students/{id}', 'AllProjectsStudents')->name('all.projects.students');
        Route::post('/store/projects/students/{id}', 'StoreProjectStudents')->name('store.projects.students');
        Route::post('/projects/students/{id}/update', 'UpdateProjectStudents')->name('update.projects.students');
        Route::get('/delete/project/students/{id}', 'DeleteProjectStudents')->name('delete.projects.students');
        Route::get('/get-student-districts/{province_id}', 'getStudentDistricts');

        Route::post('/projects/students/import/{id}', 'ImportProjectStudents')->name('import.projects.students');
        Route::get('/export/projects/students/{id}/{type}', 'exportStudents')->name('export.projects.students');
    });

     // Project Shura
    Route::controller(ProjectsController::class)->group(function () {
        Route::get('/all/projects/shura/{id}', 'AllProjectsShura')->name('all.projects.shura');
        Route::post('/store/projects/shura/{id}', 'StoreProjectShura')->name('store.projects.shura');
        Route::post('/projects/shura/{id}/update', 'UpdateProjectShura')->name('update.projects.shura');
        Route::get('/delete/project/shura/{id}', 'DeleteProjectShura')->name('delete.projects.shura');
        Route::get('/get-shura-districts/{province_id}',  'getShuraDistricts');

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
        Route::get('/export/projects/shura//members/{id}/{type}', 'exportShuraMember')->name('export.projects.shura.member');
    });

    // Project Training
    Route::controller(TrainingController::class)->group(function () {
        Route::get('/all/training/{id}', 'AllTraining')->name('all.training');
        Route::post('/store/training/{id}', 'StoreProjectTraining')->name('store.training');
        Route::post('/update/training/{id}', 'UpdateProjectTraining')->name('update.training');
        Route::get('/delete/training{id}', 'DeleteProjectTraining')->name('delete.training');
        Route::get('/get-training-districts/{province_id}', 'getTrainingDistricts');

        Route::post('/import/training/{id}', 'ImportProjectTraining')->name('import.training');
        Route::get('/export/training/{id}/{type}', 'ExportProjectTraining')->name('export.training');
    });

    // Project Training Participant
    Route::controller(TrainingController::class)->group(function () {
        Route::get('/all/training/participant/{id}', 'AllTrainingParticipant')->name('all.training.participant');
        Route::post('/store/training/participant/{id}', 'StoreTrainingParticipant')->name('store.training.participant');
        Route::post('/update/training/participant/{id}', 'UpdateTrainingParticipant')->name('update.training.participant');
        Route::get('/delete/training/participant/{id}', 'DeleteTrainingParticipant')->name('delete.training.participant');
        Route::get('/get-participant-districts/{province_id}',  'getParticipantDistricts');

        Route::post('/import/training/participants/{id}', 'ImportTrainingParticipant')->name('import.training.participant');
        Route::get('/export/training/participants/{id}/{type}', 'ExportTrainingParticipant')->name('export.training.participant');
    });

    // All Beneficiary
    Route::controller(BeneficiaryController::class)->group(function () {
        Route::get('/all/beneficiary', 'AllBeneficiary')->name('all.beneficiary');
        Route::get('/beneficiary/project-data', 'projectData')->name('beneficiary.project.data');
        // Route::get('/all/beneficiary/summary', 'AllBeneficiarySummary')->name('all.beneficiary.summary');
        Route::get('/beneficiary/project/{project}','ProjectBeneficiarySummary')->name('beneficiary.project.summary');
        Route::get('/beneficiary/project/{project}/export', 'ExportBeneficiarySummary')->name('beneficiary.project.export');
    });

    // All Beneficiary
    Route::controller(BeneficiarySummaryController::class)->group(function () {
        Route::get('/all/beneficiary/summary', 'AllBeneficiarySummary')->name('all.beneficiary.summary');
        Route::get('/all/beneficiary/summary/export', 'ExportAllBeneficiarySummary')->name('all.beneficiary.summary.export');
    });

    // All Provinces Catalog
    Route::controller(Provinces::class)->group(function () {
        Route::get('/all/provinces', 'AllProvinces')->name('all.provinces');
        Route::get('/add/province', 'AddProvince')->name('add.province');
        Route::post('/store/province', 'StoreProvince')->name('store.province');
        Route::get('/edit/province/{id}', 'EditProvince')->name('edit.province');
        Route::post('/update/province/{id}', 'UpdateProvince')->name('update.province');
        Route::get('/delete/province/{id}', 'DeleteProvince')->name('delete.province');
    });

    // All Languages Catalog
    Route::controller(LanguageController::class)->group(function () {
        Route::get('/all/language', 'AllLanguage')->name('all.language');
        Route::get('/add/language', 'AddLanguage')->name('add.language');
        Route::post('/store/language', 'StoreLanguage')->name('store.language');
        Route::get('/edit/language/{id}', 'EditLanguage')->name('edit.language');
        Route::post('/update/language/{id}', 'UpdateLanguage')->name('update.language');
        Route::get('/delete/language/{id}', 'DeleteLanguage')->name('delete.language');
    });

    // All Class Types Catalog
    Route::controller(ClassTypeController::class)->group(function () {
        Route::get('/all/class/type', 'AllClassType')->name('all.class.type');
        Route::get('/add/class/type', 'AddClassType')->name('add.class.type');
        Route::post('/store/class/type', 'StoreClassType')->name('store.class.type');
        Route::get('/edit/class/type/{id}', 'EditLanguage')->name('edit.class.type');
        Route::post('/update/class/type/{id}', 'UpdateLanguage')->name('update.class.type');
        Route::get('/delete/class/type/{id}', 'DeleteLanguage')->name('delete.class.type');
    });

    // All Thematic Area Catalog
    Route::controller(ThematicAreaController::class)->group(function () {
        Route::get('/all/thematic/area', 'AllThematicArea')->name('all.thematic.area');
        Route::get('/add/thematic/area', 'AddThematicArea')->name('add.thematic.area');
        Route::post('/store/thematic/area', 'StoreThematicArea')->name('store.thematic.area');
        Route::get('/edit/thematic/area/{id}', 'EditThematicArea')->name('edit.thematic.area');
        Route::post('/update/thematic/area/{id}', 'UpdateThematicArea')->name('update.thematic.area');
        Route::get('/delete/thematic/area/{id}', 'DeleteThematicArea')->name('delete.thematic.area');
    });

    // All Training Type Catalog
    Route::controller(TrainingTypeController::class)->group(function () {
        Route::get('/all/trainings/type', 'AllTrainingType')->name('all.training.type');
        Route::get('/add/training/types', 'AddTrainingType')->name('add.training.type');
        Route::post('/store/trainings/type', 'StoreTrainingType')->name('store.training.type');
        Route::get('/edit/trainings/type/{id}', 'EditTrainingType')->name('edit.training.type');
        Route::post('/update/trainings/type/{id}', 'UpdateTrainingType')->name('update.training.type');
        Route::get('/delete/trainings/type/{id}', 'DeleteTrainingType')->name('delete.training.type');
    });

     // All Residence Type Catalog
    Route::controller(ResidenceController::class)->group(function () {
        Route::get('/all/residence', 'AllResidence')->name('all.residence');
        Route::get('/add/residence', 'AddResidence')->name('add.residence');
        Route::post('/store/residence', 'StoreResidence')->name('store.residence');
        Route::get('/edit/residence/{id}', 'EditResidence')->name('edit.residence');
        Route::post('/update/residence/{id}', 'UpdateResidence')->name('update.residence');
        Route::get('/delete/residence/{id}', 'DeleteResidence')->name('delete.residence');
    });

     // All Residence Type Catalog
    Route::controller(InfastractorController::class)->group(function () {
        Route::get('/all/infas', 'AllInfas')->name('all.infas');
        Route::get('/add/infas', 'AddInfas')->name('add.infas');
        Route::post('/store/infas', 'StoreInfas')->name('store.infas');
        Route::get('/edit/infas/{id}', 'EditInfas')->name('edit.infas');
        Route::post('/update/infas/{id}', 'UpdateInfas')->name('update.infas');
        Route::get('/delete/infas/{id}', 'DeleteInfas')->name('delete.infas');
    });

    // All Status Catalog
    Route::controller(StatusController::class)->group(function () {
        Route::get('/all/status', 'AllStatus')->name('all.status');
        Route::get('/add/status', 'AddStatus')->name('add.status');
        Route::post('/store/status', 'StoreStatus')->name('store.status');
        Route::get('/edit/status/{id}', 'EditStatus')->name('edit.status');
        Route::post('/update/status/{id}', 'UpdateStatus')->name('update.status');
        Route::get('/delete/status/{id}', 'DeleteStatus')->name('delete.status');
    });

    // All Project Status Catalog
    Route::controller(StatusController::class)->group(function () {
        Route::get('/all/project/status', 'AllProjectStatus')->name('all.project.status');
        Route::get('/add/project/status', 'AddProjectStatus')->name('add.project.status');
        Route::post('/store/project/status', 'StoreProjectStatus')->name('store.project.status');
        Route::get('/edit/project/status/{id}', 'EditProjectStatus')->name('edit.project.status');
        Route::post('/update/project/status/{id}', 'UpdateProjectStatus')->name('update.project.status');
        Route::get('/delete/project/status/{id}', 'DeleteProjectStatus')->name('delete.project.status');
    });

});

require __DIR__.'/auth.php';
