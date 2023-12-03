<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'zip_code', 'country', 'city'];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
