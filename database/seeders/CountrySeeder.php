<?php

namespace Database\Seeders;

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
            // Group A
            ['name' => 'Mexico', 'code' => 'MEX','flag' => '🇲🇽'],
            ['name' => 'Korea del Sur', 'code' => 'KOR', 'flag' => '🇰🇷'],
            ['name' => 'República Checa', 'code' => 'CZE', 'flag' => '🇨🇿'],
            ['name' => 'Sudáfrica', 'code' => 'ZAF', 'flag' => '🇿🇦'],
            // Group B
            ['name' => 'Canadá', 'code' => 'CAN', 'flag' => '🇨🇦'],
            ['name' => 'Bosnia y Herzegovina', 'code' => 'BIH', 'flag' => '🇧🇦'],
            ['name' => 'Suiza', 'code' => 'CHE', 'flag' => '🇨🇭'],
            ['name' => 'Catar', 'code' => 'QAT', 'flag' => '🇶🇦'],
            // Group C
            ['name' => 'Brasil', 'code' => 'BRA', 'flag' => '🇧🇷'],
            ['name' => 'Marruecos', 'code' => 'MAR', 'flag' => '🇲🇦'],
            ['name' => 'Escocia', 'code' => 'SCO', 'flag' => '🏴'],
            ['name' => 'Haití', 'code' => 'HTI', 'flag' => '🇭🇹'],
            // Group D
            ['name' => 'Estados Unidos', 'code' => 'USA', 'flag' => '🇺🇸'],
            ['name' => 'Paraguay', 'code' => 'PRY', 'flag' => '🇵🇾'],
            ['name' => 'Australia', 'code' => 'AUS', 'flag' => '🇦🇺'],
            ['name' => 'Turquía', 'code' => 'TUR', 'flag' => '🇹🇷'],
            // Group E
            ['name' => 'Alemania', 'code' => 'DEU', 'flag' => '🇩🇪'],
            ['name' => 'Curaçao', 'code' => 'CUW', 'flag' => '🇨🇼'],
            ['name' => 'Costa de Marfil', 'code' => 'CIV', 'flag' => '🇨🇮'],
            ['name' => 'Ecuador', 'code' => 'ECU', 'flag' => '🇪🇨'],
            // Group F
            ['name' => 'Países Bajos', 'code' => 'NLD', 'flag' => '🇳🇱'],
            ['name' => 'Japón', 'code' => 'JPN', 'flag' => '🇯🇵'],
            ['name' => 'Suecia', 'code' => 'SWE', 'flag' => '🇸🇪'],
            ['name' => 'Túnez', 'code' => 'TUN', 'flag' => '🇹🇳'],
            // Group G
            ['name' => 'Bélgica', 'code' => 'BEL', 'flag' => '🇧🇪'],
            ['name' => 'Egipto', 'code' => 'EGY', 'flag' => '🇪🇬'],
            ['name' => 'Irán', 'code' => 'IRN', 'flag' => '🇮🇷'],
            ['name' => 'Nueva Zelanda', 'code' => 'NZL', 'flag' => '🇳🇿'],
            // Group H
            ['name' => 'España', 'code' => 'ESP', 'flag' => '🇪🇸'],
            ['name' => 'Cabo Verde', 'code' => 'CPV', 'flag' => '🇨🇻'],
            ['name' => 'Arabia Saudita', 'code' => 'SAU', 'flag' => '🇸🇦'],
            ['name' => 'Uruguay', 'code' => 'URY', 'flag' => '🇺🇾'],
            // Group I
            ['name' => 'Francia', 'code' => 'FRA', 'flag' => '🇫🇷'],
            ['name' => 'Senegal', 'code' => 'SEN', 'flag' => '🇸🇳'],
            ['name' => 'Irak', 'code' => 'IRQ', 'flag' => '🇮🇶'],
            ['name' => 'Noruega', 'code' => 'NOR', 'flag' => '🇳🇴'],
            // Group J
            ['name' => 'Argentina', 'code' => 'ARG', 'flag' => '🇦🇷'],
            ['name' => 'Argelia', 'code' => 'DZA', 'flag' => '🇩🇿'], 
            ['name' => 'Austria', 'code' => 'AUT', 'flag' => '🇦🇹'],
            ['name' => 'Jordania', 'code' => 'JOR', 'flag' => '🇯🇴'],
            // Group K
            ['name' => 'Portugal', 'code' => 'POR', 'flag' => '🇵🇹'],
            ['name' => 'RD Congo', 'code' => 'COD', 'flag' => '🇨🇩'],
            ['name' => 'Uzbekistán', 'code' => 'UZB', 'flag' => '🇺🇿'],
            ['name' => 'Colombia', 'code' => 'COL', 'flag' => '🇨🇴'],
            // Group L
            ['name' => 'Inglaterra', 'code' => 'ENG', 'flag' => '🏴'],
            ['name' => 'Croacia', 'code' => 'HRV', 'flag' => '🇭🇷'],
            ['name' => 'Ghana', 'code' => 'GHA', 'flag' => '🇬🇭'],
            ['name' => 'Panamá', 'code' => 'PAN', 'flag' => '🇵🇦'],
        ]);

        DB::table('groups')->insert([
            ['name' => 'Group A'],
            ['name' => 'Group B'],
            ['name' => 'Group C'],
            ['name' => 'Group D'],
            ['name' => 'Group E'],
            ['name' => 'Group F'],
            ['name' => 'Group G'],
            ['name' => 'Group H'],
            ['name' => 'Group I'],
            ['name' => 'Group J'],
            ['name' => 'Group K'],
            ['name' => 'Group L'],
        ]);

        DB::table('group_contries')->insert([
            // Group A
            ['group_id' => 1, 'country_id' => 1],  // Mexico
            ['group_id' => 1, 'country_id' => 2],  // South Korea
            ['group_id' => 1, 'country_id' => 3],  // Czech Republic
            ['group_id' => 1, 'country_id' => 4],  // South Africa
            // Group B
            ['group_id' => 2, 'country_id' => 5],  // Canada
            ['group_id' => 2, 'country_id' => 6],  // Bosnia and Herzegovina
            ['group_id' => 2, 'country_id' => 7],  // Switzerland
            ['group_id' => 2, 'country_id' => 8],  // Qatar
            // Group C
            ['group_id' => 3, 'country_id' => 9],  // Brazil
            ['group_id' => 3, 'country_id' => 10], // Morocco
            ['group_id' => 3, 'country_id' => 11], // Scotland
            ['group_id' => 3, 'country_id' => 12], // Haiti
            // Group D
            ['group_id' => 4, 'country_id' => 13], // United States
            ['group_id' => 4, 'country_id' => 14], // Paraguay
            ['group_id' => 4, 'country_id' => 15], // Australia
            ['group_id' => 4, 'country_id' => 16], // Turkey
            // Group E
            ['group_id' => 5, 'country_id' => 17], // Germany
            ['group_id' => 5, 'country_id' => 18], // Curaçao
            ['group_id' => 5, 'country_id' => 19], // Ivory Coast
            ['group_id' => 5, 'country_id' => 20], // Ecuador
            // Group F
            ['group_id' => 6, 'country_id' => 21], // Netherlands
            ['group_id' => 6, 'country_id' => 22], // Japan
            ['group_id' => 6, 'country_id' => 23], // Sweden
            ['group_id' => 6, 'country_id' => 24], // Tunisia
            // Group G
            ['group_id' => 7, 'country_id' => 25], // Belgium
            ['group_id' => 7, 'country_id' => 26], // Egypt
            ['group_id' => 7, 'country_id' => 27], // Iran
            ['group_id' => 7, 'country_id' => 28], // New Zealand
            // Group H
            ['group_id' => 8, 'country_id' => 29], // Spain
            ['group_id' => 8, 'country_id' => 30], // Cape Verde
            ['group_id' => 8, 'country_id' => 31], // Saudi Arabia
            ['group_id' => 8, 'country_id' => 32], // Uruguay
            // Group I
            ['group_id' => 9, 'country_id' => 33], // France
            ['group_id' => 9, 'country_id' => 34], // Senegal
            ['group_id' => 9, 'country_id' => 35], // Iraq
            ['group_id' => 9, 'country_id' => 36], // Norway
            // Group J
            ['group_id' => 10, 'country_id' => 37], // Argentina
            ['group_id' => 10, 'country_id' => 38], // Algeria
            ['group_id' => 10, 'country_id' => 39], // Austria
            ['group_id' => 10, 'country_id' => 40], // Jordan
            // Group K
            ['group_id' => 11, 'country_id' => 41], // Portugal
            ['group_id' => 11, 'country_id' => 42], // DR Congo
            ['group_id' => 11, 'country_id' => 43], // Uzbekistan
            ['group_id' => 11, 'country_id' => 44], // Colombia
            // Group L
            ['group_id' => 12, 'country_id' => 45], // England
            ['group_id' => 12, 'country_id' => 46], // Croatia
            ['group_id' => 12, 'country_id' => 47], // Ghana
            ['group_id' => 12, 'country_id' => 48], // Panama
        ]);

        DB::table('fixtures')->insert([
            // Group A
            ['country_id_1' => 1, 'country_id_2' => 2, 'group_id' => 1, 'match_date' => '2026-06-11 20:00:00'],  // Mexico vs South Korea
            ['country_id_1' => 2, 'country_id_2' => 3, 'group_id' => 1, 'match_date' => '2026-06-11 20:00:00'],  // South Korea vs Czech Republic
            ['country_id_1' => 1, 'country_id_2' => 3, 'group_id' => 1, 'match_date' => '2026-06-18 19:00:00'],  // Mexico vs Czech Republic
            ['country_id_1' => 2, 'country_id_2' => 1, 'group_id' => 1, 'match_date' => '2026-06-18 19:00:00'],  // South Korea vs Mexico
            ['country_id_1' => 3, 'country_id_2' => 1, 'group_id' => 1, 'match_date' => '2026-06-24 19:00:00'],  // Czech Republic vs Mexico
            ['country_id_1' => 4, 'country_id_2' => 2, 'group_id' => 1, 'match_date' => '2026-06-24 19:00:00'],  // South Africa vs South Korea
            // Group B
            ['country_id_1' => 5, 'country_id_2' => 6, 'group_id' => 2, 'match_date' => '2026-06-12 15:00:00'],  // Canada vs Bosnia and Herzegovina
            ['country_id_1' => 8, 'country_id_2' => 7, 'group_id' => 2, 'match_date' => '2026-06-13 12:00:00'],  // Qatar vs Switzerland
            ['country_id_1' => 5, 'country_id_2' => 8, 'group_id' => 2, 'match_date' => '2026-06-18 15:00:00'],  // Canada vs Qatar
            ['country_id_1' => 7, 'country_id_2' => 6, 'group_id' => 2, 'match_date' => '2026-06-18 12:00:00'],  // Switzerland vs Bosnia and Herzegovina
            ['country_id_1' => 7, 'country_id_2' => 5, 'group_id' => 2, 'match_date' => '2026-06-24 12:00:00'],  // Switzerland vs Canada
            ['country_id_1' => 6, 'country_id_2' => 8, 'group_id' => 2, 'match_date' => '2026-06-24 12:00:00'],  // Bosnia and Herzegovina vs Qatar
            // Group C
            ['country_id_1' => 9, 'country_id_2' => 10, 'group_id' => 3, 'match_date' => '2026-06-13 18:00:00'],  // Brazil vs Morocco
            ['country_id_1' => 12, 'country_id_2' => 11, 'group_id' => 3, 'match_date' => '2026-06-13 21:00:00'],  // Haiti vs Scotland
            ['country_id_1' => 9, 'country_id_2' => 12, 'group_id' => 3, 'match_date' => '2026-06-19 20:30:00'],  // Brazil vs Haiti
            ['country_id_1' => 11, 'country_id_2' => 10, 'group_id' => 3, 'match_date' => '2026-06-19 18:00:00'],  // Scotland vs Morocco
            ['country_id_1' => 11, 'country_id_2' => 9, 'group_id' => 3, 'match_date' => '2026-06-24 18:00:00'],  // Scotland vs Brazil
            ['country_id_1' => 10, 'country_id_2' => 12, 'group_id' => 3, 'match_date' => '2026-06-24 18:00:00'],  // Morocco vs Haiti
            // Group D
            ['country_id_1' => 13, 'country_id_2' => 14, 'group_id' => 4, 'match_date' => '2026-06-12 18:00:00'],  // USA vs Paraguay
            ['country_id_1' => 15, 'country_id_2' => 16, 'group_id' => 4, 'match_date' => '2026-06-13 21:00:00'],  // Australia vs Turkey
            ['country_id_1' => 13, 'country_id_2' => 15, 'group_id' => 4, 'match_date' => '2026-06-19 12:00:00'],  // USA vs Australia
            ['country_id_1' => 16, 'country_id_2' => 14, 'group_id' => 4, 'match_date' => '2026-06-19 20:00:00'],  // Turkey vs Paraguay
            ['country_id_1' => 16, 'country_id_2' => 13, 'group_id' => 4, 'match_date' => '2026-06-25 19:00:00'],  // Turkey vs USA
            ['country_id_1' => 14, 'country_id_2' => 15, 'group_id' => 4, 'match_date' => '2026-06-25 19:00:00'],  // Paraguay vs Australia
            // Group E
            ['country_id_1' => 17, 'country_id_2' => 18, 'group_id' => 5, 'match_date' => '2026-06-14 12:00:00'],  // Germany vs Curaçao
            ['country_id_1' => 19, 'country_id_2' => 20, 'group_id' => 5, 'match_date' => '2026-06-14 19:00:00'],  // Ivory Coast vs Ecuador
            ['country_id_1' => 17, 'country_id_2' => 19, 'group_id' => 5, 'match_date' => '2026-06-20 16:00:00'],  // Germany vs Ivory Coast
            ['country_id_1' => 20, 'country_id_2' => 18, 'group_id' => 5, 'match_date' => '2026-06-20 19:00:00'],  // Ecuador vs Curaçao
            ['country_id_1' => 18, 'country_id_2' => 19, 'group_id' => 5, 'match_date' => '2026-06-25 16:00:00'],  // Curaçao vs Ivory Coast
            ['country_id_1' => 20, 'country_id_2' => 17, 'group_id' => 5, 'match_date' => '2026-06-25 16:00:00'],  // Ecuador vs Germany
            // Group F
            ['country_id_1' => 21, 'country_id_2' => 22, 'group_id' => 6, 'match_date' => '2026-06-14 15:00:00'],  // Netherlands vs Japan
            ['country_id_1' => 23, 'country_id_2' => 24, 'group_id' => 6, 'match_date' => '2026-06-14 20:00:00'],  // Sweden vs Tunisia
            ['country_id_1' => 21, 'country_id_2' => 23, 'group_id' => 6, 'match_date' => '2026-06-20 12:00:00'],  // Netherlands vs Sweden
            ['country_id_1' => 24, 'country_id_2' => 22, 'group_id' => 6, 'match_date' => '2026-06-20 22:00:00'],  // Tunisia vs Japan
            ['country_id_1' => 22, 'country_id_2' => 23, 'group_id' => 6, 'match_date' => '2026-06-25 18:00:00'],  // Japan vs Sweden
            ['country_id_1' => 24, 'country_id_2' => 21, 'group_id' => 6, 'match_date' => '2026-06-25 18:00:00'],  // Tunisia vs Netherlands
            // Group G
            ['country_id_1' => 25, 'country_id_2' => 26, 'group_id' => 7, 'match_date' => '2026-06-15 12:00:00'],  // Belgium vs Egypt
            ['country_id_1' => 27, 'country_id_2' => 28, 'group_id' => 7, 'match_date' => '2026-06-15 18:00:00'],  // Iran vs New Zealand
            ['country_id_1' => 25, 'country_id_2' => 27, 'group_id' => 7, 'match_date' => '2026-06-21 12:00:00'],  // Belgium vs Iran
            ['country_id_1' => 28, 'country_id_2' => 26, 'group_id' => 7, 'match_date' => '2026-06-21 18:00:00'],  // New Zealand vs Egypt
            ['country_id_1' => 26, 'country_id_2' => 27, 'group_id' => 7, 'match_date' => '2026-06-26 20:00:00'],  // Egypt vs Iran
            ['country_id_1' => 28, 'country_id_2' => 25, 'group_id' => 7, 'match_date' => '2026-06-26 20:00:00'],  // New Zealand vs Belgium
            // Group H
            ['country_id_1' => 29, 'country_id_2' => 30, 'group_id' => 8, 'match_date' => '2026-06-15 12:00:00'],  // Spain vs Cape Verde
            ['country_id_1' => 31, 'country_id_2' => 32, 'group_id' => 8, 'match_date' => '2026-06-15 18:00:00'],  // Saudi Arabia vs Uruguay
            ['country_id_1' => 29, 'country_id_2' => 31, 'group_id' => 8, 'match_date' => '2026-06-21 12:00:00'],  // Spain vs Saudi Arabia
            ['country_id_1' => 32, 'country_id_2' => 30, 'group_id' => 8, 'match_date' => '2026-06-21 18:00:00'],  // Uruguay vs Cape Verde
            ['country_id_1' => 30, 'country_id_2' => 31, 'group_id' => 8, 'match_date' => '2026-06-26 13:00:00'],  // Cape Verde vs Saudi Arabia
            ['country_id_1' => 32, 'country_id_2' => 29, 'group_id' => 8, 'match_date' => '2026-06-26 18:00:00'],  // Uruguay vs Spain
            // Group I
            ['country_id_1' => 33, 'country_id_2' => 34, 'group_id' => 9, 'match_date' => '2026-06-16 15:00:00'],  // France vs Senegal
            ['country_id_1' => 35, 'country_id_2' => 36, 'group_id' => 9, 'match_date' => '2026-06-16 18:00:00'],  // Iraq vs Norway
            ['country_id_1' => 33, 'country_id_2' => 35, 'group_id' => 9, 'match_date' => '2026-06-22 17:00:00'],  // France vs Iraq
            ['country_id_1' => 36, 'country_id_2' => 34, 'group_id' => 9, 'match_date' => '2026-06-22 20:00:00'],  // Norway vs Senegal
            ['country_id_1' => 36, 'country_id_2' => 33, 'group_id' => 9, 'match_date' => '2026-06-26 15:00:00'],  // Norway vs France
            ['country_id_1' => 34, 'country_id_2' => 35, 'group_id' => 9, 'match_date' => '2026-06-26 15:00:00'],  // Senegal vs Iraq
            // Group J
            ['country_id_1' => 37, 'country_id_2' => 38, 'group_id' => 10, 'match_date' => '2026-06-16 20:00:00'],  // Argentina vs Algeria
            ['country_id_1' => 39, 'country_id_2' => 40, 'group_id' => 10, 'match_date' => '2026-06-16 21:00:00'],  // Austria vs Jordan
            ['country_id_1' => 37, 'country_id_2' => 39, 'group_id' => 10, 'match_date' => '2026-06-22 12:00:00'],  // Argentina vs Austria
            ['country_id_1' => 40, 'country_id_2' => 38, 'group_id' => 10, 'match_date' => '2026-06-22 20:00:00'],  // Jordan vs Algeria
            ['country_id_1' => 38, 'country_id_2' => 39, 'group_id' => 10, 'match_date' => '2026-06-27 21:00:00'],  // Algeria vs Austria
            ['country_id_1' => 40, 'country_id_2' => 37, 'group_id' => 10, 'match_date' => '2026-06-27 21:00:00'],  // Jordan vs Argentina
            // Group K
            ['country_id_1' => 41, 'country_id_2' => 42, 'group_id' => 11, 'match_date' => '2026-06-17 12:00:00'],  // Portugal vs DR Congo
            ['country_id_1' => 43, 'country_id_2' => 44, 'group_id' => 11, 'match_date' => '2026-06-17 20:00:00'],  // Uzbekistan vs Colombia
            ['country_id_1' => 41, 'country_id_2' => 43, 'group_id' => 11, 'match_date' => '2026-06-23 12:00:00'],  // Portugal vs Uzbekistan
            ['country_id_1' => 44, 'country_id_2' => 42, 'group_id' => 11, 'match_date' => '2026-06-23 20:00:00'],  // Colombia vs DR Congo
            ['country_id_1' => 44, 'country_id_2' => 41, 'group_id' => 11, 'match_date' => '2026-06-27 19:30:00'],  // Colombia vs Portugal
            ['country_id_1' => 42, 'country_id_2' => 43, 'group_id' => 11, 'match_date' => '2026-06-27 19:30:00'],  // DR Congo vs Uzbekistan
            // Group L
            ['country_id_1' => 45, 'country_id_2' => 46, 'group_id' => 12, 'match_date' => '2026-06-17 15:00:00'],  // England vs Croatia
            ['country_id_1' => 47, 'country_id_2' => 48, 'group_id' => 12, 'match_date' => '2026-06-17 19:00:00'],  // Ghana vs Panama
            ['country_id_1' => 45, 'country_id_2' => 47, 'group_id' => 12, 'match_date' => '2026-06-23 16:00:00'],  // England vs Ghana
            ['country_id_1' => 48, 'country_id_2' => 46, 'group_id' => 12, 'match_date' => '2026-06-23 19:00:00'],  // Panama vs Croatia
            ['country_id_1' => 48, 'country_id_2' => 45, 'group_id' => 12, 'match_date' => '2026-06-27 17:00:00'],  // Panama vs England
            ['country_id_1' => 46, 'country_id_2' => 47, 'group_id' => 12, 'match_date' => '2026-06-27 17:00:00'],  // Croatia vs Ghana
        ]);

    }
}
