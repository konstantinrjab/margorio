<?php

declare(strict_types=1);

namespace App\Reimbursement\Orchid;

use App\Reimbursement\Model\Reimbursement;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ReimbursementListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'reimbursements' => Reimbursement::filters()
                ->with('employee')
                ->defaultSort('date', 'desc')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Reimbursement');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.reimbursement.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('reimbursements', [

                TD::make('employee_id', __('Employee'))
                    ->sort()
                    ->render(fn(Reimbursement $one) => $one->employee->full_name_en)
                    ->filter()
                ,

                TD::make('date', __('Date'))
                    ->sort()
                    ->render(fn(Reimbursement $one) => $one->date->format('Y-m'))
                    ->filter()
                ,

                TD::make('amount', __('Amount'))
                    ->sort()
                    ->render(fn(Reimbursement $one) => $one->amount)
                    ->filter()
                ,

                TD::make('approved', __('Approved'))
                    ->sort()
                    ->render(fn(Reimbursement $one) => $one->approved ? '<i class="text-success lead">●</i>' : '<i class="text-danger lead">●</i>')
                    ->filter()
                ,

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Reimbursement $one) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([

                                Link::make(__('See'))
                                    ->route('platform.reimbursement.show', $one->id)
                                    ->icon('eye'),

                                Link::make(__('Edit'))
                                    ->route('platform.reimbursement.edit', $one->id)
                                    ->icon('pencil'),

                                Button::make(__('Delete'))
                                    ->icon('trash')
                                    ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                    ->method('remove', [
                                        'id' => $one->id,
                                    ]),
                            ]);
                    }),
            ]),
        ];
    }

    public function remove(Reimbursement $one): void
    {
        $one->delete();

        Toast::info(__('Reimbursement was removed'));
    }
}
