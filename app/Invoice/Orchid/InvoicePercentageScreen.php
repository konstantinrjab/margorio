<?php

declare(strict_types=1);

namespace App\Invoice\Orchid;

use App\Employee\Model\Employee;
use App\Invoice\Components\InvoiceGenerator;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class InvoicePercentageScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'employees' => Employee::all(),
        ];
    }

    public function name(): ?string
    {
        return __('Invoice Percentage');
    }

    public function layout(): iterable
    {
        return [

            Layout::rows([

                Select::make(__('Employee'))
                    ->options([InvoiceGenerator::TYPE_FULL => 'Full', InvoiceGenerator::TYPE_PROBATION => 'Probation'])
                    ->required()
                    ->title('Employee'),

                Input::make('percentage')
                    ->required()
                    ->type('number')
                    ->title('Percentage'),

                Button::make(__('Sumbit'))
                    ->icon('check')->type(Color::DEFAULT())
                    ->method('generate')
                    ->set('turbo', false)
                    ->set('formmethod', 'post'),

            ]),
        ];
    }
}
