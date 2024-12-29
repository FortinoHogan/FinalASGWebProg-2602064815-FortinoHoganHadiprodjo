<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Fortino Hogan Hadiprodjo',
            'email' => 'fortinohogan@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 1,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081548000960',
            'experience' => 3,
        ]);

        User::create([
            'name' => 'Fajar Pratama',
            'email' => 'fajarpratama@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 2,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345678',
            'experience' => 2,
        ]);

        User::create([
            'name' => 'Valerie Regina',
            'email' => 'valerieregina@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'female',
            'profession_id' => 5,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '082312345678',
            'experience' => 1,
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alicejohnson@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'female',
            'profession_id' => 1,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345685',
            'experience' => 4,
        ]);
        
        User::create([
            'name' => 'Bob Williams',
            'email' => 'bobwilliams@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 2,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345686',
            'experience' => 6,
        ]);
        
        User::create([
            'name' => 'Charlie Davis',
            'email' => 'charliedavis@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 3,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345687',
            'experience' => 5,
        ]);
        
        User::create([
            'name' => 'Diana Thompson',
            'email' => 'dianathompson@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'female',
            'profession_id' => 4,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345688',
            'experience' => 2,
        ]);
        
        User::create([
            'name' => 'Edward Garcia',
            'email' => 'edwardgarcia@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 5,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345689',
            'experience' => 7,
        ]);
        
        User::create([
            'name' => 'Fiona Martinez',
            'email' => 'fionamartinez@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'female',
            'profession_id' => 1,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345690',
            'experience' => 3,
        ]);
        
        User::create([
            'name' => 'George Brown',
            'email' => 'georgebrown@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 2,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345691',
            'experience' => 4,
        ]);
        
        User::create([
            'name' => 'Hannah Clark',
            'email' => 'hannahclark@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'female',
            'profession_id' => 3,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345692',
            'experience' => 1,
        ]);
        
        User::create([
            'name' => 'Isaac Lewis',
            'email' => 'isaaclewis@gmail.com',
            'password' => Hash::make('asdasd123'),
            'gender' => 'male',
            'profession_id' => 4,
            'linkedin_username' => 'https://www.linkedin.com/in/fortino-hogan-hadiprodjo-7006b01a7/',
            'phone_number' => '081212345693',
            'experience' => 6,
        ]);
        
    }
}
