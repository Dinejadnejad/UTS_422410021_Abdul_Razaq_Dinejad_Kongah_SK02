<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TargetObject extends Model
{
    protected $fillable = ['code', 'name', 'catalog_number', 'category', 'description'];

    public function observationSessions(): HasMany
    {
        return $this->hasMany(ObservationSession::class);
    }
}
