<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ObservationSession extends Model
{
    protected $fillable = [
        'session_code',
        'session_name',
        'target_object_id',
        'observation_date',
        'weather_condition',
        'notes',
    ];

    protected $casts = [
        'observation_date' => 'date',
    ];

    public function targetObject(): BelongsTo
    {
        return $this->belongsTo(TargetObject::class);
    }

    public function location(): HasOne
    {
        return $this->hasOne(ObservationLocation::class);
    }

    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'equipment_observation_session');
    }
}
