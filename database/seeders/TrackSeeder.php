<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Track;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Track::create([
            'name'=>'Web Development',
        ]);
        Track::create([
            'name'=>'Cyber Security',
        ]);
        Track::create([
            'name'=>'Mobile Development',
        ]);
        Track::create([
            'name'=>'Quality assurance',
        ]);
        Track::create([
            'name'=>'Project Management',
        ]);
        Track::create([
            'name'=>'Data Science',
        ]);


    }
}
