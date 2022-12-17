<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use Carbon\Carbon;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SalaryCalculationShowScreen extends Screen
{
    public Employee $employee;
    public Carbon $calculationDate;

    public function __construct(
        protected SalaryCalculator $salaryCalculator
    )
    {
        $calculationDate = request()->get('calculation_date');
        if (!$calculationDate) {
            throw new NotFoundHttpException();
        }

        $this->calculationDate = Carbon::createFromFormat('Y-m', $calculationDate);
    }

    public function query(Employee $employee): iterable
    {
        return [
            'employee' => $employee,
        ];
    }

    public function name(): ?string
    {
        return __('See') . ': ' . __('Salary Calculation');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Edit'))
                ->icon('pencil')
                ->route('platform.salaryCalculation.edit', [$this->employee->id, 'calculation_date' => $this->calculationDate->format('Y-m')]),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $data = $this->salaryCalculator->calculate($this->employee, $this->calculationDate);

        return [
            Layout::legend('employee', [

                Sight::make('full_name_en', 'Full Name'),
                Sight::make('rate', 'Rate'),
                Sight::make('working_days', 'Working Days')->render(fn(Employee $one) => $data['working_days']),
                Sight::make('days_worked', 'Days Worked')->render(fn(Employee $one) => $data['days_worked']),
                Sight::make('amount', 'Amount')->render(fn(Employee $one) => $data['amount']),

            ]),
        ];
    }
}
