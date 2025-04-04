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
            "password" => bcrypt("12345678")
        ]);
        User::create([
            "full_name"=>"Jawdat Reslan",
            "email"=>"jawdatreslan@gmail.com",
            "password" => bcrypt("12345678")
        ]);


        User::create([
            "full_name" => "John Doe",
            "email" => "johndoe@example.com",
            "password" => bcrypt("12345678")
        ]);
        
        User::create([
            "full_name" => "Sarah Smith",
            "email" => "sarahsmith@example.com",
            "password" => bcrypt("12345678")
        ]);
        
        User::create([
            "full_name" => "David Brown",
            "email" => "davidbrown@example.com",
            "password" => bcrypt("12345678")
        ]);

       
     
    }
}
