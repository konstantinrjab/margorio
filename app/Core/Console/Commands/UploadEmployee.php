<?php

namespace App\Core\Console\Commands;

use App\Employee\Model\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UploadEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload-employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload employee from csv file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = __DIR__ . '/employees.csv';
        $employees = $this->readCSV($path);

        foreach ($employees as $employee) {
            Employee::create([
                'full_name_en' => $employee['name_en'],
                'full_name_uk' => $employee['name_uk'],
                'tax_number'   => $employee['tax_number'],
                'invoice_data' => [
                    'full'      => [
                        'address_en'      => $employee['address_en'],
                        'address_uk'      => $employee['address_uk'],
                        'bank_details_en' => $employee['bank_details_en'],
                        'bank_details_uk' => $employee['bank_details_uk'],
                        'subject_en'      => $employee['subject_en'],
                        'subject_uk'      => $employee['subject_uk'],
                        'description_en'  => $employee['description_en'],
                        'description_uk'  => $employee['description_uk'],
                        'number'          => $employee['invoice_number'],
                        'generated_at'    => Carbon::now()->subMonth(),
                    ],
                    'probation' => [
                        'address_en'      => $employee['address_en'],
                        'bank_details_en' => $employee['bank_details_en'],
                        'subject_en'      => $employee['subject_en'],
                        'description_en'  => $employee['description_en'],
                        'number'          => $employee['invoice_number'],
                        'generated_at'    => Carbon::now()->subMonth(),
                    ],
                ],
            ]);
        }

        return 0;
    }

    private function readCSV(string $path): array
    {
        $file = fopen($path, 'r');

        $rows = [];
        while ($row = fgetcsv($file)) {
            $rows[] = $row;
        }

        $header = array_shift($rows);
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }
}
