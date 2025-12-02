<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Goal>
     */
    protected $model = Goal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->words(4, true),
            'target_sessions' => $this->faker->numberBetween(5, 20),
            'deadline' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'mentor_name' => $this->faker->name(),
            'sessions_completed' => 0,
        ];
    }

    /**
     * Define state for active goals.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'sessions_completed' => $this->faker->numberBetween(0, 15),
        ]);
    }

    /**
     * Define state for completed goals.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'sessions_completed' => 20,
        ]);
    }
}
