<?php

namespace Database\Seeders;

use App\Models\UserField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [1, 3, 5],
            5 => [2, 4, 6],
            6 => [3, 5, 7],
            7 => [4, 6, 8],
            8 => [5, 7, 9],
            9 => [1, 4, 7],
            10 => [2, 5, 8],
            11 => [3, 6, 9],
            12 => [1, 5, 9],
        ];

        foreach ($users as $userId => $fieldIds) {
            foreach ($fieldIds as $fieldId) {
                UserField::create([
                    'user_id' => $userId,
                    'field_of_work_id' => $fieldId,
                ]);
            }
        }
    }
}
