<?php

namespace App\Invoice\Orchid\Request;

use App\Invoice\Components\InvoiceService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateInvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invoice_type'                 => ['required', 'string', Rule::in([InvoiceService::TYPE_FULL, InvoiceService::TYPE_PROBATION])],
            'date'                         => ['required', 'date', 'date_format:Y-m-d'],
            'employees'                    => ['array', 'required'],
            'employees.*.amount'           => ['int', 'present'],
            'employees.*.selected'         => ['bool', 'present'],
            'employees.*.full.number'      => ['int', 'present'],
            'employees.*.probation.number' => ['int', 'present'],
        ];
    }
}
