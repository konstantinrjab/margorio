<?php

namespace App\Invoice\Orchid\Controller\Request;

use App\Invoice\Components\InvoiceService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invoice_type' => ['required', 'string', Rule::in([InvoiceService::TYPE_FULL, InvoiceService::TYPE_PROBATION])],
            'date'         => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
