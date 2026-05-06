<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
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
        $balinesePrefixes = ['I Wayan', 'Ni Wayan', 'I Made', 'Ni Made', 'I Nyoman', 'Ni Nyoman', 'I Ketut', 'Ni Ketut', 'Ida Bagus', 'Ida Ayu', 'Anak Agung', 'Dewa', 'Gusti', 'Putu', 'Kadek', 'Komang', 'Gede', 'Bagus', 'Ayu'];
        $baliKabupaten = ['Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem', 'Klungkung', 'Tabanan', 'Denpasar'];

        return [
            'name' => fake()->randomElement($balinesePrefixes) . ' ' . fake()->firstName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber(),
            'role' => 'member',
            'nik' => fake()->numerify('################'),
            'register_number' => 'PGSDT-' . date('Ym') . str_pad(fake()->unique()->numberBetween(1, 99999), 4, '0', STR_PAD_LEFT),
            'kabupaten' => fake()->randomElement($baliKabupaten),
            'kecamatan' => fake()->citySuffix(),
            'desa' => fake()->streetName(),
            'member_status' => fake()->randomElement(['active', 'pending', 'rejected']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
