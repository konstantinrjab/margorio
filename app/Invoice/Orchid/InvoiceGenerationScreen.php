<?php

declare(strict_types=1);

namespace App\Invoice\Orchid;

use App\Employee\Model\Employee;
use App\Invoice\Components\InvoiceGenerator;
use App\Invoice\Request\GenerateRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use ZipArchive;
use RuntimeException;

class InvoiceGenerationScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'employees' => Employee::filters()->defaultSort('full_name_en')->get(),
        ];
    }

    public function name(): ?string
    {
        return __('Invoices');
    }

    public function layout(): iterable
    {
        return [

            Layout::rows([
                Group::make([

                    DateTimer::make('date')
                        ->format('Y-m-d')
                        ->value(date('Y-m-d'))
                        ->required()
                        ->title('Date'),

                    Select::make(__('invoice_type'))
                        ->options([InvoiceGenerator::TYPE_FULL => 'Full', InvoiceGenerator::TYPE_PROBATION => 'Probation'])
                        ->value(1)
                        ->required()
                        ->title('Invoice Type'),
                ]),

                Button::make(__('Generate Selected'))
                    ->icon('arrow-down-circle')->type(Color::DEFAULT())
                    ->method('generate')
                    ->set('turbo', false)
                    ->set('formmethod', 'post'),

            ]),

            Layout::table('employees', [

                TD::make('full_name_en', __('Full Name EN'))
                    ->sort()
                    ->filter()
                ,
                TD::make('last_invoice_number', __('Invoice Number'))
                    ->render(
                        function (Employee $employee) {
                            $diff = Carbon::now()->setDay(1)->diff($employee->last_invoice_generated_at->setDay(1));
                            $invoiceNumber = $employee->last_invoice_number + ($diff->m + $diff->y * 12);

                            return Input::make('employees[' . $employee->id . '][invoice_number]')
                                ->value($invoiceNumber)
                                ->type('number');
                        }
                    )
                ,
                TD::make('amount', __('Amount'))
                    ->render(
                        function (Employee $employee) {
                            return Input::make('employees[' . $employee->id . '][amount]')
                                ->value(100)
                                ->type('number');
                        }
                    )
                ,
                TD::make('selected', __('Select'))
                    ->render(fn($e) => CheckBox::make('employees[' . $e->id . '][selected]')->sendTrueOrFalse())
                ,
                TD::make('generate')
                    ->render(
                        fn($e) => Button::make(__('Generate'))
                            ->icon('arrow-down-circle')->type(Color::DEFAULT())
                            ->method('generate')
                            ->set('turbo', false)
                            ->parameters(['employees[' . $e->id . '][selected]' => 1])
                            ->set('formmethod', 'post')
                    )
                ,
                TD::make('edit')
                    ->render(
                        fn($e) => Link::make(__('Edit'))
                            ->route('platform.employee.edit', $e->id)
                            ->icon('pencil'),

                    )
                ,
            ]),
        ];
    }

    public function generate(GenerateRequest $request, InvoiceGenerator $invoiceGenerator)
    {
        $employeesData = $request->input('employees');
        $type = $request->input('invoice_type');
        $date = Carbon::parse($request->input('date'));

        if ($singleSelect = $request->query->all()['employees'] ?? false) {
            $employeesData[array_key_first($singleSelect)]['selected'] = '1';
        }
        // if no one is selected than everyone is selected
        if (array_sum(array_column($employeesData, 'selected'))) {
            $employeesData = array_filter($employeesData, fn($value) => $value['selected'] == '1');
        }

        $employeeIds = array_keys($employeesData);
        $employees = Employee::whereIn('id', $employeeIds)->get();

        if ($employees->count() == 1) {
            $employee = $employees->first();
            /** @var Employee $employee */
            $employeeData = $employeesData[$employee->id];

            $pdf = $invoiceGenerator->generate($employee, $type, $date, (int)$employeeData['invoice_number'], (int)$employeeData['amount']);

            $this->updateEmployee($employee, (int)$employeeData['invoice_number']);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->toString();
            }, $this->getPdfName($employee, $date), [
                'Content-Type' => 'application/pdf',
            ]);
        } else {

            $zipPath = $this->toZipArchive($employees, $employeesData, $invoiceGenerator, $type, $date);

            return response()->streamDownload(function () use ($zipPath) {
                return readfile($zipPath);
            }, 'invoices.zip', [
                'Content-Type' => 'application/zip',
            ]);
        }
    }

    protected function getPdfName(mixed $employee, Carbon $date): string
    {
        return $employee->full_name_en . '_' . $date->format('Md_y') . '.pdf';
    }

    /**
     * @param Collection<Employee> $employees
     * @param array $employeesData
     * @param InvoiceGenerator $invoiceGenerator
     * @param mixed $type
     * @param Carbon $date
     * @return string
     */
    protected function toZipArchive(Collection $employees, array $employeesData, InvoiceGenerator $invoiceGenerator, string $type, Carbon $date): string
    {
        $zipPath = tempnam('/tmp', 'zip');

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
            throw new RuntimeException('Zip issue');
        }

        foreach ($employees as $employee) {
            $employeeData = $employeesData[$employee->id];

            $pdf = $invoiceGenerator->generate($employee, $type, $date, (int)$employeeData['invoice_number'], (int)$employeeData['amount']);

            $this->updateEmployee($employee, (int)$employeeData['invoice_number']);

            $pdfPath = tempnam('/tmp', 'pdf');
            $handle = fopen($pdfPath, "w");
            fwrite($handle, $pdf->toString());
            fclose($handle);

            if (!$zip->addFile($pdfPath, $this->getPdfName($employee, $date))) {
                throw new RuntimeException('Fail add pdf to zip');
            }
        }

        $zip->close();

        return $zipPath;
    }

    protected function updateEmployee(Employee $employee, int $invoice_number): void
    {
        $employee->last_invoice_number = $invoice_number;
        $employee->last_invoice_generated_at = Carbon::now();
        $employee->save();
    }
}
