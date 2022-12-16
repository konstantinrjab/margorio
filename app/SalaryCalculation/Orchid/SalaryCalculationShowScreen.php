<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class SalaryCalculationShowScreen extends Screen
{
    public Employee $employee;

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
                ->route('platform.salaryCalculation.edit', $this->employee->id),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('employee', [

                Sight::make('full_name_en', 'Full Name'),

            ]),
        ];
    }
}
