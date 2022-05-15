<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return User::query()
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
            )
            ->when(
                $request->selected,
                fn (Builder $query) => $query->whereIn('id', $request->selected),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()
            ->map(function (User $user) {
                $user->profile_image = "https://picsum.photos/300?id={$user->id}";

                return $user;
            });
    }
}
