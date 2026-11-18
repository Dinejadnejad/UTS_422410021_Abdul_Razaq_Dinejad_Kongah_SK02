<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObservationLocation extends Model
{
    protected $fillable = [
        'observation_session_id',
        'location_name',
        'latitude',
        'longitude',
        'elevation_masl',
        'bortle_scale',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ObservationSession::class, 'observation_session_id');
    }
}
