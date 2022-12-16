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
    public function __construct(
        protected SalaryCalculator $salaryCalculator
    )
    {
    }

    public function query(): iterable
    {
        $date = request()->get('calculation_date');

        return [
            'employees' => Employee::filters()
                ->defaultSort('full_name_en')
                ->paginate(),
            'calculation_date' => $date
                ? Carbon::createFromFormat('Y-m', $date)
                : Carbon::now()->subMonth(),
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
                ->route('platform.salaryCalculation.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                DateTimer::make('calculation_date')
                    ->format('Y-m')
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
                TD::make('amount', __('Amount'))
                    ->sort()
                    ->render(fn(Employee $one) => $this->salaryCalculator->getAmount($one, $this->query()['calculation_date']))
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
                                    ->route('platform.salaryCalculation.show', $one->id)
                                    ->icon('eye'),

                                Link::make(__('Edit'))
                                    ->route('platform.salaryCalculation.edit', $one->id)
                                    ->icon('pencil'),
                            ]);
                    }),
            ]),
        ];
    }
}
