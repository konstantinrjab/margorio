<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Model\SalaryCalculation;
use App\SalaryCalculation\Orchid\Request\SalaryCalculationRequest;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SalaryCalculationEditScreen extends Screen
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
        return ($this->salaryCalculation->exists ? __('Edit') : __('Create')) . ': ' . __('Salary Calculation');
    }

    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->salaryCalculation->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Relation::make('employee_id')
                    ->required()
                    ->fromModel(Employee::class, 'full_name_en')
                    ->value($this->salaryCalculation->employee_id ?? null)
                    ->title(__('Employee'))
                ,

                Input::make('working_days')
                    ->type('number')
                    ->title(__('Working Days')),

                Input::make('days_worked')
                    ->type('number')
                    ->title(__('Days Worked')),

                DateTimer::make('date')
                    ->format('Y-m-d')
                    ->value(date('Y-m-d'))
                    ->required()
                    ->title('Date'),

            ]),
        ];
    }

    public function save(SalaryCalculation $salaryCalculation, SalaryCalculationRequest $request)
    {
        $data = $request->validated();

        $salaryCalculation
            ->fill($data)
            ->save();

        Toast::info(__('Salary Calculation was saved.'));

        return redirect()->route('platform.salaryCalculation.list');
    }

    public function remove(SalaryCalculation $one)
    {
        $one->delete();

        Toast::info(__('Salary Calculation was removed'));

        return redirect()->route('platform.salaryCalculation.list');
    }
}
