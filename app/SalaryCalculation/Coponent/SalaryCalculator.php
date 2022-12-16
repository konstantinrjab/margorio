<?php

namespace App\SalaryCalculation\Coponent;

use App\Employee\Model\Employee;
use App\SalaryCalculation\Model\EmployeeReport;
use Carbon\Carbon;

class SalaryCalculator
{
    protected array $employeeDataCache = [];

    public function getAmount(Employee $employee, Carbon $date): int
    {
        $salaryCalculation = $this->getSalaryCalculation($employee, $date);

        $salary = $employee->rate;
//        if (!$salaryCalculation) {
//        }

        // TODO
        return $salary;
//        return $salaryCalculation->working_days / $salaryCalculation->days_worked * $employee->rate;
    }

    protected function getSalaryCalculation(Employee $employee, Carbon $date): ?EmployeeReport
    {
        if (isset($this->employeeDataCache[$employee->id])) {
            return $this->employeeDataCache[$employee->id];
        }

        $this->employeeDataCache[$employee->id] = EmployeeReport::where([
            'employee_id' => $employee->id,
        ])
            ->whereMonth('date', $date)
            ->first();

        return $this->employeeDataCache[$employee->id];
    }
}
