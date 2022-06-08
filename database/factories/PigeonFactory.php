<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PigeonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $downtime = $this->faker->numberBetween(2, 3);

        return [
            'name'                => $this->faker->name,
            'speed'               => $this->faker->numberBetween(60, 100),
            'range'               => $this->faker->numberBetween(500, 1000),
            'downtime'            => $downtime,
            'created_at'          => now(),
            'updated_at'          => now(),
        ];
    }
}
