<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tel = str_replace('-', '', $this->faker->phoneNumber);
        $address = mb_substr($this->faker->address, 9);

        return [
            'name' => $this->faker->kanaName,
            'phone' => $tel,
            'postcode' => $this->faker->postcode,
            'address' => $address,
            'memo' => $this->faker->realText(50),

        ];
    }
}
