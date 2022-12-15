<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\SalaryCalculation\Model\SalaryCalculation;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SalaryCalculationListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'salaryCalculations' => SalaryCalculation::filters()
                ->with('employee')
                ->defaultSort('date', 'desc')
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
                ->route('platform.salaryCalculation.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('salaryCalculations', [

                TD::make('employee_id', __('Employee'))
                    ->sort()
                    ->render(fn(SalaryCalculation $one) => $one->employee->full_name_en)
                    ->filter()
                ,
                TD::make('date', __('Date'))
                    ->sort()
                    ->render(fn(SalaryCalculation $one) => $one->date->format('Y-m'))
                    ->filter()
                ,

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (SalaryCalculation $one) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([

                                Link::make(__('See'))
                                    ->route('platform.salaryCalculation.show', $one->id)
                                    ->icon('eye'),

                                Link::make(__('Edit'))
                                    ->route('platform.salaryCalculation.edit', $one->id)
                                    ->icon('pencil'),

                                Button::make(__('Delete'))
                                    ->icon('trash')
                                    ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                    ->method('remove', [
                                        'id' => $one->id,
                                    ]),
                            ]);
                    }),
            ]),
        ];
    }

    public function remove(SalaryCalculation $one): void
    {
        $one->delete();

        Toast::info(__('Salary Calculation was removed'));
    }
}
