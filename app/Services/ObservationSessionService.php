<?php

namespace App\Services;

use App\Models\ObservationSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ObservationSessionService
{
    public function getFilteredSessions(array $filters): LengthAwarePaginator
    {
        return ObservationSession::with(['targetObject', 'location', 'equipments'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('session_code', 'like', "%{$search}%")
                      ->orWhere('session_name', 'like', "%{$search}%")
                      ->orWhereHas('location', fn($loc) => $loc->where('location_name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['target_object_id'] ?? null, function ($query, $targetId) {
                $query->where('target_object_id', $targetId);
            })
            ->when($filters['weather_condition'] ?? null, function ($query, $weather) {
                $query->where('weather_condition', $weather);
            })
            ->latest('observation_date')
            ->paginate(10)
            ->withQueryString();
    }

    public function createSession(array $data): ObservationSession
    {
        return DB::transaction(function () use ($data) {
            $session = ObservationSession::create([
                'session_code'      => $data['session_code'],
                'session_name'      => $data['session_name'],
                'target_object_id'  => $data['target_object_id'],
                'observation_date'  => $data['observation_date'],
                'weather_condition' => $data['weather_condition'],
                'notes'             => $data['notes'] ?? null,
            ]);

            $session->location()->create([
                'location_name'  => $data['location_name'],
                'latitude'       => $data['latitude'],
                'longitude'      => $data['longitude'],
                'elevation_masl' => $data['elevation_masl'],
                'bortle_scale'   => $data['bortle_scale'],
            ]);

            $session->equipments()->sync($data['equipments']);

            return $session;
        });
    }

    public function updateSession(ObservationSession $session, array $data): ObservationSession
    {
        return DB::transaction(function () use ($session, $data) {
            $session->update([
                'session_code'      => $data['session_code'],
                'session_name'      => $data['session_name'],
                'target_object_id'  => $data['target_object_id'],
                'observation_date'  => $data['observation_date'],
                'weather_condition' => $data['weather_condition'],
                'notes'             => $data['notes'] ?? null,
            ]);

            $session->location()->updateOrCreate(
                ['observation_session_id' => $session->id],
                [
                    'location_name'  => $data['location_name'],
                    'latitude'       => $data['latitude'],
                    'longitude'      => $data['longitude'],
                    'elevation_masl' => $data['elevation_masl'],
                    'bortle_scale'   => $data['bortle_scale'],
                ]
            );

            $session->equipments()->sync($data['equipments']);

            return $session;
        });
    }

    public function deleteSession(ObservationSession $session): void
    {
        DB::transaction(function () use ($session) {
            $session->equipments()->detach();
            $session->location()->delete();
            $session->delete();
        });
    }
}