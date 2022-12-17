<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class SalaryCalculationListScreen extends Screen
{
    public Carbon $calculationDate;

    public function __construct(
        protected SalaryCalculator $salaryCalculator
    )
    {
        $calculationDate = request()->get('calculation_date');
        $this->calculationDate = $calculationDate
            ? Carbon::createFromFormat('Y-m', $calculationDate)
            : Carbon::now()->subMonth();
    }

    public function query(): iterable
    {
        return [
            'employees' => Employee::filters()
                ->with(['reports', 'reimbursements'])
                ->defaultSort('full_name_en')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Salary Calculation');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.salaryCalculation.create', ['calculation_date' => $this->calculationDate->format('Y-m')]),
        ];
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

                Button::make(__('Apply'))
                    ->icon('check')
                    ->type(Color::DEFAULT())
                    ->set('formmethod', 'get'),
            ]),

            Layout::table('employees', [

                TD::make('id', __('Employee'))
                    ->sort()
                    ->render(fn(Employee $one) => $one->full_name_en)
                    ->filter()
                ,
                TD::make('rate', __('Rate'))
                    ->sort()
                    ->render(fn(Employee $one) => $one->rate)
                    ->filter()
                ,
                TD::make('working_days', __('Working Days'))
                    ->sort()
                    ->render(fn(Employee $one) => $this->salaryCalculator->calculate($one, $this->calculationDate)['working_days'])
                    ->filter()
                ,
                TD::make('days_worked', __('Days Worked'))
                    ->sort()
                    ->render(fn(Employee $one) => $this->salaryCalculator->calculate($one, $this->calculationDate)['days_worked'])
                    ->filter()
                ,
                TD::make('reimbursements_total', __('Reimbursements'))
                    ->sort()
                    ->render(fn(Employee $one) => $this->salaryCalculator->calculate($one, $this->calculationDate)['reimbursements_total'])
                    ->filter()
                ,
                TD::make('amount', __('Amount'))
                    ->sort()
                    ->render(fn(Employee $one) => $this->salaryCalculator->calculate($one, $this->calculationDate)['amount'])
                    ->filter()
                ,

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Employee $one) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([

                                Link::make(__('See'))
                                    ->route('platform.salaryCalculation.show', [$one->id, 'calculation_date' => $this->calculationDate->format('Y-m')])
                                    ->icon('eye'),

                                Link::make(__('Edit'))
                                    ->route('platform.salaryCalculation.edit', [$one->id, 'calculation_date' => $this->calculationDate->format('Y-m')])
                                    ->icon('pencil'),
                            ]);
                    }),
            ]),
        ];
    }
}
