<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomLink extends Model
{
    use HasFactory;

    public $table = "random_links";

    protected $fillable = [
        'guest_number', 'expires_at', 'linkable_id', 'linkable_type',
        'token', 'type', 'suggest_id'
    ];
    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subMonth());
    }

    public function linkable()
    {
        return $this->morphTo();
    }
}
