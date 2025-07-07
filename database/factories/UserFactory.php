<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => $this->generateRandomNIP(),
            'name' => fake()->name(),
            'role_id' => rand(1, 7),
            'password' => Hash::make("password"),
            'remember_token' => Str::random(10),
        ];
    }
    public function generateRandomNIP(){
        $num = rand(1000000000, 99999999999);
        if($this->checkNIP($num)) return $this->generateRandomNIP();
        return $num;

    }
    public function checkNIP($nip){
        if(User::where('nip', $nip)->first()) return 1;
        else return 0;
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
