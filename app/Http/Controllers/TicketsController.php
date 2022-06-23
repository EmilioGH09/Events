<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TicketResource;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\Event;

class TicketsController extends Controller
{
     /**
     * Get all the tickets
     *
     * @return void
     */
    public function index(Request $request)
    {
        return TicketResource::collection(
            Ticket::filter($request->query())
                ->paginate($request->get('limit', 25))
        );
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show(Ticket $ticket, Request $request)
    {
        $ticket->load( ['event', 'purchase'] );

        return new TicketResource($ticket);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Event $event, TicketRequest $request)
    {
        $number = $request->number ?? 1;
        $tickets = array_fill(1, $number, $request->validated()); 
        $tickets = $event->tickets()->createMany($tickets);

        return TicketResource::collection($tickets);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Ticket $ticket, TicketRequest $request)
    {
        $ticket->update($request->validated());

        return new TicketResource($ticket);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response([
            'message' => 'Ticket has been deleted'
        ], 200);
    }
}
