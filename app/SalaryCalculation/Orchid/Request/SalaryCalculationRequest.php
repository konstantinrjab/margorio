<?php

namespace App\SalaryCalculation\Orchid\Request;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaryCalculationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_id'  => ['required', 'exists:employees,id'],
            'days_worked'  => [
                'sometimes',
                'required_with:"working_days"',
                'nullable',
                'int',
                'max:31'
            ],
            'working_days' => ['sometimes', 'required_with:"days_worked"', 'nullable', 'int', 'max:31'],
            'date'         => [
                'required',
                'date',
                'date_format:Y-m-d',
                Rule::unique('salary_calculations', 'date')
                    ->where(function (Builder $query) {
                        $date = $this->get('date');

                        return $query->where([
                            'deleted_at'  => null,
                            'employee_id' => $this->get('employee_id'),
                        ])
                            ->whereMonth('date', '=', Carbon::parse($date)->month);
                    })
                    ->ignore($this->one instanceof Model ? $this->one : null) // on update
                ,
            ],
        ];
    }
}
