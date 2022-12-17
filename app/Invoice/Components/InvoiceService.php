<?php

namespace App\Invoice\Components;

use App\Employee\Model\Employee;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use mikehaertl\wkhtmlto\Pdf;
use RuntimeException;
use ZipArchive;

class InvoiceService
{
    public const TYPE_FULL = 'full';
    public const TYPE_PROBATION = 'probation';


    function getInvoiceNumber(Employee $employee, string $type): int
    {
        $generatedAt = $employee->invoice_data[$type]['generated_at'] ?? null;
        $lastNumber = $employee->invoice_data[$type]['number'] ?? null;

        if ($lastNumber && $generatedAt) {
            $generatedAt = Carbon::parse($employee->invoice_data[$type]['generated_at']);

            $diff = Carbon::now()->setDay(1)->diff($generatedAt->setDay(1));
            $lastNumber = $employee->invoice_data[$type]['number'] ?? 0;

            return $lastNumber + ($diff->m + $diff->y * 12);
        }

        return $lastNumber ? $lastNumber + 1 : 1;
    }

    /**
     * @param array{id: int, amount: int, number: int} $employeesData
     * @param string $type
     * @param Carbon $date
     * @return array{file: Pdf, name: string}
     */
    public function generate(array $employeesData, string $type, Carbon $date): array
    {
        $employees = Employee::whereIn('id', Arr::pluck($employeesData, 'id'))->get();
        $pdfs = [];

        foreach ($employeesData as $employeeData) {
            $employee = $employees->first(fn($e) => $e->id == $employeeData['id']);

            $pdfs[] = [
                'file' => $this->generatePdf($employee, $type, $date, $employeeData['number'], $employeeData['amount']),
                'name' => $this->getPdfName($employee, $date),
            ];
            $this->updateEmployee($employee, $type, $employeeData['number']);
        }

        return $pdfs;
    }

    /**
     * @param array{file: Pdf, name: string}[] $pdfs
     * @return string
     */
    public function toZipArchive(array $pdfs): string
    {
        $zipPath = tempnam('/tmp', 'zip');

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            throw new RuntimeException('Zip issue');
        }

        foreach ($pdfs as $pdf) {
            /** @var array{file: Pdf, name: string} $pdf */
            $pdfPath = tempnam('/tmp', 'pdf');
            $handle = fopen($pdfPath, 'w');
            fwrite($handle, $pdf['file']->toString());
            fclose($handle);

            if (!$zip->addFile($pdfPath, $pdf['name'])) {
                throw new RuntimeException('Fail add pdf to zip');
            }
        }

        $zip->close();

        return $zipPath;
    }

    /**
     * @param Employee $employee
     * @param string $type
     * @param Carbon $date
     * @param int $invoiceNumber
     * @param int $amount
     * @return Pdf
     */
    protected function generatePdf(Employee $employee, string $type, Carbon $date, int $invoiceNumber, int $amount): Pdf
    {
        $templateName = match ($type) {
            static::TYPE_FULL => 'invoice.invoice_full',
            static::TYPE_PROBATION => 'invoice.invoice_probation',
            default => throw new RuntimeException('invalid invoice type'),
        };
        $invoiceData = $employee->invoice_data[static::TYPE_PROBATION];

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

    protected function getPdfName(mixed $employee, Carbon $date): string
    {
        return $employee->full_name_en . '_' . $date->format('Md_y') . '.pdf';
    }

    protected function updateEmployee(Employee $employee, string $type, int $invoice_number): void
    {
        $data = $employee->invoice_data;
        $data[$type]['number'] = $invoice_number;
        $data[$type]['generated_at'] = Carbon::now()->format('Y-m-d');
        $employee->invoice_data = $data;
        $employee->save();
    }
}
