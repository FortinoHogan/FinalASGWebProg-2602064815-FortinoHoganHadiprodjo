<?php

namespace Database\Seeders;

use App\Models\Friend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Friend::create([
            'user_id' => 1,
            'friend_id' => 2
        ]);

        Friend::create([
            'user_id' => 1,
            'friend_id' => 3
        ]);
    }
}
