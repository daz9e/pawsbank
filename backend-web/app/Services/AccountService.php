<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    public function listForUser(User $user): Collection
    {
        return $user->accounts()->with('users')->get();
    }

    public function create(User $user, array $data): Account
    {
        $account = Account::create($data);

        $account->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return $account;
    }

    public function update(Account $account, array $data): Account
    {
        $account->update($data);

        return $account;
    }

    public function delete(Account $account): void
    {
        $account->delete();
    }

    public function invite(Account $account, User $invitedBy, int $userId): AccountInvitation
    {
        return $account->invitations()->create([
            'invited_by' => $invitedBy->id,
            'user_id' => $userId,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
            'created_at' => now(),
        ]);
    }

    public function removeMember(Account $account, User $member): void
    {
        $account->users()->detach($member->id);
    }

    public function getMemberRole(User $user, Account $account): ?string
    {
        return $user->accounts()->where('accounts.id', $account->id)->first()?->pivot?->role;
    }

    public function isMember(User $user, Account $account): bool
    {
        return $user->accounts()->where('accounts.id', $account->id)->exists();
    }
}
