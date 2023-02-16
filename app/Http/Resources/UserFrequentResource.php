<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserFrequentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $mostFrequent = $this->userFrequents->first();
        return [
            'id' => $this->id,
            'email' => $this->email,
            'frequentBook' => $mostFrequent->fromStation->name . '-' . $mostFrequent->toStation->name
        ];
    }
}
