<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PurchaseResource;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Ticket;
use App\Jobs\PurchaseJob;

class PurchasesController extends Controller
{
     /**
     * Get all the purchases
     *
     * @return void
     */
    public function index(Request $request)
    {
        return PurchaseResource::collection(
            Purchase::filter($request->query())
                ->paginate($request->get('limit', 25))
        );
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show(Purchase $purchase, Request $request)
    {
        $purchase->load( 'tickets' );

        return new PurchaseResource($purchase);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(PurchaseRequest $request)
    {
        $purchase = Purchase::create($request->validated());

        $total_price = 0;
        foreach ($request->assistants as $key => $value) {
            $ticket = Ticket::where('uid', $value["ticket_uid"])->first();
            $ticket->update([
                "purchase_id" => $purchase->id,
                "assistant" => $value["assistant"],
            ]);
            $total_price += $ticket->price;
        }

        //Complete Purchase after 3 min
        PurchaseJob::dispatch($purchase, $total_price)
                                ->delay(now()->addMinutes(3));;

        return new PurchaseResource($purchase);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Purchase $purchase, PurchaseRequest $request)
    {
        $purchase->update($request->validated());

        return new PurchaseResource($purchase);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return response([
            'message' => 'Purchase has been deleted'
        ], 200);
    }
}
