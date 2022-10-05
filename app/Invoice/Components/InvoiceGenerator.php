<?php

namespace App\Invoice\Components;

use App\Employee\Model\Employee;
use Carbon\Carbon;
use mikehaertl\wkhtmlto\Pdf;
use RuntimeException;

class InvoiceGenerator
{
    public const TYPE_FULL = 'full';
    public const TYPE_PROBATION = 'probation';

    /**
     * @param Employee $employee
     * @param string $type
     * @param Carbon $date
     * @param int $invoiceNumber
     * @param int $amount
     * @return Pdf
     */
    public function generate(Employee $employee, string $type, Carbon $date, int $invoiceNumber, int $amount): Pdf
    {
        $templateName = match ($type) {
            static::TYPE_FULL => 'invoice.invoice_full',
            static::TYPE_PROBATION => 'invoice.invoice_probation',
            default => throw new RuntimeException('invalid invoice type'),
        };

        $html = view($templateName, [
            'invoice_number'         => $invoiceNumber,
            'date_en'                => $date->format('F, d Y'),
            'date_uk'                => $date->locale('uk_UA')->translatedFormat('d F Y') . ' року',
            'from_en'                => '',
            'from_uk'                => '',
            'tax_number'             => $employee->tax_number,
            'address_en'             => $employee->address_en,
            'address_uk'             => $employee->address_uk,
            'bank_details_en'        => $employee->bank_details_en,
            'bank_details_uk'        => $employee->bank_details_uk,
            'invoice_subject_en'     => $employee->invoice_subject_en,
            'invoice_subject_uk'     => $employee->invoice_subject_uk,
            'invoice_description_en' => $employee->invoice_description_en,
            'invoice_description_uk' => $employee->invoice_description_uk,
            'amount'                 => $amount,
            'full_name_en'           => $employee->full_name_en,
            'full_name_uk'           => $employee->full_name_uk,
        ])->render();

        return new Pdf($html);
    }
}
