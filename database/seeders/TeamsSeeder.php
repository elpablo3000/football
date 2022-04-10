<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    private $teams = [
        'Kittens',
        'Puppies',
        'Birdies',
        'Bunnies'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->teams as $team) {
            DB::table('teams')->insert([
                'name' => $team
            ]);
        }
    }
}
