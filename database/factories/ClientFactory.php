<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Client::class;
    public function definition(): array
    {
        return [
            'logo' => 'https://picsum.photos/300/300?random=' . rand(1, 10000),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact_person' => $this->faker->name(),
            'number' => preg_replace('/[^0-9]/', '', $this->faker->phoneNumber()),

        ];
    }
}
