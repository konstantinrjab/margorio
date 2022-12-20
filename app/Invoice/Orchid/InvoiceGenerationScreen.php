<?php

declare(strict_types=1);

namespace App\Invoice\Orchid;

use App\Employee\Model\Employee;
use App\Invoice\Components\InvoiceService;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use Carbon\Carbon;
use Orchid\Screen\Screen;
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
            Layout::view('invoice.generation'),
        ];
    }
}
