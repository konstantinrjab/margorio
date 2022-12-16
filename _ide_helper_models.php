<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Core\Models{
/**
 * App\Core\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $permissions
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orchid\Platform\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User averageByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAccess(string $permitWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAnyAccess($permitsWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User countByDays($startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User countForGroup(string $groupColumn)
 * @method static \Illuminate\Database\Eloquent\Builder|User defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|User filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|User maxByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User minByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sumByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User valuesByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class IdeHelperUser {}
}

namespace App\Employee\Model{
/**
 * App\Employee\Model\Employee
 *
 * @property int $id
 * @property string $full_name_en
 * @property string $full_name_uk
 * @property string $tax_number
 * @property array $invoice_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $rate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reimbursement\Model\Reimbursement[] $reimbursement
 * @property-read int|null $reimbursement_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SalaryCalculation\Model\EmployeeReport[] $salaryCalculations
 * @property-read int|null $salary_calculations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\Employee\Model\EmployeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Query\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFullNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFullNameUk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereInvoiceData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereTaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employee withoutTrashed()
 */
	class IdeHelperEmployee {}
}

namespace App\Reimbursement\Model{
/**
 * App\Reimbursement\Model\Reimbursement
 *
 * @property int $id
 * @property int $employee_id
 * @property string $description
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property bool $approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Employee\Model\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\Reimbursement\Model\ReimbursementFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement newQuery()
 * @method static \Illuminate\Database\Query\Builder|Reimbursement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reimbursement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Reimbursement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Reimbursement withoutTrashed()
 */
	class IdeHelperReimbursement {}
}

namespace App\SalaryCalculation\Model{
/**
 * App\SalaryCalculation\Model\SalaryCalculation
 *
 * @property int $id
 * @property int $employee_id
 * @property int|null $working_days
 * @property int|null $days_worked
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Employee\Model\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\SalaryCalculation\Model\EmployeeReportFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport filters(?mixed $kit = null, ?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport filtersApplySelection($class)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport newQuery()
 * @method static \Illuminate\Database\Query\Builder|EmployeeReport onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereDaysWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeReport whereWorkingDays($value)
 * @method static \Illuminate\Database\Query\Builder|EmployeeReport withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EmployeeReport withoutTrashed()
 */
	class IdeHelperSalaryCalculation {}
}

