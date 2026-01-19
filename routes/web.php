<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OpdMasterController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\RequireLogin;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');

// Public Survey
Route::get('/survey/{survey:slug}/fill', [LandingPageController::class, 'surveyDetail'])->name('survey.public_detail');
Route::get('/survey/v/{token}', [LandingPageController::class, 'surveyByToken'])->name('survey.private_access');
Route::post('/survey/{survey:slug}/submit', [LandingPageController::class, 'surveySubmit'])->name('survey.public_submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(RequireLogin::class);

Route::get('/profile', Profile::class)->name('profile')->middleware(RequireLogin::class);

Route::middleware([RequireLogin::class, 'role:super-admin|admin-opd'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index')->middleware([RequireLogin::class, 'permission:view-user']);
    Route::get('/users/suggest', [UsersController::class, 'suggest'])->name('users.suggest')->middleware([RequireLogin::class, 'permission:view-user']);
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create')->middleware([RequireLogin::class, 'permission:add-user']);
    Route::post('/users', [UsersController::class, 'store'])->name('users.store')->middleware([RequireLogin::class, 'permission:add-user']);
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware([RequireLogin::class, 'permission:edit-user']);
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update')->middleware([RequireLogin::class, 'permission:edit-user']);
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware([RequireLogin::class, 'permission:delete-user']);

    // OPD Master
    Route::get('/master-opd', [OpdMasterController::class, 'index'])->name('opd.index')->middleware([RequireLogin::class, 'permission:view-master-opd']);
    Route::get('/master-opd/suggest', [OpdMasterController::class, 'suggest'])->name('opd.suggest')->middleware([RequireLogin::class, 'permission:view-master-opd']);
    Route::get('/master-opd/create', [OpdMasterController::class, 'create'])->name('opd.create')->middleware([RequireLogin::class, 'permission:add-master-opd']);
    Route::post('/master-opd', [OpdMasterController::class, 'store'])->name('opd.store')->middleware([RequireLogin::class, 'permission:add-master-opd']);
    Route::get('/master-opd/{opd}/edit', [OpdMasterController::class, 'edit'])->name('opd.edit')->middleware([RequireLogin::class, 'permission:edit-master-opd']);
    Route::put('/master-opd/{opd}', [OpdMasterController::class, 'update'])->name('opd.update')->middleware([RequireLogin::class, 'permission:edit-master-opd']);
    Route::delete('/master-opd/{opd}', [OpdMasterController::class, 'destroy'])->name('opd.destroy')->middleware([RequireLogin::class, 'permission:delete-master-opd']);

    // Agenda Master
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index')->middleware([RequireLogin::class, 'permission:view-agenda']);
    Route::get('/agenda/suggest', [AgendaController::class, 'suggest'])->name('agenda.suggest')->middleware([RequireLogin::class, 'permission:view-agenda']);
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create')->middleware([RequireLogin::class, 'permission:add-agenda']);
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store')->middleware([RequireLogin::class, 'permission:add-agenda']);
    Route::get('/agenda/edit/{agenda}', [AgendaController::class, 'edit'])->name('agenda.edit')->middleware([RequireLogin::class, 'permission:edit-agenda']);
    Route::put('/agenda/update/{agenda}', [AgendaController::class, 'update'])->name('agenda.update')->middleware([RequireLogin::class, 'permission:edit-agenda']);
    Route::delete('/agenda/delete/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy')->middleware([RequireLogin::class, 'permission:delete-agenda']);
    Route::get('/agenda/export/{agenda}', [AgendaController::class, 'export'])->name('agenda.export')->middleware([RequireLogin::class, 'permission:export-absensi']);
    Route::get('/agenda/absensi/{agenda}', [AgendaController::class, 'showAbsensi'])->name('agenda.absensi')->middleware([RequireLogin::class, 'permission:view-agenda']);

    // Event Master
    Route::get('/event', [EventController::class, 'index'])->name('event.index')->middleware([RequireLogin::class, 'permission:view-event']);
    Route::get('/event/suggest', [EventController::class, 'suggest'])->name('event.suggest')->middleware([RequireLogin::class, 'permission:view-event']);
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create')->middleware([RequireLogin::class, 'permission:add-event']);
    Route::post('/event', [EventController::class, 'store'])->name('event.store')->middleware([RequireLogin::class, 'permission:add-event']);
    Route::get('/event/edit/{event}', [EventController::class, 'edit'])->name('event.edit')->middleware([RequireLogin::class, 'permission:edit-event']);
    Route::put('/event/update/{event}', [EventController::class, 'update'])->name('event.update')->middleware([RequireLogin::class, 'permission:edit-event']);
    Route::delete('/event/delete/{event}', [EventController::class, 'destroy'])->name('event.destroy')->middleware([RequireLogin::class, 'permission:delete-event']);

    // Survey Master
    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index')->middleware([RequireLogin::class, 'permission:view-survey']);
    Route::get('/survey/suggest', [SurveyController::class, 'suggest'])->name('survey.suggest')->middleware([RequireLogin::class, 'permission:view-survey']);
    Route::get('/survey/create', [SurveyController::class, 'create'])->name('survey.create')->middleware([RequireLogin::class, 'permission:add-survey']);
    Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store')->middleware([RequireLogin::class, 'permission:add-survey']);
    Route::get('/survey/{survey}/edit', [SurveyController::class, 'edit'])->name('survey.edit')->middleware([RequireLogin::class, 'permission:edit-survey']);
    Route::put('/survey/{survey}', [SurveyController::class, 'update'])->name('survey.update')->middleware([RequireLogin::class, 'permission:edit-survey']);
    Route::delete('/survey/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy')->middleware([RequireLogin::class, 'permission:delete-survey']);
    Route::post('/survey/{survey}/questions', [SurveyController::class, 'storeQuestion'])->name('survey.questions.store')->middleware([RequireLogin::class, 'permission:edit-survey']);
    Route::delete('/survey/questions/{question}', [SurveyController::class, 'destroyQuestion'])->name('survey.questions.destroy')->middleware([RequireLogin::class, 'permission:edit-survey']);
    Route::get('/survey/{survey}/results', [SurveyController::class, 'results'])->name('survey.results')->middleware([RequireLogin::class, 'permission:view-survey-result']);
    Route::get('/survey/{survey}/export-pdf', [SurveyController::class, 'exportPdf'])->name('survey.export_pdf')->middleware([RequireLogin::class, 'permission:view-survey-result']);

    // Editor Upload
    Route::post('/editor-upload', [UploadController::class, 'uploadImage'])->name('editor.upload');
    Route::post('/editor-delete', [UploadController::class, 'deleteImage'])->name('editor.delete');
});

// Public Agenda Detail
Route::get('/agenda/{agenda:slug}', [LandingPageController::class, 'showAgenda'])
    ->name('agenda.public_detail')
    ->where('agenda', '.*');

// Public Event Detail
Route::get('/event/{event:slug}', [LandingPageController::class, 'showEvent'])
    ->name('event.public_detail')
    ->where('event', '.*');

// Public Absensi Route
Route::get('/absensi/{token}', [App\Http\Controllers\AbsensiController::class, 'show'])->name('absensi.show');
Route::post('/absensi/{token}', [App\Http\Controllers\AbsensiController::class, 'store'])->name('absensi.store');
Route::get('/absensi/{token}/success/{absensi}', [App\Http\Controllers\AbsensiController::class, 'success'])->name('absensi.success');

Route::middleware([RequireLogin::class, 'role:super-admin'])->group(function () {
    Route::get('/role-permission', [RolePermissionController::class, 'index'])
        ->name('role_permission.index')->middleware([RequireLogin::class, 'permission:view-role-permission']);

    // Permissions
    Route::post('/permissions', [RolePermissionController::class, 'storePermission'])
        ->name('permissions.store')->middleware([RequireLogin::class, 'permission:add-permission']);
    Route::get('/permissions/suggest', [RolePermissionController::class, 'suggestPermission'])
        ->name('permissions.suggest')->middleware([RequireLogin::class, 'permission:view-role-permission']);
    Route::put('/permissions/{permission}', [RolePermissionController::class, 'updatePermission'])
        ->name('permissions.update')->middleware([RequireLogin::class, 'permission:edit-permission']);
    Route::delete('/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])
        ->name('permissions.destroy')->middleware([RequireLogin::class, 'permission:delete-permission']);

    // Roles
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])
        ->name('roles.store')->middleware([RequireLogin::class, 'permission:add-role']);
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])
        ->name('roles.update')->middleware([RequireLogin::class, 'permission:edit-role']);
    Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])
        ->name('roles.destroy')->middleware([RequireLogin::class, 'permission:delete-role']);
});



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
