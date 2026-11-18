<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $fillable = ['code', 'name', 'type', 'specifications'];

    public function observationSessions(): BelongsToMany
    {
        return $this->belongsToMany(ObservationSession::class, 'equipment_observation_session');
    }
}
