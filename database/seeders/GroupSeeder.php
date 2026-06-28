<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

          DB::table('groups')->insert([
            ['name' => 'Eliminatorias 32'],
            ['name' => 'Eliminatorias 16'],
            ['name' => 'Eliminatorias 8'],
            ['name' => 'Cuartos de Final'],
            ['name' => 'Semifinal'],
            ['name' => 'Final'],
        ]);
    }
}
