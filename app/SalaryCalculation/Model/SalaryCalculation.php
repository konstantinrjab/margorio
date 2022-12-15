<?php

namespace App\SalaryCalculation\Model;

use App\Employee\Model\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperSalaryCalculation
 */
class SalaryCalculation extends Model
{
    use AsSource, Filterable, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'working_days',
        'days_worked',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public $allowedSorts = [
        'date',
    ];

    protected $allowedFilters = [
        'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
