<?php

declare(strict_types=1);

namespace App\Employee\Orchid;

use App\Employee\Model\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'employees' => Employee::filters()
                ->orderBy('active', 'desc')
                ->orderBy('full_name_en')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Employees');
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.employee.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('employees', [

                TD::make('full_name_en', __('Full Name EN'))
                    ->sort()
                    ->render(function(Employee $one) {
                        return $one->active
                            ? $one->full_name_en
                            : "<span class='text-secondary'>{$one->full_name_en}</span>";
                    })
                    ->filter()
                ,
                TD::make('full_name_uk', __('Full Name UK'))
                    ->sort()
                    ->render(function(Employee $one) {
                        return $one->active
                            ? $one->full_name_uk
                            : "<span class='text-secondary'>{$one->full_name_uk}</span>";
                    })
                    ->filter()
                ,
                TD::make('tax_number', __('Tax Number'))
                    ->sort()
                    ->filter()
                ,

                TD::make(__('Actions'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Employee $one) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([

                                Link::make(__('See'))
                                    ->route('platform.employee.show', $one->id)
                                    ->icon('eye'),

                                Link::make(__('Edit'))
                                    ->route('platform.employee.edit', $one->id)
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

    public function remove(Employee $one): void
    {
        $one->active = false;
        $one->save();

        Toast::info(__('Employee was deactivated'));
    }
}
