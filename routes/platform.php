<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });


// employees
Route::screen('employee/create', \App\Employee\Orchid\EmployeeEditScreen::class)->name('platform.employee.create');
Route::screen('employee/{employee?}/edit', \App\Employee\Orchid\EmployeeEditScreen::class)->name('platform.employee.edit');
Route::screen('employee/{employee?}', \App\Employee\Orchid\EmployeeShowScreen::class)->name('platform.employee.show');
Route::screen('employees', \App\Employee\Orchid\EmployeeListScreen::class)->name('platform.employee.list');

// invoices
Route::screen('invoices/generation', \App\Invoice\Orchid\InvoiceGenerationScreen::class)->name('platform.invoice.generation');

// salary
Route::screen('salary-calculation/create', \App\SalaryCalculation\Orchid\SalaryCalculationEditScreen::class)->name('platform.salaryCalculation.create');
Route::screen('salary-calculation/{employee?}/edit', \App\SalaryCalculation\Orchid\SalaryCalculationEditScreen::class)->name('platform.salaryCalculation.edit');
Route::screen('salary-calculation/{employee?}', \App\SalaryCalculation\Orchid\SalaryCalculationShowScreen::class)->name('platform.salaryCalculation.show');
Route::screen('salary-calculations', \App\SalaryCalculation\Orchid\SalaryCalculationListScreen::class)->name('platform.salaryCalculation.list');

// reimbursement
Route::screen('reimbursement/create', \App\Reimbursement\Orchid\ReimbursementEditScreen::class)->name('platform.reimbursement.create');
Route::screen('reimbursement/{reimbursement?}/edit', \App\Reimbursement\Orchid\ReimbursementEditScreen::class)->name('platform.reimbursement.edit');
Route::screen('reimbursement/{reimbursement?}', \App\Reimbursement\Orchid\ReimbursementShowScreen::class)->name('platform.reimbursement.show');
Route::screen('reimbursements', \App\Reimbursement\Orchid\ReimbursementListScreen::class)->name('platform.reimbursement.list');
