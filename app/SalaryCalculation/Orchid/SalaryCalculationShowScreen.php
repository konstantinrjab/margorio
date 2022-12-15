<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\SalaryCalculation\Model\SalaryCalculation;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class SalaryCalculationShowScreen extends Screen
{
    public SalaryCalculation $salaryCalculation;

    public function query(SalaryCalculation $salaryCalculation): iterable
    {
        return [
            'salaryCalculation' => $salaryCalculation,
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
                ->route('platform.salaryCalculation.edit', $this->salaryCalculation->id),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('salaryCalculation', [

                Sight::make('employee', 'Employee')->render(fn($one) => $one->employee->full_name_en),
                Sight::make('date', 'Date')->render(fn($one) => $one->date->format('Y-m')),

            ]),
        ];
    }
}
