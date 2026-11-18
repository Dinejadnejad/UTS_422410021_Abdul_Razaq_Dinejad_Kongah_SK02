<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateObservationSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_code'      => [
                'required',
                'string',
                'max:30',
                Rule::unique('observation_sessions', 'session_code')->ignore($this->observation_session),
            ],
            'session_name'      => ['required', 'string', 'max:150'],
            'target_object_id'  => ['required', 'exists:target_objects,id'],
            'observation_date'  => ['required', 'date'],
            'weather_condition' => ['required', 'in:Cerah,Berawan Sebagian,Berkabut,Mendung'],
            'notes'             => ['nullable', 'string'],

            'location_name'     => ['required', 'string', 'max:120'],
            'latitude'          => ['required', 'numeric', 'between:-90,90'],
            'longitude'         => ['required', 'numeric', 'between:-180,180'],
            'elevation_masl'    => ['required', 'integer', 'min:0'],
            'bortle_scale'      => ['required', 'integer', 'between:1,9'],

            'equipments'        => ['required', 'array', 'min:1'],
            'equipments.*'      => ['exists:equipment,id'],
        ];
    }
}