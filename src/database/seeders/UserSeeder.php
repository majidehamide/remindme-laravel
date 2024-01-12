<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
                'name' => 'Alice',
                'email' => 'alice@mail.com',
                'password' => bcrypt("123456")
                ]
            );

        User::insert([
                'name' => 'Bob',
                'email' => 'bob@mail.com',
                'password' => bcrypt("123456") 
            ]
        );
    }
}
