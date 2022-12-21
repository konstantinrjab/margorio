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
                Input::make('employee.tax_number')
                    ->required()
                    ->title(__('Tax Number')),
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
                    Input::make('employee.invoice_data.probation.number')
                        ->type('number')
                        ->title(__('Last Number')),
                    DateTimer::make('employee.invoice_data.full.generated_at')
                        ->enableTime(false)
                        ->format('Y-m-d')
                        ->allowInput()
                        ->title(__('Generated At')),
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
                    Input::make('employee.invoice_data.probation.subject_en')
                        ->required()
                        ->title(__('Subject EN')),
                    Input::make('employee.invoice_data.probation.number')
                        ->type('number')
                        ->title(__('Last Number')),
                    DateTimer::make('employee.invoice_data.probation.generated_at')
                        ->enableTime(false)
                        ->format('Y-m-d')
                        ->allowInput()
                        ->title(__('Generated At')),
                ]),
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
        $one->active = false;
        $one->save();

        Toast::info(__('Employee was deactivated'));

        return redirect()->route('platform.employee.list');
    }
}
