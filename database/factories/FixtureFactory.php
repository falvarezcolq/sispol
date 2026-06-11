<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Fixture;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fixture>
 */
class FixtureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id_1' => Country::factory(),
            'country_id_2' => Country::factory(),
            'group_id' => Group::factory(),
            'match_date' => $this->faker->dateTimeBetween('2026-06-11', '2026-06-27'),
            'created_by' => User::factory(),
        ];
    }
}
