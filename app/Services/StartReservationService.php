<?php

namespace App\Services;

use Carbon\Carbon;

class StartReservationService
{
    protected $tripService;
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }
    public function handle($tripId)
    {
        $trip = $this->tripService->find($tripId);
        if (!$trip->reservation_token || $this->isTokenPast($trip->reservation_token)) {
            return $this->createReservationToken($trip);
        }
        return null;
    }

    public function createReservationToken($trip)
    {
        $token = base64_encode(auth()->user()->id . '|' .now()->addMinutes(2));
        $this->tripService->update(['reservation_token' => $token], $trip);
        return $token;
    }
    public static function isTokenPast($token): bool
    {
        [, $dateTime] = explode('|', base64_decode($token));
        return Carbon::create($dateTime)->isPast();
    }
    public static function isTokenHasNotTheSameUser($token): bool
    {
        [$id,] = explode('|', base64_decode($token));
        return auth()->user()->id != $id; 
    }

    public static function isInValidToken($token): bool
    {
        return (self::isTokenHasNotTheSameUser($token) || self::isTokenPast($token));
    }
}
