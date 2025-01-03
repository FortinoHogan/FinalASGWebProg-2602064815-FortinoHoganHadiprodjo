<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProfessionSeeder::class,
            UserSeeder::class,
            FieldOfWorkSeeder::class,
            UserFieldSeeder::class,
            FriendSeeder::class,
            MessageSeeder::class,
            NotificationSeeder::class,
            AvatarSeeder::class,
        ]);
    }
}
