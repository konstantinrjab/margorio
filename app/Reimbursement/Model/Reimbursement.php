<?php

namespace App\Reimbursement\Model;

use App\Employee\Model\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperReimbursement
 */
class Reimbursement extends Model
{
    use AsSource, Filterable, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'description',
        'amount',
        'date',
        'approved',
    ];

    protected $casts = [
        'date'     => 'date',
        'approved' => 'bool',
    ];

    public $allowedSorts = [
        'employee_id',
        'description',
        'amount',
        'date',
        'approved',
    ];

    protected $allowedFilters = [
        'description',
        'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
