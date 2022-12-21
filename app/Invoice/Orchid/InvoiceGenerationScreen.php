<?php

declare(strict_types=1);

namespace App\Invoice\Orchid;

use Carbon\Carbon;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class InvoiceGenerationScreen extends Screen
{
    public function __construct(
    )
    {
        $this->calculationDate = request()->get('calculation_date')
            ? Carbon::parse(request()->get('calculation_date'))->subMonth()
            : Carbon::now()->subMonth();
    }

    public function query(): iterable
    {
        return [];
    }

    public function name(): ?string
    {
        return __('Invoices');
    }

    public function layout(): iterable
    {
        return [
            Layout::view('invoice.generation'),
        ];
    }
}
