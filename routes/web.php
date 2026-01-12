<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OpdMasterController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Middleware\RequireLogin;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');
Route::get('/agenda-detail/{agenda}', [LandingPageController::class, 'showAgenda'])->name('agenda.public_detail');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.index')->middleware(RequireLogin::class);

Route::get('/profile', Profile::class)->name('profile')->middleware(RequireLogin::class);

Route::middleware([RequireLogin::class, 'role:super-admin|admin'])->group(function () {
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
    Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('agenda.edit')->middleware([RequireLogin::class, 'permission:edit-agenda']);
    Route::put('/agenda/{agenda}', [AgendaController::class, 'update'])->name('agenda.update')->middleware([RequireLogin::class, 'permission:edit-agenda']);
    Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy')->middleware([RequireLogin::class, 'permission:delete-agenda']);
    Route::get('/agenda/{agenda}/export', [AgendaController::class, 'export'])->name('agenda.export')->middleware([RequireLogin::class, 'permission:export-absensi']);
    Route::get('/agenda/{agenda}/absensi', [AgendaController::class, 'showAbsensi'])->name('agenda.absensi')->middleware([RequireLogin::class, 'permission:view-agenda']);
});

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
