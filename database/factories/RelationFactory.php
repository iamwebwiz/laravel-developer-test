<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'person_id' => Person::factory()->create()->id,
            'relative_id' => Person::factory()->create()->id,
            'relationship' => $this->faker->randomElement(['sibling', 'father', 'mother', 'spouse']),
        ];
    }
}
