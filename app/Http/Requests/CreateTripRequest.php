<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTripRequest extends FormRequest
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
            'from_station_id'=> 'required|exists:stations,id',
            'to_station_id'=> 'required|exists:stations,id|different:from_station_id',
            'bus_id'=> 'required|exists:buses,id',
        ];
    }
}
