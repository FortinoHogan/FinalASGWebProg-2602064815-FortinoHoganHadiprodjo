<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'sea-bear-1.png',
            'sea-bear-2.png',
            'sea-bear-3.png',
            'profile-1.png',
            'profile-2.png',
            'profile-3.png',
        ];

        foreach ($images as $image) {
            Avatar::create([
                'image' => file_get_contents(public_path('assets/img/' . $image)),
            ]);
        }
    }
}