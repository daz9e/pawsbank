<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(private AccountService $accountService) {}

    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $accounts = $this->accountService->listForUser($user);

        return response()->json($accounts->map->toData());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'currency_code' => ['required', 'string', 'size:3'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $account = $this->accountService->create($user, $data);

        return response()->json($account->toData(), 201);
    }

    public function update(Request $request, Account $account): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $this->accountService->isMember($user, $account)) {
            return response()->json(['error' => 'Not found.'], 404);
        }

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'currency_code' => ['sometimes', 'string', 'size:3'],
        ]);

        $account = $this->accountService->update($account, $data);

        return response()->json($account->toData());
    }

    public function destroy(Request $request, Account $account): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($this->accountService->getMemberRole($user, $account) !== 'owner') {
            return response()->json(['error' => 'Forbidden.'], 403);
        }

        $this->accountService->delete($account);

        return response()->json(null, 204);
    }

    public function invite(Request $request, Account $account): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $role = $this->accountService->getMemberRole($user, $account);

        if (! in_array($role, ['owner', 'admin'])) {
            return response()->json(['error' => 'Forbidden.'], 403);
        }

        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        if ($account->users()->where('users.id', $data['user_id'])->exists()) {
            return response()->json(['error' => 'User is already a member.'], 422);
        }

        $invitation = $this->accountService->invite($account, $user, $data['user_id']);

        return response()->json($invitation->toData(), 201);
    }

    public function removeMember(Request $request, Account $account, User $member): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $role = $this->accountService->getMemberRole($user, $account);

        if (! in_array($role, ['owner', 'admin'])) {
            return response()->json(['error' => 'Forbidden.'], 403);
        }

        if ($member->id === $user->id) {
            return response()->json(['error' => 'Cannot remove yourself.'], 422);
        }

        $this->accountService->removeMember($account, $member);

        return response()->json(null, 204);
    }
}
