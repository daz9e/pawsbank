<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    // --- index ---

    public function test_user_can_list_their_accounts(): void
    {
        $user = User::factory()->create();
        $accounts = Account::factory()->count(2)->create();
        $accounts->each(fn (Account $account) => $account->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]));

        $response = $this->actingAs($user)->getJson('/api/accounts');

        $response->assertOk()
            ->assertJsonCount(2)
            ->assertJsonStructure([['id', 'name', 'currency_code', 'created_at']]);
    }

    public function test_user_only_sees_their_own_accounts(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $myAccount = Account::factory()->create();
        $myAccount->users()->attach($user->id, ['role' => 'owner', 'joined_at' => now()]);

        $otherAccount = Account::factory()->create();
        $otherAccount->users()->attach($other->id, ['role' => 'owner', 'joined_at' => now()]);

        $this->actingAs($user)->getJson('/api/accounts')->assertOk()->assertJsonCount(1);
    }

    public function test_list_accounts_requires_authentication(): void
    {
        $this->getJson('/api/accounts')->assertUnauthorized();
    }

    // --- store ---

    public function test_user_can_create_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/accounts', [
            'name' => 'Family Budget',
            'currency_code' => 'EUR',
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['id', 'name', 'currency_code', 'created_at']);

        $this->assertDatabaseHas('accounts', ['name' => 'Family Budget']);
        $this->assertDatabaseHas('account_users', ['user_id' => $user->id, 'role' => 'owner']);
    }

    public function test_store_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/api/accounts', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'currency_code']);
    }

    // --- update ---

    public function test_member_can_update_account(): void
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner', 'joined_at' => now()]);

        $response = $this->actingAs($user)->putJson("/api/accounts/{$account->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_cannot_update_account_user_does_not_belong_to(): void
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $this->actingAs($user)->putJson("/api/accounts/{$account->id}", ['name' => 'Hacked'])
            ->assertNotFound();
    }

    // --- destroy ---

    public function test_owner_can_delete_account(): void
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner', 'joined_at' => now()]);

        $this->actingAs($user)->deleteJson("/api/accounts/{$account->id}")
            ->assertNoContent();

        $this->assertModelMissing($account);
    }

    public function test_non_owner_cannot_delete_account(): void
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($user->id, ['role' => 'member', 'joined_at' => now()]);

        $this->actingAs($user)->deleteJson("/api/accounts/{$account->id}")
            ->assertForbidden();
    }

    // --- invite ---

    public function test_owner_can_invite_user(): void
    {
        $owner = User::factory()->create();
        $invitee = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($owner->id, ['role' => 'owner', 'joined_at' => now()]);

        $response = $this->actingAs($owner)->postJson("/api/accounts/{$account->id}/invite", [
            'user_id' => $invitee->id,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('account_invitations', [
            'account_id' => $account->id,
            'user_id' => $invitee->id,
            'status' => 'pending',
        ]);
    }

    public function test_cannot_invite_existing_member(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($owner->id, ['role' => 'owner', 'joined_at' => now()]);
        $account->users()->attach($member->id, ['role' => 'member', 'joined_at' => now()]);

        $this->actingAs($owner)->postJson("/api/accounts/{$account->id}/invite", [
            'user_id' => $member->id,
        ])->assertUnprocessable();
    }

    public function test_member_cannot_invite(): void
    {
        $member = User::factory()->create();
        $invitee = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($member->id, ['role' => 'member', 'joined_at' => now()]);

        $this->actingAs($member)->postJson("/api/accounts/{$account->id}/invite", [
            'user_id' => $invitee->id,
        ])->assertForbidden();
    }

    // --- removeMember ---

    public function test_owner_can_remove_member(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($owner->id, ['role' => 'owner', 'joined_at' => now()]);
        $account->users()->attach($member->id, ['role' => 'member', 'joined_at' => now()]);

        $this->actingAs($owner)->deleteJson("/api/accounts/{$account->id}/members/{$member->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('account_users', [
            'account_id' => $account->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_cannot_remove_yourself(): void
    {
        $owner = User::factory()->create();
        $account = Account::factory()->create();
        $account->users()->attach($owner->id, ['role' => 'owner', 'joined_at' => now()]);

        $this->actingAs($owner)->deleteJson("/api/accounts/{$account->id}/members/{$owner->id}")
            ->assertUnprocessable();
    }
}
