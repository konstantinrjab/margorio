<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Employee\Model\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('orchid:admin', ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => '123123']);

        Employee::factory(5)->create();
    }
}
