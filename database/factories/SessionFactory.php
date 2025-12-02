<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Session>
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'mentor_id' => Mentor::factory(),
            'session_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'session_time' => $this->faker->time('H:i:s'),
            'duration' => $this->faker->randomElement([30, 45, 60, 90]),
            'topic' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(2, true),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'notes' => $this->faker->paragraphs(2, true),
        ];
    }

    /**
     * Define state for completed sessions.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    /**
     * Define state for pending sessions.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Define state for cancelled sessions.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
