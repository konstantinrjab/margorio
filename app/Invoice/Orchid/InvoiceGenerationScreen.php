<?php

declare(strict_types=1);

namespace App\Invoice\Orchid;

use App\Employee\Model\Employee;
use App\Invoice\Components\InvoiceService;
use App\Invoice\Orchid\Request\GenerateInvoiceRequest;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use Carbon\Carbon;
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

class InvoiceGenerationScreen extends Screen
{
    protected Carbon $calculationDate;

    public function __construct(
        protected InvoiceService $invoiceService,
        protected SalaryCalculator $salaryCalculator,
    )
    {
        $this->calculationDate = request()->get('calculation_date')
            ? Carbon::parse(request()->get('calculation_date'))->subMonth()
            : Carbon::now()->subMonth();
    }

    public function query(): iterable
    {
        return [
            'employees' => Employee::filters()
                ->defaultSort('full_name_en')
                ->get(),
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
                DateTimer::make('calculation_date')
                    ->format('Y-m')
                    ->value($this->calculationDate->format('Y-m'))
                    ->required()
                    ->title('Calculation Date'),

                Button::make(__('Select'))
                    ->icon('arrow-down-circle')->type(Color::DEFAULT())
                    ->formmethod('get')
                    ->set('turbo', false)
                ,
            ]),

            Layout::rows([
                Group::make([

                    DateTimer::make('date')
                        ->format('Y-m-d')
                        ->value(date('Y-m-d'))
                        ->required()
                        ->title('Date'),

                    Select::make(__('invoice_type'))
                        ->options([InvoiceService::TYPE_FULL => 'Full', InvoiceService::TYPE_PROBATION => 'Probation'])
                        ->value(1)
                        ->required()
                        ->title('Invoice Type'),
                ]),

                Button::make(__('Generate Selected'))
                    ->icon('arrow-down-circle')->type(Color::DEFAULT())
                    ->method('generate')
                    ->set('turbo', false)
                ,
            ]),

            Layout::table('employees', [

                TD::make('full_name_en', __('Full Name EN'))
                    ->sort()
                    ->filter()
                ,
                TD::make('number full', __('Number Full'))
                    ->render(fn(Employee $e) => Input::make("employees[$e->id][" . InvoiceService::TYPE_FULL . "][number]")
                        ->value($this->invoiceService->getInvoiceNumber($e, InvoiceService::TYPE_FULL))
                        ->type('number')
                    )
                ,
                TD::make('number probation', __('Number Probation'))
                    ->render(fn(Employee $e) => Input::make("employees[$e->id][" . InvoiceService::TYPE_PROBATION . "][number]")
                        ->value($this->invoiceService->getInvoiceNumber($e, InvoiceService::TYPE_PROBATION))
                        ->type('number')
                    )
                ,
                TD::make('amount', __('Amount'))
                    ->render(
                        function (Employee $employee) {
                            return Input::make("employees[$employee->id][amount]")
                                ->value($this->salaryCalculator->calculate($employee, $this->calculationDate)['amount'])
                                ->type('number');
                        }
                    )
                ,
                TD::make('selected', __('Select'))
                    ->render(fn(Employee $employee) => CheckBox::make("employees[$employee->id][selected]")->sendTrueOrFalse())
                ,
                TD::make('generate')
                    ->render(
                        fn(Employee $employee) => Button::make(__('Generate'))
                            ->icon('arrow-down-circle')->type(Color::DEFAULT())
                            ->method('generate')
                            ->set('turbo', false)
                            ->parameters(["employees[$employee->id][selected]" => 1])
                    )
                ,
                TD::make('Employee')
                    ->render(
                        fn(Employee $e) => Link::make(__('Employee'))
                            ->route('platform.employee.edit', $e->id)
                            ->icon('pencil'),
                    )
                ,
                TD::make('Calculation')
                    ->render(
                        fn(Employee $e) => Link::make(__('Calculation'))
                            ->route('platform.salaryCalculation.edit', [$e->id, 'calculation_date' => $this->calculationDate->format('Y-m')])
                            ->icon('pencil'),
                    )
                ,
            ]),
        ];
    }

    public function generate(GenerateInvoiceRequest $request, InvoiceService $invoiceService)
    {
        $employeesData = $this->prepareDataForGeneration($request);

        $pdfs = $invoiceService->generate(
            $employeesData,
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

    /**
     * @param GenerateInvoiceRequest $request
     * @return array{id: int, amount: int, number: int}
     */
    protected function prepareDataForGeneration(GenerateInvoiceRequest $request): array
    {
        $employeesData = $request->input('employees');
        $type = $request->input('invoice_type');

        if ($singleSelect = $request->query->all()['employees'] ?? false) {
            $selectedId = array_key_first($singleSelect);
            $employeesData = [$selectedId => $employeesData[$selectedId]];
            $employeesData[$selectedId]['selected'] = '1';
        }

        $noneSelected = !array_sum(array_column($employeesData, 'selected'));
        $result = [];

        foreach ($employeesData as $id => $employeeData) {
            if ($noneSelected || $employeeData['selected']) {
                $result[] = [
                    'id'     => (int)$id,
                    'amount' => (int)$employeeData['amount'],
                    'number' => (int)$employeeData[$type]['number'],
                ];
            }
        }

        return $result;
    }
}
