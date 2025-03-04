<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\CreateTripRequest;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        return response()->json(
            Trip::all()
        );
    }

    public function store(CreateTripRequest $request)
    {
        $trip = Trip::create($request->validated());
        broadcast(new MessageSent($trip));
        return response()->json();
    }
}
