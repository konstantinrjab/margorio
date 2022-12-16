<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Model\EmployeeReport;
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
    public EmployeeReport $employeeReport;

    public function query(EmployeeReport $employeeReport): iterable
    {
        return [
            'employeeReport' => $employeeReport,
        ];
    }

    public function name(): ?string
    {
        return ($this->employeeReport->exists ? __('Edit') : __('Create')) . ': ' . __('Salary Calculation');
    }

    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->employeeReport->exists),

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
                    ->value($this->employeeReport->employee_id ?? null)
                    ->title(__('Employee'))
                ,

                Input::make('working_days')
                    ->type('number')
                    ->value($this->employeeReport->working_days ?? null)
                    ->title(__('Working Days')),

                Input::make('days_worked')
                    ->type('number')
                    ->value($this->employeeReport->days_worked ?? null)
                    ->title(__('Days Worked')),

                DateTimer::make('date')
                    ->format('Y-m-d')
                    ->value($this->employeeReport->date ?? null)
                    ->required()
                    ->title('Date'),

            ]),
        ];
    }

    public function save(EmployeeReport $one, SalaryCalculationRequest $request)
    {
        $data = $request->validated();

        $one
            ->fill($data)
            ->save();

        Toast::info(__('Salary Calculation was saved.'));

        return redirect()->route('platform.salaryCalculation.list');
    }

    public function remove(EmployeeReport $one)
    {
        $one->delete();

        Toast::info(__('Salary Calculation was removed'));

        return redirect()->route('platform.salaryCalculation.list');
    }
}
