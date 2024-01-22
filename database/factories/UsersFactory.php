<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsersFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'user_type' => fake()->randomElement(['밤비노', '뱅갈', '티파니', '브램블', '페르시안']),
            'join_sns_type' => fake()->randomElement(['kakao', 'google', 'facebook', 'naver']),
            'user_level' => fake()->randomElement([1, 2]),
            'age' => fake()->numberBetween(1, 15),
        ];
    }
}
