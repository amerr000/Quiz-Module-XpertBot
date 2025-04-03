<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            "full_name"=>"Amer Reslan",
            "email"=>"amerreslan13@gmail.com",
            "password"=>"12345678"
        ]);
        User::create([
            "full_name"=>"Jawdat Reslan",
            "email"=>"jawdatreslan@gmail.com",
            "password"=>"12345678"
        ]);

       
     
    }
}
