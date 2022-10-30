<?php

declare(strict_types=1);

namespace App\Employee\Orchid;

use App\Employee\Model\Employee;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class EmployeeShowScreen extends Screen
{
    public Employee $employee;

    public function query(Employee $employee): iterable
    {
        return [
            'employee' => $employee,
        ];
    }

    public function name(): ?string
    {
        return __('See') . ': ' . __('Employee');
    }

    public function commandBar(): iterable
    {
        return [

            Link::make(__('Edit'))
                ->icon('pencil')
                ->route('platform.employee.edit', $this->employee->id),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('employee', [

                Sight::make('full_name_en', 'Full Name EN'),
                Sight::make('full_name_uk', 'Full Name UK'),
                Sight::make('tax_number', 'Tax Number'),
                Sight::make('invoice_data', 'Invoice Data')->render(fn ($e) => '<pre>' . json_encode($e->invoice_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . '</pre>'),

            ]),
        ];
    }
}
