<?php

namespace Database\Factories;

use App\Models\LineFriend;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LineFriend>
 */
class LineFriendFactory extends Factory
{
    protected $model = LineFriend::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'line_id' => Str::random(20),
            'line_name' => $this->faker->name(),
            'line_icon_url' => $this->faker->imageUrl(),
            'created_at' => $this->faker->dateTime('now')
        ];
    }

    public function featureTestSetup(?array $attributes = []): LineFriendFactory
    {
        $params = collect($attributes);
        return $this->state(function () use ($params) {
            return [
                'line_id' => $params->get('line_id') ?? Str::random(20),
                'line_name' => $params->get('line_name') ?? $this->faker->name(),
                'line_icon_url' => $params->get('line_icon_url') ?? $this->faker->imageUrl(),
                'created_at' => $params->get('created_at') ?? $this->faker->dateTime('now')
            ];
        });
    }
}
