<?php

namespace App\Invoice\Orchid\Controller;

use App\Core\Http\Controllers\Controller;
use App\Employee\Model\Employee;
use App\Invoice\Components\InvoiceService;
use App\Invoice\Orchid\Controller\Request\GenerateInvoiceRequest;
use App\Invoice\Orchid\Controller\Request\InvoiceDataRequest;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InvoiceController extends Controller
{
    public function index(InvoiceService $invoiceService, SalaryCalculator $salaryCalculator, InvoiceDataRequest $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->input('date'));

        /** @var Collection<int, Employee> $employees */
        $employees = Employee::where(['active' => true])
            ->orderBy('full_name_en')
            ->get();

        $result = [];

        foreach ($employees as $employee) {
            $result[] = [
                'id'             => $employee->id,
                'full_name_en'   => $employee->full_name_en,
                'full_name_uk'   => $employee->full_name_uk,
                'tax_number'     => $employee->tax_number,
                'invoice_data'   => $employee->invoice_data,
                'invoice_number' => $invoiceService->getInvoiceNumber($employee, $request->input('invoice_type')),
                'amount'         => $salaryCalculator->calculate($employee, $date)['amount'],
            ];
        }

        return $result;
    }

    public function generate(GenerateInvoiceRequest $request, InvoiceService $invoiceService)
    {
        $pdfs = $invoiceService->generate(
            $request->input('employees'),
            $request->input('invoice_type'),
            Carbon::parse($request->input('date'))
        );

        if (count($pdfs) == 1) {
            return response()->streamDownload(function () use ($pdfs) {
                echo $pdfs[0]['file']->toString();
            }, $pdfs[0]['name'], [
                'Content-Type' => 'application/pdf',
            ]);
        } else {
            $zipPath = $invoiceService->toZipArchive($pdfs);

            return response()->streamDownload(function () use ($zipPath) {
                return readfile($zipPath);
            }, 'invoices.zip', [
                'Content-Type' => 'application/zip',
            ]);
        }
    }
}
