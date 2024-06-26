<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory, MassPrunable;

    public $table = "user_codes";

    protected $fillable = [
        'random_string','number_verified','user_number','code'
    ];

    public function prunable(): Builder
    {
        return static::where('created_at', '<', now()->subDay());
    }
}
