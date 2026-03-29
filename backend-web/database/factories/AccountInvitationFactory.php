<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccountInvitation>
 */
class AccountInvitationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'invited_by' => User::factory(),
            'user_id' => User::factory(),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
            'created_at' => now(),
        ];
    }

    public function accepted(): static
    {
        return $this->state(['status' => 'accepted']);
    }

    public function declined(): static
    {
        return $this->state(['status' => 'declined']);
    }

    public function expired(): static
    {
        return $this->state(['expires_at' => now()->subDay()]);
    }
}
