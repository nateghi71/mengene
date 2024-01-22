<?php

namespace App\Policies;

use App\Models\User;

class SpecialFilePolicy
{
    use FilePolicy;

    public function viewIndexBuy(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function viewIndexSub(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function viewShowSub(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function buyFile(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function viewSuggestion(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function star(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }
    public function setReminder(User $user): bool
    {
        return $user->ownedBusiness()->exists();
    }

}
