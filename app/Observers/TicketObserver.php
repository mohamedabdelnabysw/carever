<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\UserFrequent;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $userTripTickets = Ticket::where('user_id', $ticket->user_id)
        ->where('trip_id', $ticket->trip_id)->get();
        if ($userTripTickets->count() > 5) {
            Ticket::where('user_id', $ticket->user_id)
            ->where('trip_id', $ticket->trip_id)->update(['discount'=> 5]);
        }
        if ($userTripTickets->count() < 2) {
            $data = [
                'user_id' => $ticket->user_id,
                'from_station_id' => $ticket->trip->from_station_id,
                'to_station_id' => $ticket->trip->to_station_id,
            ];
            $userFrequent = UserFrequent::where($data)->first();
            if ($userFrequent) {
                $userFrequent->update(['count' => $userFrequent->count + 1]);
            } else {
                UserFrequent::create($data);
            }
        }
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        $userTripTickets = Ticket::where('user_id', $ticket->user_id)
        ->where('trip_id', $ticket->trip_id)->get();
        if ($userTripTickets->count() < 5) {
            Ticket::where('user_id', $ticket->user_id)
            ->where('trip_id', $ticket->trip_id)->update(['discount'=> 0]);
        }
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
