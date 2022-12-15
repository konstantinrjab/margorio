<?php

declare(strict_types=1);

namespace App\Reimbursement\Orchid;

use App\Employee\Model\Employee;
use App\Reimbursement\Model\Reimbursement;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReimbursementEditScreen extends Screen
{
    public Reimbursement $reimbursement;

    public function query(Reimbursement $reimbursement): iterable
    {
        return [
            'reimbursement' => $reimbursement,
        ];
    }

    public function name(): ?string
    {
        return ($this->reimbursement->exists ? __('Edit') : __('Create')) . ': ' . __('Reimbursement');
    }

    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->reimbursement->exists),

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
                Relation::make('reimbursement.employee_id')
                    ->required()
                    ->fromModel(Employee::class, 'full_name_en')
                    ->title(__('Employee'))
                ,

                Input::make('reimbursement.description')
                    ->required()
                    ->title(__('Description')),

                Input::make('reimbursement.amount')
                    ->type('number')
                    ->required()
                    ->title(__('Amount')),

                DateTimer::make('reimbursement.date')
                    ->format('Y-m-d')
                    ->required()
                    ->title('Date'),

                CheckBox::make('reimbursement.approved')
                    ->sendTrueOrFalse()
                    ->title('Approved'),
            ]),
        ];
    }

    public function save(Reimbursement $one, Request $request)
    {
        $data = $request->get('reimbursement');

        $one
            ->fill($data)
            ->save();

        Toast::info(__('Reimbursement was saved.'));

        return redirect()->route('platform.reimbursement.list');
    }

    public function remove(Reimbursement $one)
    {
        $one->delete();

        Toast::info(__('Reimbursement was removed'));

        return redirect()->route('platform.reimbursement.list');
    }
}
