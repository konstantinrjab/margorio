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
    ];

    protected $casts = [
        'invoice_data' => 'array',
    ];

    public $allowedSorts = [
        'full_name_en',
        'full_name_uk',
        'tax_number',
    ];

    protected $allowedFilters = [
        'full_name_en',
        'full_name_uk',
        'tax_number',
    ];
}
