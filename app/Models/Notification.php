<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory , MassPrunable;

    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subDays(3));
    }

}
