<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Artist;

class EventsController extends Controller
{
     /**
     * Get all the events
     *
     * @return void
     */
    public function index(Request $request)
    {
        return EventResource::collection(
            Event::filter($request->query())
                ->paginate($request->get('limit', 25))
        );
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show(Event $event, Request $request)
    {
        $event->load(['artist', 'tickets']);

        return new EventResource($event);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Artist $artist, EventRequest $request)
    {
        $event = $artist->events()->create($request->validated());

        if($request->tickets_number){
            $tickets = array_fill(1, $request->tickets_number, ["price" => $request->tickets_price ]); 
            $event->tickets()->createMany($tickets);
        }

        return new EventResource($event);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Event $event, EventRequest $request)
    {
        $event->update($request->validated());

        return new EventResource($event);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy(Event $event)
    {
        $event->delete();

        return response([
            'message' => 'Event has been deleted'
        ], 200);
    }
}
