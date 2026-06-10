<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['name' => 'United States', 'code' => 'USA'],
            ['name' => 'Canada', 'code' => 'CAN'],
            ['name' => 'Mexico', 'code' => 'MEX'],
            ['name' => 'Argentina', 'code' => 'ARG'],
            ['name' => 'Brazil', 'code' => 'BRA'],
            ['name' => 'Uruguay', 'code' => 'URY'],
            ['name' => 'Colombia', 'code' => 'COL'],
            ['name' => 'Chile', 'code' => 'CHL'],
            ['name' => 'Paraguay', 'code' => 'PRY'],
            ['name' => 'Peru', 'code' => 'PER'],
            ['name' => 'Ecuador', 'code' => 'ECU'],
            ['name' => 'Venezuela', 'code' => 'VEN'],
            ['name' => 'Bolivia', 'code' => 'BOL'],
            ['name' => 'France', 'code' => 'FRA'],
            ['name' => 'Germany', 'code' => 'DEU'],
            ['name' => 'Spain', 'code' => 'ESP'],
            ['name' => 'England', 'code' => 'ENG'],
            ['name' => 'Netherlands', 'code' => 'NLD'],
            ['name' => 'Belgium', 'code' => 'BEL'],
            ['name' => 'Italy', 'code' => 'ITA'],
            ['name' => 'Switzerland', 'code' => 'CHE'],
            ['name' => 'Portugal', 'code' => 'POR'],
            ['name' => 'Poland', 'code' => 'POL'],
            ['name' => 'Czechia', 'code' => 'CZE'],
            ['name' => 'Denmark', 'code' => 'DNK'],
            ['name' => 'Sweden', 'code' => 'SWE'],
            ['name' => 'Norway', 'code' => 'NOR'],
            ['name' => 'Ukraine', 'code' => 'UKR'],
            ['name' => 'Serbia', 'code' => 'SRB'],
            ['name' => 'Greece', 'code' => 'GRC'],
            ['name' => 'Romania', 'code' => 'ROU'],
            ['name' => 'Turkey', 'code' => 'TUR'],
            ['name' => 'Israel', 'code' => 'ISR'],
            ['name' => 'Saudi Arabia', 'code' => 'SAU'],
            ['name' => 'United Arab Emirates', 'code' => 'ARE'],
            ['name' => 'Iran', 'code' => 'IRN'],
            ['name' => 'South Korea', 'code' => 'KOR'],
            ['name' => 'Japan', 'code' => 'JPN'],
            ['name' => 'China', 'code' => 'CHN'],
            ['name' => 'Australia', 'code' => 'AUS'],
            ['name' => 'Iraq', 'code' => 'IRQ'],
            ['name' => 'Uzbekistan', 'code' => 'UZB'],
            ['name' => 'Tajikistan', 'code' => 'TJK'],
            ['name' => 'Kyrgyzstan', 'code' => 'KGZ'],
            ['name' => 'Kazakhstan', 'code' => 'KAZ'],
            ['name' => 'Bahrain', 'code' => 'BHR'],
            ['name' => 'Qatar', 'code' => 'QAT'],
            ['name' => 'Oman', 'code' => 'OMN'],
            ['name' => 'Morocco', 'code' => 'MAR'],
            ['name' => 'Egypt', 'code' => 'EGY'],
            ['name' => 'Nigeria', 'code' => 'NGA'],
            ['name' => 'Senegal', 'code' => 'SEN'],
            ['name' => 'Ghana', 'code' => 'GHA'],
            ['name' => 'Cameron', 'code' => 'CMR'],
            ['name' => 'Tunisia', 'code' => 'TUN'],
            ['name' => 'Algeria', 'code' => 'DZA'],
            ['name' => 'Ivory Coast', 'code' => 'CIV'],
            ['name' => 'Kenya', 'code' => 'KEN'],
        ]); 
        
        DB::table('groups')->insert([
            ['name' => 'Grupo A'],
            ['name' => 'Grupo B'],
            ['name' => 'Grupo C'],
            ['name' => 'Grupo D'],
            ['name' => 'Grupo E'],
            ['name' => 'Grupo F'],
            ['name' => 'Grupo G'],
            ['name' => 'Grupo H'],
            ['name' => 'Grupo I'],
            ['name' => 'Grupo J'],
            ['name' => 'Grupo K'],
            ['name' => 'Grupo L'],
        ]);

        DB::table('group_contries')->insert([
            // Group A
            ['group_id' => 1, 'country_id' => 1],
            ['group_id' => 1, 'country_id' => 14],
            ['group_id' => 1, 'country_id' => 50],
            ['group_id' => 1, 'country_id' => 42],
            // Group B
            ['group_id' => 2, 'country_id' => 5],
            ['group_id' => 2, 'country_id' => 37],
            ['group_id' => 2, 'country_id' => 33],
            ['group_id' => 2, 'country_id' => 40],
            // Group C
            ['group_id' => 3, 'country_id' => 2],
            ['group_id' => 3, 'country_id' => 15],
            ['group_id' => 3, 'country_id' => 35],
            ['group_id' => 3, 'country_id' => 41],
            // Group D
            ['group_id' => 4, 'country_id' => 39],
            ['group_id' => 4, 'country_id' => 16],
            ['group_id' => 4, 'country_id' => 28],
            ['group_id' => 4, 'country_id' => 30],
            // Group E
            ['group_id' => 5, 'country_id' => 39],
            ['group_id' => 5, 'country_id' => 34],
            ['group_id' => 5, 'country_id' => 32],
            ['group_id' => 5, 'country_id' => 27],
            // Group F
            ['group_id' => 6, 'country_id' => 3],
            ['group_id' => 6, 'country_id' => 13],
            ['group_id' => 6, 'country_id' => 44],
            ['group_id' => 6, 'country_id' => 51],
            // Group G
            ['group_id' => 7, 'country_id' => 7],
            ['group_id' => 7, 'country_id' => 17],
            ['group_id' => 7, 'country_id' => 26],
            ['group_id' => 7, 'country_id' => 36],
            // Group H
            ['group_id' => 8, 'country_id' => 38],
            ['group_id' => 8, 'country_id' => 29],
            ['group_id' => 8, 'country_id' => 31],
            ['group_id' => 8, 'country_id' => 52],
            // Group I
            ['group_id' => 9, 'country_id' => 4],
            ['group_id' => 9, 'country_id' => 18],
            ['group_id' => 9, 'country_id' => 25],
            ['group_id' => 9, 'country_id' => 43],
            // Group J
            ['group_id' => 10, 'country_id' => 6],
            ['group_id' => 10, 'country_id' => 19],
            ['group_id' => 10, 'country_id' => 24],
            ['group_id' => 10, 'country_id' => 45],
            // Group K
            ['group_id' => 11, 'country_id' => 8],
            ['group_id' => 11, 'country_id' => 20],
            ['group_id' => 11, 'country_id' => 23],
            ['group_id' => 11, 'country_id' => 46],
            // Group L
            ['group_id' => 12, 'country_id' => 9],
            ['group_id' => 12, 'country_id' => 21],
            ['group_id' => 12, 'country_id' => 22],
            ['group_id' => 12, 'country_id' => 47],
        ]);


        DB::table('fixtures')->insert([
            // Group A
            ['country_id_1' => 1, 'country_id_2' => 14, 'group_id' => 1, 'match_date' => '2026-11-21 18:00:00'],
            ['country_id_1' => 50, 'country_id_2' => 42, 'group_id' => 1, 'match_date' => '2026-11-21 21:00:00'],
            ['country_id_1' => 1, 'country_id_2' => 50, 'group_id' => 1, 'match_date' => '2026-11-26 18:00:00'],
            ['country_id_1' => 14, 'country_id_2' => 42, 'group_id' => 1, 'match_date' => '2026-11-26 18:00:00'],
            ['country_id_1' => 14, 'country_id_2' => 50, 'group_id' => 1, 'match_date' => '2026-12-01 22:00:00'],
            ['country_id_1' => 42, 'country_id_2' => 1, 'group_id' => 1, 'match_date' => '2026-12-01 22:00:00'],
            // Group B
            ['country_id_1' => 5, 'country_id_2' => 37, 'group_id' => 2, 'match_date' => '2026-11-21 15:00:00'],
            ['country_id_1' => 33, 'country_id_2' => 40, 'group_id' => 2, 'match_date' => '2026-11-22 18:00:00'],
            ['country_id_1' => 5, 'country_id_2' => 33, 'group_id' => 2, 'match_date' => '2026-11-27 21:00:00'],
            ['country_id_1' => 37, 'country_id_2' => 40, 'group_id' => 2, 'match_date' => '2026-11-27 21:00:00'],
            ['country_id_1' => 37, 'country_id_2' => 33, 'group_id' => 2, 'match_date' => '2026-12-02 22:00:00'],
            ['country_id_1' => 40, 'country_id_2' => 5, 'group_id' => 2, 'match_date' => '2026-12-02 22:00:00'],
            // Group C
            ['country_id_1' => 2, 'country_id_2' => 15, 'group_id' => 3, 'match_date' => '2026-11-22 15:00:00'],
            ['country_id_1' => 35, 'country_id_2' => 41, 'group_id' => 3, 'match_date' => '2026-11-22 21:00:00'],
            ['country_id_1' => 2, 'country_id_2' => 35, 'group_id' => 3, 'match_date' => '2026-11-27 18:00:00'],
            ['country_id_1' => 15, 'country_id_2' => 41, 'group_id' => 3, 'match_date' => '2026-11-27 18:00:00'],
            ['country_id_1' => 15, 'country_id_2' => 35, 'group_id' => 3, 'match_date' => '2026-12-03 22:00:00'],
            ['country_id_1' => 41, 'country_id_2' => 2, 'group_id' => 3, 'match_date' => '2026-12-03 22:00:00'],
            // Group D
            ['country_id_1' => 39, 'country_id_2' => 16, 'group_id' => 4, 'match_date' => '2026-11-23 18:00:00'],
            ['country_id_1' => 28, 'country_id_2' => 30, 'group_id' => 4, 'match_date' => '2026-11-23 21:00:00'],
            ['country_id_1' => 39, 'country_id_2' => 28, 'group_id' => 4, 'match_date' => '2026-11-28 18:00:00'],
            ['country_id_1' => 16, 'country_id_2' => 30, 'group_id' => 4, 'match_date' => '2026-11-28 18:00:00'],
            ['country_id_1' => 16, 'country_id_2' => 28, 'group_id' => 4, 'match_date' => '2026-12-04 22:00:00'],
            ['country_id_1' => 30, 'country_id_2' => 39, 'group_id' => 4, 'match_date' => '2026-12-04 22:00:00'],
            // Group E
            ['country_id_1' => 39, 'country_id_2' => 34, 'group_id' => 5, 'match_date' => '2026-11-24 18:00:00'],
            ['country_id_1' => 32, 'country_id_2' => 27, 'group_id' => 5, 'match_date' => '2026-11-24 21:00:00'],
            ['country_id_1' => 39, 'country_id_2' => 32, 'group_id' => 5, 'match_date' => '2026-11-29 21:00:00'],
            ['country_id_1' => 34, 'country_id_2' => 27, 'group_id' => 5, 'match_date' => '2026-11-29 21:00:00'],
            ['country_id_1' => 34, 'country_id_2' => 32, 'group_id' => 5, 'match_date' => '2026-12-05 22:00:00'],
            ['country_id_1' => 27, 'country_id_2' => 39, 'group_id' => 5, 'match_date' => '2026-12-05 22:00:00'],
            // Group F
            ['country_id_1' => 3, 'country_id_2' => 13, 'group_id' => 6, 'match_date' => '2026-11-25 18:00:00'],
            ['country_id_1' => 44, 'country_id_2' => 51, 'group_id' => 6, 'match_date' => '2026-11-25 21:00:00'],
            ['country_id_1' => 3, 'country_id_2' => 44, 'group_id' => 6, 'match_date' => '2026-11-30 18:00:00'],
            ['country_id_1' => 13, 'country_id_2' => 51, 'group_id' => 6, 'match_date' => '2026-11-30 18:00:00'],
            ['country_id_1' => 13, 'country_id_2' => 44, 'group_id' => 6, 'match_date' => '2026-12-06 22:00:00'],
            ['country_id_1' => 51, 'country_id_2' => 3, 'group_id' => 6, 'match_date' => '2026-12-06 22:00:00'],
            // Group G
            ['country_id_1' => 7, 'country_id_2' => 17, 'group_id' => 7, 'match_date' => '2026-11-22 18:00:00'],
            ['country_id_1' => 26, 'country_id_2' => 36, 'group_id' => 7, 'match_date' => '2026-11-23 15:00:00'],
            ['country_id_1' => 7, 'country_id_2' => 26, 'group_id' => 7, 'match_date' => '2026-11-28 21:00:00'],
            ['country_id_1' => 17, 'country_id_2' => 36, 'group_id' => 7, 'match_date' => '2026-11-28 21:00:00'],
            ['country_id_1' => 17, 'country_id_2' => 26, 'group_id' => 7, 'match_date' => '2026-12-07 22:00:00'],
            ['country_id_1' => 36, 'country_id_2' => 7, 'group_id' => 7, 'match_date' => '2026-12-07 22:00:00'],
            // Group H
            ['country_id_1' => 38, 'country_id_2' => 29, 'group_id' => 8, 'match_date' => '2026-11-24 15:00:00'],
            ['country_id_1' => 31, 'country_id_2' => 52, 'group_id' => 8, 'match_date' => '2026-11-25 15:00:00'],
            ['country_id_1' => 38, 'country_id_2' => 31, 'group_id' => 8, 'match_date' => '2026-11-29 18:00:00'],
            ['country_id_1' => 29, 'country_id_2' => 52, 'group_id' => 8, 'match_date' => '2026-11-29 18:00:00'],
            ['country_id_1' => 29, 'country_id_2' => 31, 'group_id' => 8, 'match_date' => '2026-12-08 22:00:00'],
            ['country_id_1' => 52, 'country_id_2' => 38, 'group_id' => 8, 'match_date' => '2026-12-08 22:00:00'],
            // Group I
            ['country_id_1' => 4, 'country_id_2' => 18, 'group_id' => 9, 'match_date' => '2026-11-21 18:00:00'],
            ['country_id_1' => 25, 'country_id_2' => 43, 'group_id' => 9, 'match_date' => '2026-11-22 18:00:00'],
            ['country_id_1' => 4, 'country_id_2' => 25, 'group_id' => 9, 'match_date' => '2026-11-26 21:00:00'],
            ['country_id_1' => 18, 'country_id_2' => 43, 'group_id' => 9, 'match_date' => '2026-11-26 21:00:00'],
            ['country_id_1' => 18, 'country_id_2' => 25, 'group_id' => 9, 'match_date' => '2026-12-01 22:00:00'],
            ['country_id_1' => 43, 'country_id_2' => 4, 'group_id' => 9, 'match_date' => '2026-12-01 22:00:00'],
            // Group J
            ['country_id_1' => 6, 'country_id_2' => 19, 'group_id' => 10, 'match_date' => '2026-11-21 15:00:00'],
            ['country_id_1' => 24, 'country_id_2' => 45, 'group_id' => 10, 'match_date' => '2026-11-23 18:00:00'],
            ['country_id_1' => 6, 'country_id_2' => 24, 'group_id' => 10, 'match_date' => '2026-11-26 18:00:00'],
            ['country_id_1' => 19, 'country_id_2' => 45, 'group_id' => 10, 'match_date' => '2026-11-26 18:00:00'],
            ['country_id_1' => 19, 'country_id_2' => 24, 'group_id' => 10, 'match_date' => '2026-12-02 22:00:00'],
            ['country_id_1' => 45, 'country_id_2' => 6, 'group_id' => 10, 'match_date' => '2026-12-02 22:00:00'],
            // Group K
            ['country_id_1' => 8, 'country_id_2' => 20, 'group_id' => 11, 'match_date' => '2026-11-23 15:00:00'],
            ['country_id_1' => 23, 'country_id_2' => 46, 'group_id' => 11, 'match_date' => '2026-11-24 21:00:00'],
            ['country_id_1' => 8, 'country_id_2' => 23, 'group_id' => 11, 'match_date' => '2026-11-28 18:00:00'],
            ['country_id_1' => 20, 'country_id_2' => 46, 'group_id' => 11, 'match_date' => '2026-11-28 18:00:00'],
            ['country_id_1' => 20, 'country_id_2' => 23, 'group_id' => 11, 'match_date' => '2026-12-03 22:00:00'],
            ['country_id_1' => 46, 'country_id_2' => 8, 'group_id' => 11, 'match_date' => '2026-12-03 22:00:00'],
            // Group L
            ['country_id_1' => 9, 'country_id_2' => 21, 'group_id' => 12, 'match_date' => '2026-11-25 15:00:00'],
            ['country_id_1' => 22, 'country_id_2' => 47, 'group_id' => 12, 'match_date' => '2026-11-25 21:00:00'],
            ['country_id_1' => 9, 'country_id_2' => 22, 'group_id' => 12, 'match_date' => '2026-11-30 21:00:00'],
            ['country_id_1' => 21, 'country_id_2' => 47, 'group_id' => 12, 'match_date' => '2026-11-30 21:00:00'],
            ['country_id_1' => 21, 'country_id_2' => 22, 'group_id' => 12, 'match_date' => '2026-12-04 22:00:00'],
            ['country_id_1' => 47, 'country_id_2' => 9, 'group_id' => 12, 'match_date' => '2026-12-04 22:00:00'],
            
        ]);

    }
}
