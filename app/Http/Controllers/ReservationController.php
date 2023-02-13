<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReserveRequest;
use App\Http\Requests\StartReservationRequest;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\Ticket;
use App\Services\StartReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $startReservationService;
    public function __construct(StartReservationService $startReservationService)
    {
        $this->startReservationService = $startReservationService;
    }
    public function store(ReserveRequest $request)
    {
        foreach ($request->validated()['seat_ids'] as $id) {
            Ticket::create([
                'seat_id' => $id,
                'trip_id' => $request->trip_id,
                'user_id' => auth()->user()->id
            ]);
        }
        return response()->json(['message'=> 'Your Reservation is done']);
    }

    public function start(StartReservationRequest $request)
    {
        $reservationToken = $this->startReservationService->handle($request->validated()['trip_id']);
        if (!$reservationToken) {
            return response()->json([
                "message" => "plase try agean leater"
            ], 403);
        }
        $resevedSeats = Ticket::where('trip_id', $request->trip_id)->get()->pluck('seat_id');
        $busId = Trip::find($request->trip_id)->bus_id;
        $availableSeats = Seat::where('bus_id', $busId)->whereNotIn('id', $resevedSeats)->get();
        return response()->json([
            "availableSeats" => $availableSeats,
            "reservation_token" => $reservationToken
        ]);
    }
    public function check(Request $request)
    {
        return response()->json(
            $this->startReservationService->checkToken($request->token)
        );
    }
}
