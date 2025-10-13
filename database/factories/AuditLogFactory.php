<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuditLog>
 */
final class AuditLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'model_type' => fake()->randomElement([
                Customer::class,
                Order::class,
                Quote::class,
                Invoice::class,
            ]),
            'model_id' => fake()->randomNumber(),
            'action' => fake()->randomElement(['created', 'updated', 'deleted', 'restored']),
            'old_values' => [],
            'new_values' => ['name' => fake()->name()],
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
