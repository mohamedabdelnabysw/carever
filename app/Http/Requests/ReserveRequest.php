<?php

namespace App\Http\Requests;

use App\Models\Trip;
use App\Services\StartReservationService;
use App\Services\TripService;
use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
            'trip_id' => 'required|exists:trips,id',
            'reservation_token' => 'required'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $trip = Trip::where('reservation_token', $this->reservation_token)->find($this->trip_id);
            if (!$trip) {
                $validator->errors()->add('field', 'Token has expired');
            }
        });
    }
}
