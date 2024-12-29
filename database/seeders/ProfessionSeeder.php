<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profession::create(['name' => 'Software Developer']);
        Profession::create(['name' => 'Graphic Designer']);
        Profession::create(['name' => 'Project Manager']);
        Profession::create(['name' => 'Customer Support']);
        Profession::create(['name' => 'Sales']);
    }
}
