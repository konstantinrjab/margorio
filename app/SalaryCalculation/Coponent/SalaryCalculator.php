<?php

namespace App\SalaryCalculation\Coponent;

use App\Employee\Model\Employee;
use App\Reimbursement\Model\Reimbursement;
use App\SalaryCalculation\Model\EmployeeReport;
use Carbon\Carbon;

class SalaryCalculator
{
    /**
     * @param Employee $employee
     * @param Carbon $date
     * @return array{
     *     amount: int,
     *     reimbursements: Reimbursement[],
     *     reimbursements_total: int,
     *     working_days: int,
     *     days_worked: int
     * }
     */
    public function calculate(Employee $employee, Carbon $date): array
    {
        /** @var EmployeeReport $report */
        $report = $employee->reports
            ->first(fn(EmployeeReport $e) => $e->date->format('Y-m') == $date->format('Y-m'));
        $reimbursements = $employee->reimbursements
            ->filter(fn(Reimbursement $e) => $e->date->format('Y-m') == $date->format('Y-m'));

        $reimbursementsTotal = $reimbursements->sum(fn(Reimbursement $e) => $e->amount);

        if (!$report) {
            $amount = $employee->rate;
        } else {
            $amount = round($report->working_days / $report->days_worked * $employee->rate);
        }

        $amount += $reimbursementsTotal;

        return [
            'amount'               => $amount,
            'reimbursements'       => $reimbursements,
            'reimbursements_total' => $reimbursementsTotal,
            'working_days'         => $report->working_days ?? null,
            'days_worked'          => $report->days_worked ?? null,
            // TODO: overtimes
        ];
    }
}
