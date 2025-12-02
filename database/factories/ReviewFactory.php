<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Review>
     */
    protected $model = Review::class;

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
            'session_id' => null,
            'rating' => $this->faker->numberBetween(1, 5),
            'feedback' => $this->faker->paragraphs(2, true),
        ];
    }

    /**
     * Define state for 5-star reviews.
     */
    public function fiveStar(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 5,
        ]);
    }

    /**
     * Define state for 4-star reviews.
     */
    public function fourStar(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 4,
        ]);
    }

    /**
     * Define state for 1-star reviews.
     */
    public function oneStar(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => 1,
        ]);
    }
}
