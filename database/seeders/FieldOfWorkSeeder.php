<?php

namespace Database\Seeders;

use App\Models\FieldOfWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'Software Development',
            'Graphic Design',
            'Marketing',
            'Data Analysis',
            'Accounting',
            'Project Management',
            'Customer Support',
            'Engineering',
            'Sales',
        ];

        foreach ($fields as $field) {
            FieldOfWork::create(['name' => $field]);
        }
    }
}
