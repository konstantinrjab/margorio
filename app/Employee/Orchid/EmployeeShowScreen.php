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
                Sight::make('address_en', 'Address EN'),
                Sight::make('address_uk', 'Address UK'),
                Sight::make('bank_details_en', 'Bank Details EN'),
                Sight::make('bank_details_uk', 'Bank Details UK'),
                Sight::make('invoice_subject_en', 'Invoice Subject EN'),
                Sight::make('invoice_subject_uk', 'Invoice Subject UK'),
                Sight::make('invoice_description_en', 'Invoice Description EN'),
                Sight::make('invoice_description_uk', 'Invoice Description UK'),
                Sight::make('invoice_description_uk', 'Invoice Description UK'),
                Sight::make('last_invoice_number', 'Last Invoice Number'),
                Sight::make('last_invoice_generated_at', 'Last Invoice Generated At')->render(fn($e) => $e->last_invoice_generated_at->format('Y-m-d')),

            ]),
        ];
    }
}
