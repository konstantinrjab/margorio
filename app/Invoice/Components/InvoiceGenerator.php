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
        if ($type == static::TYPE_FULL) {
            $templateName = 'invoice.invoice_full';
            $invoiceData = $employee->invoice_data['full'];

        } elseif ($type == static::TYPE_PROBATION) {
            $templateName = 'invoice.invoice_probation';
            $invoiceData = $employee->invoice_data['probation'];

        } else {
            throw new RuntimeException('invalid invoice type');
        }

        $html = view($templateName, [
            'invoice_number'         => $invoiceNumber,
            'date_en'                => $date->format('F, d Y'),
            'date_uk'                => $date->locale('uk_UA')->translatedFormat('d F Y') . ' року',
            'from_en'                => '',
            'from_uk'                => '',
            'tax_number'             => $employee->tax_number,
            'address_en'             => $invoiceData['address_en'],
            'address_uk'             => $invoiceData['address_uk'] ?? '',
            'bank_details_en'        => $invoiceData['bank_details_en'],
            'bank_details_uk'        => $invoiceData['bank_details_uk'] ?? '',
            'invoice_subject_en'     => $invoiceData['subject_en'],
            'invoice_subject_uk'     => $invoiceData['subject_uk'] ?? '',
            'invoice_description_en' => $invoiceData['description_en'],
            'invoice_description_uk' => $invoiceData['description_uk'] ?? '',
            'amount'                 => $amount,
            'full_name_en'           => $employee->full_name_en,
            'full_name_uk'           => $employee->full_name_uk,
        ])->render();

        return new Pdf($html);
    }
}
