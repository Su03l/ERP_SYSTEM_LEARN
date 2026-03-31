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
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'employee_number' => 'EMP-' . fake()->unique()->numberBetween(1000, 99999),
            'national_id' => fake()->unique()->numerify('10########'),
            'phone' => '05' . fake()->numerify('########'),
            'emergency_contact' => '05' . fake()->numerify('########'),
            'address' => fake()->city() . ', ' . fake()->streetName(),
            'job_title' => fake()->jobTitle(),
            'department' => fake()->randomElement([
                'الموارد البشرية',
                'تقنية المعلومات',
                'المبيعات',
                'التسويق',
                'المالية والمحاسبة',
                'العمليات التشغيلية',
                'خدمة العملاء',
                'المشتريات والمخازن',
                'الشؤون القانونية',
                'الإدارة العامة'
            ]),
            'join_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'salary' => fake()->randomFloat(2, 4000, 20000),
            'bank_iban' => 'SA' . fake()->numerify('00################'),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_date' => fake()->dateTimeBetween('-50 years', '-22 years')->format('Y-m-d'),
            'role' => 'employee',
            'status' => 'active',
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
