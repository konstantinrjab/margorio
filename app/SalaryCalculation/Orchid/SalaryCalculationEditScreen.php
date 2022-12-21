<?php

declare(strict_types=1);

namespace App\SalaryCalculation\Orchid;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Coponent\SalaryCalculator;
use App\SalaryCalculation\Model\EmployeeReport;
use App\SalaryCalculation\Orchid\Request\SalaryCalculationRequest;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SalaryCalculationEditScreen extends Screen
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
        return ($this->employee->exists ? __('Edit') : __('Create')) . ': ' . __('Salary Calculation');
    }

    public function commandBar(): iterable
    {
        return [

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
        $data = $this->salaryCalculator->calculate($this->employee, $this->calculationDate);

        return [
            Layout::rows([
                Select::make('full_name_en')
                    ->disabled($this->employee->exists)
                    ->value($this->employee->id)
                    ->options(Employee::all()->keyBy('id')->map(fn($e) => $e->full_name_en))
                    ->title(__('Employee'))
                ,
                DateTimer::make('date')
                    ->required()
                    ->format('Y-m')
                    ->disabled()
                    ->value($this->calculationDate->format('Y-m'))
                    ->title('Date')
                ,
                Input::make('working_days')
                    ->type('number')
                    ->value($data['working_days'])
                    ->title(__('Working Days'))
                ,
                Input::make('days_worked')
                    ->type('number')
                    ->value($data['days_worked'])
                    ->title(__('Days Worked'))
                ,
                Matrix::make('reimbursements')
                    ->columns(['description', 'amount'])
                    ->value($this->salaryCalculator->calculate($this->employee, $this->calculationDate)['reimbursements'])
                    ->title(__('Reimbursements'))
                ,
            ]),
        ];
    }

    public function save(SalaryCalculationRequest $request)
    {
        $data = $request->validated();

        $one
            ->fill($data)
            ->save();

        Toast::info(__('Salary Calculation was saved.'));

        return redirect()->route('platform.salaryCalculation.list');
    }
}
