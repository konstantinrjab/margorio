<?php

declare(strict_types=1);

namespace App\Employee\Orchid;

use App\Employee\Model\Employee;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeEditScreen extends Screen
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
        return ($this->employee->exists ? __('Edit') : __('Create')) . ': ' . __('Employee');
    }

    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->employee->exists),

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
                Group::make([
                    Input::make('employee.full_name_en')
                        ->required()
                        ->title(__('Full Name EN')),
                    Input::make('employee.full_name_uk')
                        ->required()
                        ->title(__('Full Name UK')),
                ]),
            ]),

            Layout::tabs([
                'Full Invoice'      => Layout::rows([
                    Group::make([
                        Input::make('employee.invoice_data.full.bank_details_en')
                            ->required()
                            ->title(__('Bank Details EN')),
                        Input::make('employee.invoice_data.full.bank_details_uk')
                            ->required()
                            ->title(__('Bank Details UK')),
                    ]),
                    Group::make([
                        Input::make('employee.invoice_data.full.description_en')
                            ->required()
                            ->title(__('Description EN')),
                        Input::make('employee.invoice_data.full.description_uk')
                            ->required()
                            ->title(__('Description UK')),
                    ]),
                    Group::make([
                        Input::make('employee.invoice_data.full.address_en')
                            ->required()
                            ->title(__('Address EN')),
                        Input::make('employee.invoice_data.full.address_uk')
                            ->required()
                            ->title(__('Address UK')),
                    ]),
                    Group::make([
                        Input::make('employee.invoice_data.full.subject_en')
                            ->required()
                            ->title(__('Subject EN')),
                        Input::make('employee.invoice_data.full.subject_uk')
                            ->required()
                            ->title(__('Subject UK')),
                    ]),
                ]),
                'Probation Invoice' => Layout::rows([
                    Input::make('employee.invoice_data.probation.bank_details_en')
                        ->required()
                        ->title(__('Bank Details EN')),
                    Input::make('employee.invoice_data.probation.description_en')
                        ->required()
                        ->title(__('Description EN')),
                    Input::make('employee.invoice_data.probation.address_en')
                        ->required()
                        ->title(__('Address EN')),
                    Input::make('employee.invoice_data.full.subject_en')
                        ->required()
                        ->title(__('Subject EN')),
                ]),
            ]),

            Layout::rows([
                Input::make('employee.tax_number')
                    ->required()
                    ->title(__('Tax Number')),

                Input::make('employee.last_invoice_number')
                    ->required()
                    ->value(1)
                    ->type('number')
                    ->title(__('Last Invoice Number')),

                DateTimer::make('employee.last_invoice_generated_at')
                    ->enableTime(false)
                    ->required()
                    ->format24hr()
                    ->allowInput()
                    ->title(__('Invoice Generated At')),
            ]),

        ];
    }

    public function save(Employee $one, Request $request)
    {
        $data = $request->get('employee');

        $one
            ->fill($data)
            ->save();

        Toast::info(__('Employee was saved.'));

        return redirect()->route('platform.employee.list');
    }

    public function remove(Employee $one)
    {
        $one->delete();

        Toast::info(__('Employee was removed'));

        return redirect()->route('platform.employee.list');
    }
}
