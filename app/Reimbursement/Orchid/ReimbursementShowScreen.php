<?php

declare(strict_types=1);

namespace App\Reimbursement\Orchid;

use App\Reimbursement\Model\Reimbursement;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class ReimbursementShowScreen extends Screen
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
        return __('See') . ': ' . __('Reimbursement');
    }

    public function commandBar(): iterable
    {
        return [

            Link::make(__('Edit'))
                ->icon('pencil')
                ->route('platform.reimbursement.edit', $this->reimbursement->id),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('reimbursement', [

                Sight::make('employee', 'Employee')->render(fn($one) => $one->employee->full_name_en),
                Sight::make('date', 'Date')->render(fn($one) => $one->date->format('Y-m')),

            ]),
        ];
    }
}
