<?php

namespace App\Invoice\Request;

use App\Invoice\Components\InvoiceGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invoice_type'               => ['required', 'string', Rule::in([InvoiceGenerator::TYPE_FULL, InvoiceGenerator::TYPE_PROBATION])],
            'date'                       => ['required', 'date', 'date_format:Y-m-d'],
            'employees'                  => ['array', 'required'],
            'employees.*.amount'         => ['int', 'present'],
            'employees.*.selected'       => ['bool', 'present'],
            'employees.*.invoice_number' => ['int', 'present'],
        ];
    }
}
