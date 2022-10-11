<?php

namespace App\Employee\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use AsSource, Filterable, SoftDeletes, HasFactory;

    protected $fillable = [
        'full_name_en',
        'full_name_uk',
        'tax_number',
        'invoice_data',
        'last_invoice_number',
        'last_invoice_generated_at',
    ];

    protected $casts = [
        'invoice_data'              => 'array',
        'last_invoice_number'       => 'int',
        'last_invoice_generated_at' => 'date',
    ];

    public $allowedSorts = [
        'full_name_en',
        'full_name_uk',
        'tax_number',
        'last_invoice_generated_at',
    ];

    protected $allowedFilters = [
        'full_name_en',
        'full_name_uk',
        'tax_number',
        'last_invoice_generated_at',
    ];
}
